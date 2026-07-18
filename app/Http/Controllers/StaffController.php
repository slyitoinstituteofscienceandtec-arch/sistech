<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with(['user', 'department']);

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            })->orWhere('staff_id', 'like', "%{$request->search}%");
        }

        if ($request->position) {
            $query->where('position', $request->position);
        }

        $staff = $query->latest()->paginate(20);
        $departments = Department::where('is_active', true)->get();

        return view('staff.index', compact('staff', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('staff.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'position' => 'required|in:lecturer,hod,registrar,accountant,admin,librarian,it_support,security,cleaner,other',
            'employment_type' => 'required|in:full_time,part_time,contract,visiting',
            'hire_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
            'qualification' => 'nullable|string',
            'specialization' => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ]);

        $plainPassword = $validated['password'] ?? Str::random(8);
        unset($validated['password']);

        $year = date('y');
        $count = Staff::whereYear('created_at', date('Y'))->count() + 1;
        $staffId = 'STF-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($plainPassword),
            'role' => ($validated['position'] ?? '') === 'lecturer' ? 'lecturer' : 'staff',
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ]);

        Staff::create(array_merge($validated, [
            'user_id' => $user->id,
            'staff_id' => $staffId,
            'status' => 'active',
        ]));

        return redirect()->route('admin.staff.show', $user->staff)->with('login_credentials', [
            'name' => $user->name,
            'id' => $staffId,
            'email' => $user->email,
            'password' => $plainPassword,
        ]);
    }

    public function show(Staff $staff)
    {
        $staff->load(['user', 'department']);
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $staff->load('user');
        $departments = Department::where('is_active', true)->get();
        return view('staff.edit', compact('staff', 'departments'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'position' => 'required',
            'employment_type' => 'required',
            'salary' => 'nullable|numeric|min:0',
            'qualification' => 'nullable|string',
            'specialization' => 'nullable|string',
            'status' => 'required|in:active,inactive,on_leave,terminated',
        ]);

        $staff->user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
        ]);

        $staff->update($validated);

        return redirect()->route('admin.staff.show', $staff)->with('success', 'Staff updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->user->delete();
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
    }
}
