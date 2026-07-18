@extends('layouts.app')
@section('title', 'Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Attendance Records</h4>
        <p class="text-muted mb-0" style="font-size:13px;">View and manage attendance records</p>
    </div>
    <a href="{{ route('admin.attendance.create') }}" class="btn btn-sistech">
        <i class="fas fa-plus me-1"></i> Record Attendance
    </a>
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.attendance.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Course</label>
                <select name="course_id" class="form-select">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->code }} - {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sistech flex-grow-1">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clipboard-check me-2" style="color: var(--primary);"></i>Attendance Records</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $attendances->total() }} Records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Method</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $record)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: var(--primary); color: white; font-size: 11px; font-weight: 600;">
                                    {{ strtoupper(substr($record->student->user->name ?? 'N', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 13px;">{{ $record->student->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $record->student->student_id ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: var(--primary-light); color: var(--primary);">
                                {{ $record->course->code ?? '' }}
                            </span>
                        </td>
                        <td>
                            @switch($record->status)
                                @case('present')
                                    <span class="badge-status badge-active">Present</span>
                                    @break
                                @case('absent')
                                    <span class="badge-status badge-inactive">Absent</span>
                                    @break
                                @case('late')
                                    <span class="badge-status badge-pending">Late</span>
                                    @break
                                @case('excused')
                                    <span class="badge" style="background: #EDE9FE; color: #7C3AED;">Excused</span>
                                    @break
                                @default
                                    <span class="badge-status badge-inactive">{{ ucfirst($record->status) }}</span>
                            @endswitch
                        </td>
                        <td>{{ $record->time_in ?? '-' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-{{ $record->method === 'qr' ? 'qrcode' : ($record->method === 'biometric' ? 'fingerprint' : 'pen') }} me-1"></i>
                                {{ ucfirst($record->method ?? 'manual') }}
                            </span>
                        </td>
                        <td>{{ $record->recordedBy->name ?? 'System' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-check" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No attendance records found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($attendances, 'links'))
    <div class="card-footer d-flex justify-content-center" style="background: var(--bg); border-top: 1px solid var(--border);">
        {{ $attendances->links() }}
    </div>
    @endif
</div>
@endsection
