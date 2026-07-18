@extends('layouts.app')
@section('title', $department->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $department->name }}</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Department details and overview</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-sistech">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fas fa-graduation-cap"></i></div>
            <div class="stat-value">{{ $department->programmes_count ?? $department->programmes->count() }}</div>
            <div class="stat-label">Programmes</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-light);color:var(--green);"><i class="fas fa-book"></i></div>
            <div class="stat-value">{{ $department->courses_count ?? $department->courses->count() }}</div>
            <div class="stat-label">Courses</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF9C3;color:#CA8A04;"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-value">{{ $department->students_count ?? 0 }}</div>
            <div class="stat-label">Students</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#F3E8FF;color:#7C3AED;"><i class="fas fa-users"></i></div>
            <div class="stat-value">{{ $department->staff_count ?? $department->staff->count() ?? 0 }}</div>
            <div class="stat-label">Staff</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-sistech mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2" style="color:var(--primary);"></i> Department Information
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:13px;">
                    <tr>
                        <td class="text-muted" style="width:160px;">Code</td>
                        <td><span class="badge" style="background:var(--primary-light);color:var(--primary);">{{ $department->code }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">HOD</td>
                        <td>{{ $department->head->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td><span class="badge-status badge-{{ $department->is_active ? 'active' : 'inactive' }}">{{ $department->is_active ? 'Active' : 'Inactive' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Description</td>
                        <td>{{ $department->description ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-sistech mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-graduation-cap me-2" style="color:var(--green);"></i> Programmes</span>
                <span class="badge bg-light text-dark">{{ $department->programmes->count() }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($department->programmes as $programme)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <a href="{{ route('admin.programmes.show', $programme) }}" style="color:var(--text);text-decoration:none;font-weight:500;font-size:13px;">{{ $programme->name }}</a>
                        <span class="badge bg-light text-dark border" style="font-size:11px;">{{ $programme->code }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No programmes in this department</div>
                @endforelse
            </div>
        </div>

        <div class="card-sistech mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-book me-2" style="color:#D97706;"></i> Courses</span>
                <span class="badge bg-light text-dark">{{ $department->courses->count() }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($department->courses->take(10) as $course)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <a href="{{ route('admin.courses.show', $course) }}" style="color:var(--text);text-decoration:none;font-weight:500;font-size:13px;">{{ $course->name }}</a>
                        <span class="badge bg-light text-dark border" style="font-size:11px;">{{ $course->code }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No courses in this department</div>
                @endforelse
            </div>
        </div>

        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-2" style="color:#7C3AED;"></i> Staff Members</span>
                <span class="badge bg-light text-dark">{{ $department->staff->count() }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($department->staff->take(10) as $member)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--primary-light);color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:11px;">
                                {{ substr($member->user->name ?? '', 0, 1) }}
                            </div>
                            <span style="font-size:13px;font-weight:500;">{{ $member->user->name ?? '-' }}</span>
                        </div>
                        <span class="badge bg-light text-dark border" style="font-size:11px;">{{ ucfirst(str_replace('_', ' ', $member->position)) }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No staff in this department</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
