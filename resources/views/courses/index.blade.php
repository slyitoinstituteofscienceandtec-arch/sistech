@extends('layouts.app')
@section('title', 'Courses')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Courses</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage academic courses</p>
    </div>
    @if(auth()->user()->role !== 'staff')
    <a href="{{ route('admin.courses.create') }}" class="btn btn-sistech">
        <i class="fas fa-plus me-1"></i> Add Course
    </a>
    @endif
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.courses.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Search</label>
                    <input type="text" name="search" class="form-control" style="font-size:13px;border-radius:8px;" placeholder="Code, name..." value="{{ request('search') }}">
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
                    <label class="form-label" style="font-size:12px;font-weight:600;">Programme</label>
                    <select name="programme_id" class="form-select" style="font-size:13px;border-radius:8px;">
                        <option value="">All</option>
                        @foreach($programmes as $prog)
                            <option value="{{ $prog->id }}" {{ request('programme_id') == $prog->id ? 'selected' : '' }}>{{ $prog->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Semester</label>
                    <select name="semester" class="form-select" style="font-size:13px;border-radius:8px;">
                        <option value="">All</option>
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
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
        <span><i class="fas fa-book me-2" style="color:var(--primary);"></i>All Courses <span class="text-muted" style="font-weight:400;">({{ $courses->total() }})</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Programme</th>
                        <th>Credits</th>
                        <th>Semester</th>
                        <th>Level</th>
                        <th>Lecturer</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td><span class="badge" style="background:var(--primary-light);color:var(--primary);">{{ $course->code }}</span></td>
                        <td>
                            <a href="{{ route('admin.courses.show', $course) }}" style="color:var(--text);text-decoration:none;font-weight:500;">
                                {{ $course->name }}
                            </a>
                        </td>
                        <td>{{ $course->department->name ?? '-' }}</td>
                        <td>{{ $course->programme->name ?? '-' }}</td>
                        <td>{{ $course->credit_units ?? '-' }}</td>
                        <td>{{ $course->semester ?? '-' }}</td>
                        <td>{{ $course->level ?? '-' }}</td>
                        <td>{{ $course->lecturer->name ?? '-' }}</td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm" style="color:var(--text-muted);" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.courses.show', $course) }}"><i class="fas fa-eye me-2"></i> View</a></li>
                                    @if(auth()->user()->role !== 'staff')
                                    <li><a class="dropdown-item" href="{{ route('admin.courses.edit', $course) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Are you sure you want to delete this course?')">
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
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="fas fa-book fa-2x mb-2 d-block" style="color:var(--border);"></i>
                            No courses found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($courses, 'hasPages') && $courses->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3" style="font-size:13px;">
    <span class="text-muted">Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} courses</span>
    {{ $courses->withQueryString()->links() }}
</div>
@endif
@endsection
