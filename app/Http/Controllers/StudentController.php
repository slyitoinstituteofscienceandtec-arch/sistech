<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Programme;
use App\Models\Department;
use App\Models\AcademicYear;
use App\Models\Invoice;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    private function denyIfStaff()
    {
        if (auth()->check() && auth()->user()->role === 'staff') {
            abort(403, 'Staff can only view student records.');
        }
    }

    public function index(Request $request)
    {
        $query = Student::with(['user', 'programme', 'department']);

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            })->orWhere('student_id', 'like', "%{$request->search}%")
              ->orWhere('index_number', 'like', "%{$request->search}%");
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        $students = $query->latest()->paginate(20);
        $departments = Department::where('is_active', true)->get();

        return view('students.index', compact('students', 'departments'));
    }

    public function create()
    {
        $this->denyIfStaff();
        $programmes = Programme::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        $academicYears = AcademicYear::all();
        return view('students.create', compact('programmes', 'departments', 'academicYears'));
    }

    public function store(Request $request)
    {
        $this->denyIfStaff();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'programme_id' => 'required|exists:programmes,id',
            'department_id' => 'required|exists:departments,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'admission_date' => 'required|date',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'guardian_email' => 'nullable|email',
            'previous_school' => 'nullable|string',
            'qualification' => 'nullable|string',
            'national_id' => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ]);

        $plainPassword = $validated['password'] ?? Str::random(8);
        unset($validated['password']);

        $year = date('Y');
        $studentCount = Student::whereYear('created_at', $year)->count() + 1;
        $studentId = 'STU-' . $year . '-' . str_pad($studentCount, 4, '0', STR_PAD_LEFT);
        $indexNumber = 'IDX-' . $year . '-' . str_pad($studentCount, 4, '0', STR_PAD_LEFT);

        $currentYear = AcademicYear::where('is_current', true)->first();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($plainPassword),
            'role' => 'student',
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ]);

        $student = Student::create(array_merge($validated, [
            'user_id' => $user->id,
            'student_id' => $studentId,
            'index_number' => $indexNumber,
            'academic_year_id' => $validated['academic_year_id'] ?? $currentYear?->id,
            'level' => 100,
            'semester' => 1,
            'status' => 'active',
        ]));

        $this->generateInvoice($student);

        return redirect()->route('admin.students.show', $student)->with('login_credentials', [
            'name' => $user->name,
            'id' => $studentId,
            'email' => $user->email,
            'password' => $plainPassword,
        ]);
    }

    public function show(Student $student)
    {
        $student->load(['user', 'programme', 'department', 'academicYear', 'courseRegistrations.course', 'results.course', 'invoices', 'parents', 'attendances']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $this->denyIfStaff();
        $student->load('user');
        $programmes = Programme::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        return view('students.edit', compact('student', 'programmes', 'departments'));
    }

    public function update(Request $request, Student $student)
    {
        $this->denyIfStaff();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'programme_id' => 'required|exists:programmes,id',
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:active,inactive,graduated,suspended,transferred,deferred',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'guardian_email' => 'nullable|email',
        ]);

        $student->user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
        ]);

        $student->update($validated);

        return redirect()->route('admin.students.show', $student)->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $this->denyIfStaff();
        $student->user->delete();
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    private function generateInvoice(Student $student): void
    {
        $currentYear = AcademicYear::where('is_current', true)->first();
        if (!$currentYear) return;

        $feeStructure = FeeStructure::where('programme_id', $student->programme_id)
            ->where('academic_year_id', $currentYear->id)
            ->first();

        if (!$feeStructure) return;

        $existingInvoice = Invoice::where('student_id', $student->id)
            ->where('academic_year_id', $currentYear->id)
            ->first();

        if ($existingInvoice) return;

        Invoice::create([
            'invoice_number' => Invoice::generateNumber(),
            'student_id' => $student->id,
            'academic_year_id' => $currentYear->id,
            'description' => $feeStructure->description ?? 'Tuition fees for ' . $currentYear->name,
            'amount' => $feeStructure->amount,
            'paid_amount' => 0,
            'balance' => $feeStructure->amount,
            'due_date' => $currentYear->end_date,
            'status' => 'unpaid',
        ]);
    }
}
