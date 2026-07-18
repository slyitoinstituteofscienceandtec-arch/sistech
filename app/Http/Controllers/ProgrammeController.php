<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\Department;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    private function denyIfStaff()
    {
        if (auth()->check() && auth()->user()->role === 'staff') {
            abort(403, 'Staff can only view programmes.');
        }
    }

    public function index(Request $request)
    {
        $query = Programme::with('department');

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        $programmes = $query->latest()->paginate(20);
        $departments = Department::where('is_active', true)->get();

        return view('programmes.index', compact('programmes', 'departments'));
    }

    public function create()
    {
        $this->denyIfStaff();
        $departments = Department::where('is_active', true)->get();
        return view('programmes.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->denyIfStaff();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:programmes,code',
            'department_id' => 'required|exists:departments,id',
            'level' => 'required|in:certificate,diploma,hnd,professional,short_course',
            'duration_months' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;
        Programme::create($validated);
        return redirect()->route('admin.programmes.index')->with('success', 'Programme created successfully.');
    }

    public function show(Programme $programme)
    {
        $programme->load(['department', 'courses', 'students']);
        return view('programmes.show', compact('programme'));
    }

    public function edit(Programme $programme)
    {
        $this->denyIfStaff();
        $departments = Department::where('is_active', true)->get();
        return view('programmes.edit', compact('programme', 'departments'));
    }

    public function update(Request $request, Programme $programme)
    {
        $this->denyIfStaff();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:programmes,code,' . $programme->id,
            'department_id' => 'required|exists:departments,id',
            'level' => 'required|in:certificate,diploma,hnd,professional,short_course',
            'duration_months' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $programme->update($validated);
        return redirect()->route('admin.programmes.index')->with('success', 'Programme updated successfully.');
    }

    public function destroy(Programme $programme)
    {
        $this->denyIfStaff();
        $programme->delete();
        return redirect()->route('admin.programmes.index')->with('success', 'Programme deleted successfully.');
    }
}
