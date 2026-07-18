@extends('layouts.app')
@section('title', 'My Courses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Courses</h4>
        <p class="text-muted mb-0" style="font-size:13px;">View your registered courses</p>
    </div>
    <span class="badge" style="background: var(--primary-light); color: var(--primary); padding: 8px 14px; border-radius: 8px; font-size: 12px;">
        <i class="fas fa-id-card me-1"></i> {{ $student->student_id ?? 'N/A' }}
    </span>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $student->courseRegistrations->count() ?? 0 }}</div>
                    <div class="stat-label">Total Courses</div>
                </div>
                <div class="stat-icon" style="background: var(--primary-light); color: var(--primary);">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="color: var(--green);">{{ $student->courseRegistrations->sum('course.credit_units') ?? 0 }}</div>
                    <div class="stat-label">Total Credit Units</div>
                </div>
                <div class="stat-icon" style="background: var(--green-light); color: var(--green);">
                    <i class="fas fa-award"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-book me-2" style="color: var(--primary);"></i>Registered Courses</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Course Name</th>
                        <th>Department</th>
                        <th class="text-center">Credit Units</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->courseRegistrations ?? [] as $reg)
                    <tr>
                        <td><strong style="color: var(--primary);">{{ $reg->course->code ?? '-' }}</strong></td>
                        <td>{{ $reg->course->name ?? '-' }}</td>
                        <td>{{ $reg->course->department->name ?? '-' }}</td>
                        <td class="text-center">{{ $reg->course->credit_units ?? '-' }}</td>
                        <td class="text-center">{{ $reg->course->semester ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge-status badge-active">Registered</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-book-open fa-2x mb-2 d-block" style="opacity:0.3;"></i>
                            No courses registered yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
