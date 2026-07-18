<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    public function academicYears()
    {
        $academicYears = AcademicYear::with('semesters')->latest()->get();
        return view('academic.years', compact('academicYears'));
    }

    public function storeAcademicYear(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        if ($request->boolean('is_current')) {
            AcademicYear::query()->update(['is_current' => false]);
        }

        AcademicYear::create(array_merge($validated, [
            'is_current' => $request->boolean('is_current'),
        ]));

        return redirect()->route('admin.academic.years')->with('success', 'Academic year created successfully.');
    }

    public function updateAcademicYear(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        if ($request->boolean('is_current')) {
            AcademicYear::query()->update(['is_current' => false]);
        }

        $academicYear->update($validated);
        return redirect()->route('admin.academic.years')->with('success', 'Academic year updated successfully.');
    }

    public function destroyAcademicYear(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->route('admin.academic.years')->with('success', 'Academic year deleted.');
    }

    public function setCurrentYear(AcademicYear $academicYear)
    {
        AcademicYear::query()->update(['is_current' => false]);
        $academicYear->update(['is_current' => true]);
        return back()->with('success', 'Academic year set as current.');
    }

    public function semesters()
    {
        $semesters = Semester::with('academicYear')->latest()->get();
        $academicYears = AcademicYear::all();
        return view('academic.semesters', compact('semesters', 'academicYears'));
    }

    public function storeSemester(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'semester_num' => 'required|in:1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->boolean('is_current')) {
            Semester::query()->update(['is_current' => false]);
        }

        Semester::create(array_merge($validated, [
            'is_current' => $request->boolean('is_current'),
        ]));

        return redirect()->route('admin.academic.semesters')->with('success', 'Semester created successfully.');
    }

    public function updateSemester(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'semester_num' => 'required|in:1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->boolean('is_current')) {
            Semester::query()->update(['is_current' => false]);
        }

        $semester->update(array_merge($validated, [
            'is_current' => $request->boolean('is_current'),
        ]));

        return redirect()->route('admin.academic.semesters')->with('success', 'Semester updated successfully.');
    }

    public function destroySemester(Semester $semester)
    {
        $semester->delete();
        return back()->with('success', 'Semester deleted.');
    }
}
