@extends('layouts.app')
@section('title', $course->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $course->name }}</h4>
        <p class="text-muted mb-0" style="font-size:13px;">{{ $course->code }} &middot; Course details and overview</p>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->user()->role !== 'staff')
        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sistech">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        @endif
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-value">{{ $course->registrations_count ?? $course->registrations->count() ?? 0 }}</div>
            <div class="stat-label">Registered Students</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-light);color:var(--green);"><i class="fas fa-star"></i></div>
                            <div class="stat-value">{{ $course->credit_units ?? '-' }}</div>
            <div class="stat-label">Credit Units</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF9C3;color:#CA8A04;"><i class="fas fa-calendar"></i></div>
            <div class="stat-value">{{ $course->semester ?? '-' }}</div>
            <div class="stat-label">Semester</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#F3E8FF;color:#7C3AED;"><i class="fas fa-layer-group"></i></div>
            <div class="stat-value">{{ $course->level ?? '-' }}</div>
            <div class="stat-label">Level</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card-sistech mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2" style="color:var(--primary);"></i> Course Information
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0" style="font-size:13px;">
                    <tr>
                        <td class="text-muted" style="width:160px;">Code</td>
                        <td><span class="badge" style="background:var(--primary-light);color:var(--primary);">{{ $course->code }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Department</td>
                        <td>{{ $course->department->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Programme</td>
                        <td>{{ $course->programme->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Lecturer</td>
                        <td>{{ $course->lecturer->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td><span class="badge-status badge-{{ $course->is_active ? 'active' : 'inactive' }}">{{ $course->is_active ? 'Active' : 'Inactive' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Description</td>
                        <td>{{ $course->description ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card-sistech mb-4">
            <div class="card-header">
                <i class="fas fa-clock me-2" style="color:var(--green);"></i> Timetable
            </div>
            <div class="card-body p-0">
                @forelse(($course->timetable ?? collect()) as $entry)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <div>
                            <span style="font-weight:500;font-size:13px;">{{ $entry->day ?? '-' }}</span>
                        </div>
                        <span style="font-size:12px;color:var(--text-muted);">{{ $entry->start_time ?? '' }} - {{ $entry->end_time ?? '' }}</span>
                        <span style="font-size:12px;color:var(--text-muted);">{{ $entry->venue ?? '' }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No timetable entries</div>
                @endforelse
            </div>
        </div>

        <div class="card-sistech">
            <div class="card-header">
                <i class="fas fa-file-alt me-2" style="color:#D97706;"></i> Exams
            </div>
            <div class="card-body p-0">
                @forelse(($course->examinations ?? collect()) as $exam)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <div>
                            <span style="font-weight:500;font-size:13px;">{{ $exam->name ?? $exam->type ?? '-' }}</span>
                        </div>
                        <span style="font-size:12px;color:var(--text-muted);">{{ $exam->date ?? '-' }}</span>
                        <span class="badge bg-light text-dark border" style="font-size:11px;">{{ $exam->total_marks ?? '' }} marks</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No exams scheduled</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user-graduate me-2" style="color:var(--primary);"></i> Registered Students</span>
                <span class="badge bg-light text-dark">{{ $course->registrations->count() ?? 0 }}</span>
            </div>
            <div class="card-body p-0">
                @forelse(($course->registrations ?? collect()) as $reg)
                    @php $student = $reg->student ?? $reg; @endphp
                    <div class="d-flex justify-content-between align-items-center px-3 py-2" style="border-bottom:1px solid var(--border);">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--primary-light);color:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:11px;">
                                {{ substr($student->user->name ?? $student->name ?? '', 0, 1) }}
                            </div>
                            <div>
                                <div style="font-size:13px;font-weight:500;">{{ $student->user->name ?? $student->name ?? '-' }}</div>
                                <div style="font-size:11px;color:var(--text-muted);">{{ $student->student_id ?? '' }}</div>
                            </div>
                        </div>
                        <span class="badge bg-light text-dark border" style="font-size:11px;">{{ $reg->status ?? 'registered' }}</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4" style="font-size:13px;">No students registered</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
