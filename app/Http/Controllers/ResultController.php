<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use App\Models\Course;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    private $gradeScale = [
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

    public function index(Request $request)
    {
        $query = Result::with(['student.user', 'course', 'academicYear', 'semester']);

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->academic_year_id) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $results = $query->latest()->paginate(50);
        $courses = Course::where('is_active', true)->get();
        $academicYears = AcademicYear::all();

        return view('results.index', compact('results', 'courses', 'academicYears'));
    }

    public function enterResults()
    {
        $courses = Course::where('is_active', true)->where('lecturer_id', auth()->id())->get();
        if ($courses->isEmpty()) {
            $courses = Course::where('is_active', true)->get();
        }
        $academicYears = AcademicYear::current()->get();
        $semesters = Semester::where('is_current', true)->get();
        return view('results.enter', compact('courses', 'academicYears', 'semesters'));
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

        $course = Course::find($validated['course_id']);

        foreach ($validated['results'] as $result) {
            $ca = $result['ca_score'] ?? 0;
            $exam = $result['exam_score'] ?? 0;
            $total = $ca + $exam;
            $grade = $this->calculateGrade($total);
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
                    'grade' => $grade['grade'],
                    'grade_point' => $grade['point'],
                    'credit_unit' => $creditUnit,
                    'quality_point' => $grade['point'] * $creditUnit,
                    'status' => 'submitted',
                    'entered_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('admin.results.index')->with('success', 'Results submitted successfully.');
    }

    public function approve(Result $result)
    {
        $result->update(['status' => 'approved']);
        return back()->with('success', 'Result approved.');
    }

    public function publish(Request $request)
    {
        Result::where('academic_year_id', $request->academic_year_id)
            ->where('semester_id', $request->semester_id)
            ->where('status', 'approved')
            ->update(['status' => 'published']);

        return back()->with('success', 'Results published.');
    }

    public function transcript(Student $student)
    {
        $student->load(['user', 'programme', 'department']);

        $results = Result::with(['course', 'academicYear', 'semester'])
            ->where('student_id', $student->id)
            ->where('status', 'published')
            ->orderBy('academic_year_id')
            ->orderBy('semester_id')
            ->get();

        $groupedResults = $results->groupBy(function ($r) {
            return ($r->academicYear->name ?? 'Unknown') . ' - ' . ($r->semester->name ?? 'Unknown');
        });

        $totalCredits = $results->sum('credit_unit');
        $totalQualityPoints = $results->sum('quality_point');
        $cgpa = $totalCredits > 0 ? round($totalQualityPoints / $totalCredits, 2) : 0;
        $totalCourses = $results->count();

        return view('results.transcript', compact('student', 'results', 'groupedResults', 'cgpa', 'totalCredits', 'totalCourses'));
    }

    private function calculateGrade($score): array
    {
        foreach ($this->gradeScale as $grade => $range) {
            if ($score >= $range['min'] && $score <= $range['max']) {
                return ['grade' => $grade, 'point' => $range['point']];
            }
        }
        return ['grade' => 'F', 'point' => 0.0];
    }
}
