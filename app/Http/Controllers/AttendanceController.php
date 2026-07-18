<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student.user', 'course']);

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        $attendances = $query->latest('date')->paginate(50);
        $courses = Course::where('is_active', true)->get();

        return view('attendance.index', compact('attendances', 'courses'));
    }

    public function create()
    {
        $courses = Course::where('is_active', true)->get();
        return view('attendance.create', compact('courses'));
    }

    public function getStudents($courseId)
    {
        $course = Course::find($courseId);
        if (!$course) {
            return response()->json([]);
        }

        $academicYear = \App\Models\AcademicYear::where('is_current', true)->first();
        $semester = \App\Models\Semester::where('is_current', true)->first();

        $registeredStudentIds = \App\Models\CourseRegistration::where('course_id', $course->id)
            ->when($academicYear, fn($q) => $q->where('academic_year_id', $academicYear->id))
            ->when($semester, fn($q) => $q->where('semester_id', $semester->id))
            ->pluck('student_id');

        $students = Student::with('user')
            ->whereIn('id', $registeredStudentIds)
            ->where('status', 'active')
            ->get();

        return response()->json($students);
    }

    public function record(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
        ]);

        foreach ($validated['attendance'] as $record) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $record['student_id'],
                    'course_id' => $validated['course_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $record['status'],
                    'method' => 'manual',
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function studentAttendance(Student $student)
    {
        $attendances = Attendance::with('course')
            ->where('student_id', $student->id)
            ->latest('date')
            ->paginate(50);

        return view('attendance.student', compact('student', 'attendances'));
    }
}
