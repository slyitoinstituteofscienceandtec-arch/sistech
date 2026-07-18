@extends('layouts.app')
@section('title', 'Students')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Students</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage student admissions and records</p>
    </div>
    @if(auth()->user()->role !== 'staff')
    <a href="{{ route('admin.students.create') }}" class="btn btn-sistech">
        <i class="fas fa-plus me-1"></i> Admit Student
    </a>
    @endif
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.students.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Search</label>
                    <input type="text" name="search" class="form-control" style="font-size:13px;border-radius:8px;" placeholder="Name, email, student ID..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Status</label>
                    <select name="status" class="form-select" style="font-size:13px;border-radius:8px;">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="graduated" {{ request('status') === 'graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="transferred" {{ request('status') === 'transferred' ? 'selected' : '' }}>Transferred</option>
                        <option value="deferred" {{ request('status') === 'deferred' ? 'selected' : '' }}>Deferred</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Department</label>
                    <select name="department_id" class="form-select" style="font-size:13px;border-radius:8px;">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sistech w-100"><i class="fas fa-filter me-1"></i> Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-user-graduate me-2" style="color:var(--primary);"></i>All Students <span class="text-muted" style="font-weight:400;">({{ $students->total() }})</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Programme</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td><strong>{{ $student->student_id }}</strong></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:32px;height:32px;border-radius:50%;background:var(--primary-light);color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:12px;">
                                    {{ substr($student->user->name ?? '', 0, 1) }}
                                </div>
                                <a href="{{ route('admin.students.show', $student) }}" style="color:var(--text);text-decoration:none;font-weight:500;">
                                    {{ $student->user->name ?? '-' }}
                                </a>
                            </div>
                        </td>
                        <td style="font-size:13px;">{{ $student->user->email ?? '-' }}</td>
                        <td>{{ $student->programme->name ?? '-' }}</td>
                        <td>{{ $student->department->name ?? '-' }}</td>
                        <td>
                            <span class="badge-status badge-{{ $student->status === 'active' ? 'active' : ($student->status === 'graduated' ? 'paid' : ($student->status === 'deferred' ? 'pending' : 'inactive')) }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm" style="color:var(--text-muted);" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.students.show', $student) }}"><i class="fas fa-eye me-2"></i> View</a></li>
                                    @if(auth()->user()->role !== 'staff')
                                    <li><a class="dropdown-item" href="{{ route('admin.students.edit', $student) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-user-graduate fa-2x mb-2 d-block" style="color:var(--border);"></i>
                            No students found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($students->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3" style="font-size:13px;">
    <span class="text-muted">Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} students</span>
    {{ $students->withQueryString()->links() }}
</div>
@endif
@endsection
