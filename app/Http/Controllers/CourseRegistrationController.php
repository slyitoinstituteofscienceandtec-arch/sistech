<?php

namespace App\Http\Controllers;

use App\Models\CourseRegistration;
use App\Models\Course;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class CourseRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseRegistration::with(['student.user', 'course', 'academicYear', 'semester']);

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }
        if ($request->programme_id) {
            $query->whereHas('course', fn($q) => $q->where('programme_id', $request->programme_id));
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->paginate(25);
        $courses = Course::where('is_active', true)->get();
        $programmes = \App\Models\Programme::where('is_active', true)->get();

        return view('course-registrations.index', compact('registrations', 'courses', 'programmes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $exists = CourseRegistration::where($validated)->exists();
        if ($exists) {
            return back()->with('error', 'This student is already registered for this course.');
        }

        CourseRegistration::create(array_merge($validated, [
            'status' => 'registered',
        ]));

        return back()->with('success', 'Student registered for course successfully.');
    }

    public function destroy(CourseRegistration $courseRegistration)
    {
        $courseRegistration->delete();
        return back()->with('success', 'Registration removed.');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'required|exists:semesters,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $count = 0;
        foreach ($validated['student_ids'] as $studentId) {
            $exists = CourseRegistration::where([
                'student_id' => $studentId,
                'course_id' => $validated['course_id'],
                'academic_year_id' => $validated['academic_year_id'],
                'semester_id' => $validated['semester_id'],
            ])->exists();

            if (!$exists) {
                CourseRegistration::create([
                    'student_id' => $studentId,
                    'course_id' => $validated['course_id'],
                    'academic_year_id' => $validated['academic_year_id'],
                    'semester_id' => $validated['semester_id'],
                    'status' => 'registered',
                ]);
                $count++;
            }
        }

        return back()->with('success', "{$count} student(s) registered successfully.");
    }

    public function getUnregisteredStudents(Course $course)
    {
        $academicYear = AcademicYear::where('is_current', true)->first();
        $semester = Semester::where('is_current', true)->first();

        $registeredIds = CourseRegistration::where('course_id', $course->id)
            ->when($academicYear, fn($q) => $q->where('academic_year_id', $academicYear->id))
            ->pluck('student_id');

        $students = Student::with('user')
            ->where('programme_id', $course->programme_id)
            ->where('status', 'active')
            ->whereNotIn('id', $registeredIds)
            ->get();

        return response()->json($students);
    }
}
