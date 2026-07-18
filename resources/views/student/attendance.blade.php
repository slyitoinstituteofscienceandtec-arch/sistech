@extends('layouts.app')
@section('title', 'My Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Attendance</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Track your attendance records</p>
    </div>
    <span class="badge" style="background: var(--primary-light); color: var(--primary); padding: 8px 14px; border-radius: 8px; font-size: 12px;">
        <i class="fas fa-id-card me-1"></i> {{ $student->student_id ?? 'N/A' }}
    </span>
</div>

@php
    $totalClasses = $student->attendances->count();
    $presentCount = $student->attendances->where('status', 'present')->count();
    $absentCount = $student->attendances->where('status', 'absent')->count();
    $lateCount = $student->attendances->where('status', 'late')->count();
    $attendanceRate = $totalClasses > 0 ? round(($presentCount / $totalClasses) * 100) : 0;
@endphp

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $totalClasses }}</div>
                    <div class="stat-label">Total Classes</div>
                </div>
                <div class="stat-icon" style="background: var(--primary-light); color: var(--primary);">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="color: var(--green);">{{ $presentCount }}</div>
                    <div class="stat-label">Present</div>
                </div>
                <div class="stat-icon" style="background: var(--green-light); color: var(--green);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="color: #DC2626;">{{ $absentCount }}</div>
                    <div class="stat-label">Absent</div>
                </div>
                <div class="stat-icon" style="background: #FEF2F2; color: #DC2626;">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="color: {{ $attendanceRate >= 75 ? 'var(--green)' : ($attendanceRate >= 50 ? '#D97706' : '#DC2626') }};">{{ $attendanceRate }}%</div>
                    <div class="stat-label">Attendance Rate</div>
                </div>
                <div class="stat-icon" style="background: {{ $attendanceRate >= 75 ? 'var(--green-light)' : ($attendanceRate >= 50 ? '#FEF3C7' : '#FEF2F2') }}; color: {{ $attendanceRate >= 75 ? 'var(--green)' : ($attendanceRate >= 50 ? '#D97706' : '#DC2626') }};">
                    <i class="fas fa-clipboard-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clipboard-check me-2" style="color: var(--green);"></i>Attendance Records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Course</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Time In</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->attendances ?? [] as $attendance)
                    <tr>
                        <td>{{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format('d M Y') : '-' }}</td>
                        <td><strong>{{ $attendance->course->name ?? '-' }}</strong></td>
                        <td class="text-center">
                            @if($attendance->status === 'present')
                                <span class="badge-status badge-active">Present</span>
                            @elseif($attendance->status === 'late')
                                <span class="badge-status badge-pending">Late</span>
                            @else
                                <span class="badge-status badge-inactive">Absent</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $attendance->time_in ?? '-' }}</td>
                        <td>{{ $attendance->remarks ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-clipboard fa-2x mb-2 d-block" style="opacity:0.3;"></i>
                            No attendance records yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($totalClasses > 0)
<div class="card-sistech mt-3">
    <div class="card-header">
        <i class="fas fa-chart-pie me-2" style="color: var(--primary);"></i>Attendance Summary
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3" style="background: var(--green-light); border-radius: 10px;">
                    <div class="stat-icon" style="background: white; color: var(--green); width:40px; height:40px; font-size:16px;">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:18px; color: var(--green);">{{ $presentCount }}</div>
                        <div class="text-muted" style="font-size:12px;">Present ({{ $totalClasses > 0 ? round(($presentCount / $totalClasses) * 100) : 0 }}%)</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3" style="background: #FEF9C3; border-radius: 10px;">
                    <div class="stat-icon" style="background: white; color: #CA8A04; width:40px; height:40px; font-size:16px;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:18px; color: #CA8A04;">{{ $lateCount }}</div>
                        <div class="text-muted" style="font-size:12px;">Late ({{ $totalClasses > 0 ? round(($lateCount / $totalClasses) * 100) : 0 }}%)</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3 p-3" style="background: #FEF2F2; border-radius: 10px;">
                    <div class="stat-icon" style="background: white; color: #DC2626; width:40px; height:40px; font-size:16px;">
                        <i class="fas fa-times"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:18px; color: #DC2626;">{{ $absentCount }}</div>
                        <div class="text-muted" style="font-size:12px;">Absent ({{ $totalClasses > 0 ? round(($absentCount / $totalClasses) * 100) : 0 }}%)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
