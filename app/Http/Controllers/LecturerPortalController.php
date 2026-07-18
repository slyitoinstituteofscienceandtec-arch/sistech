<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Notification;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturerPortalController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $myCourses = $user->courses()->with(['department', 'programme'])->get();
        $totalCourses = $myCourses->count();

        $courseIds = $myCourses->pluck('id');

        $totalStudents = CourseRegistration::whereIn('course_id', $courseIds)->count();

        $todayAttendance = Attendance::whereIn('course_id', $courseIds)
            ->whereDate('date', now()->toDateString())
            ->count();

        $pendingResults = Result::whereIn('course_id', $courseIds)
            ->where('status', 'pending')
            ->count();

        $recentAttendance = Attendance::whereIn('course_id', $courseIds)
            ->with(['student.user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        $announcements = Announcement::active()
            ->latest()
            ->take(5)
            ->get();

        return view('lecturer.dashboard', compact(
            'totalCourses',
            'myCourses',
            'totalStudents',
            'todayAttendance',
            'pendingResults',
            'recentAttendance',
            'announcements'
        ));
    }

    public function courses()
    {
        $courses = auth()->user()->courses()
            ->with(['department', 'programme', 'registrations.student.user'])
            ->get();

        return view('lecturer.courses', compact('courses'));
    }

    public function attendance()
    {
        $courses = auth()->user()->courses()->with('department')->get();

        return view('lecturer.attendance', compact('courses'));
    }

    public function attendanceStudents($courseId)
    {
        $course = Course::where('id', $courseId)
            ->where('lecturer_id', auth()->id())
            ->first();

        if (!$course) {
            return response()->json([]);
        }

        $academicYear = DB::table('academic_years')->where('is_current', true)->first();
        $semester = DB::table('semesters')->where('is_current', true)->first();

        $query = CourseRegistration::where('course_id', $course->id);

        if ($academicYear) {
            $query->where('academic_year_id', $academicYear->id);
        }
        if ($semester) {
            $query->where('semester_id', $semester->id);
        }

        $registeredStudentIds = $query->pluck('student_id');

        $students = Student::with('user')
            ->whereIn('id', $registeredStudentIds)
            ->where('status', 'active')
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'student_id' => $s->student_id,
                'name' => $s->user->name,
            ]);

        return response()->json($students);
    }

    public function recordAttendance(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'records' => 'required|array',
            'records.*.student_id' => 'required|exists:students,id',
            'records.*.status' => 'required|in:present,absent,late,excused',
        ]);

        $course = Course::where('id', $validated['course_id'])
            ->where('lecturer_id', auth()->id())
            ->first();

        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Unauthorized course.'], 403);
        }

        foreach ($validated['records'] as $record) {
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

        return response()->json(['success' => true, 'message' => 'Attendance recorded successfully.']);
    }

    public function results()
    {
        $courses = auth()->user()->courses()->with('department')->get();
        $academicYears = \App\Models\AcademicYear::all();
        $semesters = \App\Models\Semester::all();

        return view('lecturer.results', compact('courses', 'academicYears', 'semesters'));
    }

    public function resultsStudents($courseId)
    {
        $course = Course::where('id', $courseId)
            ->where('lecturer_id', auth()->id())
            ->first();

        if (!$course) {
            return response()->json([]);
        }

        $academicYear = DB::table('academic_years')->where('is_current', true)->first();
        $semester = DB::table('semesters')->where('is_current', true)->first();

        $query = CourseRegistration::where('course_id', $course->id);

        if ($academicYear) {
            $query->where('academic_year_id', $academicYear->id);
        }
        if ($semester) {
            $query->where('semester_id', $semester->id);
        }

        $registeredStudentIds = $query->pluck('student_id');

        $students = Student::with('user')
            ->whereIn('id', $registeredStudentIds)
            ->where('status', 'active')
            ->get()
            ->map(function ($s) use ($courseId) {
                $existing = Result::where('student_id', $s->id)
                    ->where('course_id', $courseId)
                    ->first();

                return [
                    'id' => $s->id,
                    'student_id' => $s->student_id,
                    'name' => $s->user->name,
                    'ca_score' => $existing?->ca_score,
                    'exam_score' => $existing?->exam_score,
                ];
            });

        return response()->json($students);
    }

    public function storeResults(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'semester_id' => 'required|exists:semesters,id',
            'results' => 'required|array',
            'results.*.student_id' => 'required|exists:students,id',
            'results.*.ca_score' => 'nullable|numeric|min:0|max:100',
            'results.*.exam_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $course = Course::where('id', $validated['course_id'])
            ->where('lecturer_id', auth()->id())
            ->first();

        if (!$course) {
            return response()->json(['success' => false, 'message' => 'Unauthorized course.'], 403);
        }

        $gradeScale = [
            'A+' => ['min' => 90, 'max' => 100, 'point' => 4.0],
            'A'  => ['min' => 80, 'max' => 89, 'point' => 4.0],
            'B+' => ['min' => 75, 'max' => 79, 'point' => 3.5],
            'B'  => ['min' => 70, 'max' => 74, 'point' => 3.0],
            'C+' => ['min' => 65, 'max' => 69, 'point' => 2.5],
            'C'  => ['min' => 60, 'max' => 64, 'point' => 2.0],
            'D+' => ['min' => 55, 'max' => 59, 'point' => 1.5],
            'D'  => ['min' => 50, 'max' => 54, 'point' => 1.0],
            'E'  => ['min' => 40, 'max' => 49, 'point' => 0.5],
            'F'  => ['min' => 0,  'max' => 39, 'point' => 0.0],
        ];

        foreach ($validated['results'] as $result) {
            $ca = $result['ca_score'] ?? 0;
            $exam = $result['exam_score'] ?? 0;
            $total = $ca + $exam;

            $grade = 'F';
            $point = 0.0;
            foreach ($gradeScale as $g => $range) {
                if ($total >= $range['min'] && $total <= $range['max']) {
                    $grade = $g;
                    $point = $range['point'];
                    break;
                }
            }

            $creditUnit = $course->credit_units;

            Result::updateOrCreate(
                [
                    'student_id' => $result['student_id'],
                    'course_id' => $validated['course_id'],
                    'academic_year_id' => $validated['academic_year_id'],
                    'semester_id' => $validated['semester_id'],
                ],
                [
                    'ca_score' => $ca,
                    'exam_score' => $exam,
                    'total_score' => $total,
                    'grade' => $grade,
                    'grade_point' => $point,
                    'credit_unit' => $creditUnit,
                    'quality_point' => $point * $creditUnit,
                    'status' => 'pending',
                    'entered_by' => auth()->id(),
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Results saved successfully.']);
    }

    public function profile()
    {
        $staff = auth()->user()->staff()->with(['user', 'department'])->first();

        return view('lecturer.profile', compact('staff'));
    }

    public function announcements()
    {
        $announcements = Announcement::active()
            ->latest()
            ->paginate(20);

        return view('lecturer.announcements', compact('announcements'));
    }

    public function notifications()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('lecturer.notifications', compact('notifications'));
    }

    public function markRead($notification)
    {
        $notification = Notification::where('id', $notification)
            ->where('user_id', auth()->id())
            ->first();

        if ($notification) {
            $notification->update(['is_read' => true]);
        }

        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back();
    }
}
