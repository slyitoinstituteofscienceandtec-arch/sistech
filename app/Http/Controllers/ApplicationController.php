<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\Student;
use App\Models\Programme;
use App\Models\AcademicYear;
use App\Models\Invoice;
use App\Models\FeeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with('programme');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(15);
        $pendingCount = Application::where('status', 'pending')->count();
        $approvedCount = Application::where('status', 'approved')->count();
        $rejectedCount = Application::where('status', 'rejected')->count();

        return view('admin.applications.index', compact('applications', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function show(Application $application)
    {
        $application->load('programme', 'reviewedBy');
        return view('admin.applications.show', compact('application'));
    }

    public function approve(Application $application)
    {
        if ($application->status !== 'pending') {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $plainPassword = Str::random(8);

        $existingUser = User::where('email', $application->email)->first();

        if ($existingUser) {
            $existingStudent = Student::where('user_id', $existingUser->id)->first();
            if ($existingStudent) {
                $application->update([
                    'status' => 'approved',
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                ]);
                return back()->with('error', "A student account already exists for this email ({$existingStudent->student_id}). Application marked as approved but no new account was created.");
            }
            $user = $existingUser;
        } else {
            $user = User::create([
                'name' => $application->first_name . ' ' . $application->last_name,
                'email' => $application->email,
                'password' => Hash::make($plainPassword),
                'role' => 'student',
                'phone' => $application->phone,
                'status' => 'active',
            ]);
        }

        $year = date('Y');
        $count = Student::whereYear('created_at', $year)->count() + 1;
        $programme = Programme::find($application->programme_id);
        $currentYear = AcademicYear::where('is_current', true)->first();

        $studentId = 'STU-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'index_number' => 'IDX-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT),
            'programme_id' => $application->programme_id,
            'department_id' => $programme->department_id,
            'academic_year_id' => $currentYear?->id,
            'status' => 'active',
            'level' => 100,
            'semester' => 1,
            'admission_date' => date('Y-m-d'),
            'date_of_birth' => $application->date_of_birth,
            'gender' => $application->gender,
            'address' => $application->address,
            'guardian_name' => $application->guardian_name,
            'guardian_phone' => $application->guardian_phone,
            'previous_school' => $application->previous_school,
            'qualification' => $application->qualification,
        ]);

        $this->generateInvoice($student);

        $application->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        \Cache::forget('badge_pending_apps');

        return redirect()->route('admin.applications.show', $application)->with('approval_credentials', [
            'student_id' => $studentId,
            'email' => $user->email,
            'password' => $plainPassword,
            'student_name' => $user->name,
            'programme' => $programme->name,
        ]);
    }

    public function reject(Request $request, Application $application)
    {
        if ($application->status !== 'pending') {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $validated = $request->validate([
            'review_notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $validated['review_notes'] ?? null,
        ]);

        \Cache::forget('badge_pending_apps');

        return back()->with('success', 'Application rejected.');
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
