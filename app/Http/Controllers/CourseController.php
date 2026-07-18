<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Programme;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private function denyIfStaff()
    {
        if (auth()->check() && auth()->user()->role === 'staff') {
            abort(403, 'Staff can only view courses.');
        }
    }

    public function index(Request $request)
    {
        $query = Course::with(['department', 'programme', 'lecturer']);

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
        }

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->programme_id) {
            $query->where('programme_id', $request->programme_id);
        }

        $courses = $query->latest()->paginate(20);
        $departments = Department::where('is_active', true)->get();
        $programmes = Programme::where('is_active', true)->get();

        return view('courses.index', compact('courses', 'departments', 'programmes'));
    }

    public function create()
    {
        $this->denyIfStaff();
        $departments = Department::where('is_active', true)->get();
        $programmes = Programme::where('is_active', true)->get();
        $lecturers = User::where('role', 'lecturer')->where('status', 'active')->get();
        return view('courses.create', compact('departments', 'programmes', 'lecturers'));
    }

    public function store(Request $request)
    {
        $this->denyIfStaff();
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code',
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'programme_id' => 'required|exists:programmes,id',
            'credit_units' => 'required|integer|min:1|max:6',
            'semester' => 'required|in:1,2',
            'level' => 'required|integer',
            'lecturer_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;
        Course::create($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['department', 'programme', 'lecturer', 'registrations.student.user', 'timetables', 'examinations']);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->denyIfStaff();
        $departments = Department::where('is_active', true)->get();
        $programmes = Programme::where('is_active', true)->get();
        $lecturers = User::where('role', 'lecturer')->where('status', 'active')->get();
        return view('courses.edit', compact('course', 'departments', 'programmes', 'lecturers'));
    }

    public function update(Request $request, Course $course)
    {
        $this->denyIfStaff();
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'programme_id' => 'required|exists:programmes,id',
            'credit_units' => 'required|integer|min:1|max:6',
            'semester' => 'required|in:1,2',
            'level' => 'required|integer',
            'lecturer_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $course->update($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->denyIfStaff();
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
