<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $currentYear = \App\Models\AcademicYear::current()->first();

        $data = [
            'totalStudents' => Student::active()->count(),
            'totalLecturers' => \App\Models\Staff::active()->lecturers()->count(),
            'totalStaff' => \App\Models\Staff::active()->count(),
            'totalCourses' => \App\Models\Course::where('is_active', true)->count(),
            'totalDepartments' => \App\Models\Department::where('is_active', true)->count(),
            'todayAttendance' => \App\Models\Attendance::whereDate('date', today())->count(),
            'recentAnnouncements' => \App\Models\Announcement::active()->latest()->take(5)->get(),
            'currentYear' => $currentYear,
            'recentStudents' => Student::with('user', 'programme')->latest()->take(5)->get(),
            'recentAttendance' => \App\Models\Attendance::with(['student.user', 'course', 'recordedBy'])->latest()->take(5)->get(),
            'recentResults' => \App\Models\Result::with(['student.user', 'course', 'enteredBy'])->latest()->take(5)->get(),
            'recentBooks' => \App\Models\Book::latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }

    public function studentDashboard()
    {
        $student = auth()->user()->student;
        if (!$student) {
            abort(404, 'Student profile not found.');
        }

        $student->load(['programme.department', 'courseRegistrations.course', 'invoices', 'attendances']);

        $totalClasses = $student->attendances->count();
        $presentClasses = $student->attendances->where('status', 'present')->count();
        $attendanceRate = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100) : 0;

        $results = $student->results()->with('course')->latest()->take(10)->get();
        $cgpa = 0;
        if ($results->count() > 0) {
            $totalQualityPoints = $results->sum('quality_point');
            $totalCreditUnits = $results->sum('credit_unit');
            $cgpa = $totalCreditUnits > 0 ? round($totalQualityPoints / $totalCreditUnits, 2) : 0;
        }

        return view('student.dashboard', [
            'student' => $student,
            'courses' => $student->courseRegistrations,
            'results' => $results,
            'recentAnnouncements' => \App\Models\Announcement::active()->latest()->take(5)->get(),
            'attendanceRate' => $attendanceRate,
            'cgpa' => $cgpa,
        ]);
    }

}
