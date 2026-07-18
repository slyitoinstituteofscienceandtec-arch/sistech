@extends('layouts.app')
@section('title', $programme->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $programme->name }}</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Programme details and overview</p>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->user()->role !== 'staff')
        <a href="{{ route('admin.programmes.edit', $programme) }}" class="btn btn-sistech">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        @endif
        <a href="{{ route('admin.programmes.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fas fa-book"></i></div>
            <div class="stat-value">{{ $programme->courses_count ?? $programme->courses->count() }}</div>
            <div class="stat-label">Courses</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-light);color:var(--green);"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-value">{{ $programme->students_count ?? $programme->students->count() ?? 0 }}</div>
            <div class="stat-label">Students</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF9C3;color:#CA8A04;"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $programme->duration_months ? $programme->duration_months . 'm' : '-' }}</div>
            <div class="stat-label">Duration</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-sistech mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2" style="color:var(--primary);"></i> Programme Information
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:13px;">
                    <tr>
                        <td class="text-muted" style="width:160px;">Code</td>
                        <td><span class="badge" style="background:var(--primary-light);color:var(--primary);">{{ $programme->code }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Department</td>
                        <td>{{ $programme->department->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Level</td>
                        <td>{{ $programme->level ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Duration</td>
                        <td>{{ $programme->duration_months ? $programme->duration_months . ' months' : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td><span class="badge-status badge-{{ $programme->is_active ? 'active' : 'inactive' }}">{{ $programme->is_active ? 'Active' : 'Inactive' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Description</td>
                        <td>{{ $programme->description ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-sistech mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-book me-2" style="color:var(--primary);"></i> Courses</span>
                <span class="badge bg-light text-dark">{{ $programme->courses->count() }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($programme->courses as $course)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <div>
                            <a href="{{ route('admin.courses.show', $course) }}" style="color:var(--text);text-decoration:none;font-weight:500;font-size:13px;">{{ $course->name }}</a>
                            <div style="font-size:11px;color:var(--text-muted);">{{ $course->code }} &middot; {{ $course->credit_units ?? '-' }} credits</div>
                        </div>
                        <span class="badge bg-light text-dark border" style="font-size:11px;">Sem {{ $course->semester ?? '-' }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No courses in this programme</div>
                @endforelse
            </div>
        </div>

        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user-graduate me-2" style="color:var(--green);"></i> Enrolled Students</span>
                <span class="badge bg-light text-dark">{{ $programme->students->count() ?? 0 }}</span>
            </div>
            <div class="card-body p-0">
                @forelse(($programme->students ?? collect())->take(10) as $student)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--green-light);color:var(--green);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:11px;">
                                {{ substr($student->user->name ?? $student->name ?? '', 0, 1) }}
                            </div>
                            <span style="font-size:13px;font-weight:500;">{{ $student->user->name ?? $student->name ?? '-' }}</span>
                        </div>
                        <span class="badge bg-light text-dark border" style="font-size:11px;">{{ $student->student_id ?? '' }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No students enrolled</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
