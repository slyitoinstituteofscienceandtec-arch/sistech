@extends('layouts.app')
@section('title', $student->user->name . ' - Attendance')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 12px; padding: 24px; color: white;
    }
    .profile-avatar {
        width: 60px; height: 60px; border-radius: 50%; background: rgba(255,255,255,0.2);
        display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700;
        border: 3px solid rgba(255,255,255,0.3);
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Attendance Records</h4>
        <p class="text-muted mb-0" style="font-size:13px;">{{ $student->student_id }} - {{ $student->user->name }}</p>
    </div>
    <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    @php
                        $total = $attendances->total();
                        $present = $attendances->getCollection()->where('status', 'present')->count();
                        $rate = $total > 0 ? round(($present / $total) * 100) : 0;
                    @endphp
                    <div class="stat-value" style="font-size:20px;">{{ $rate }}%</div>
                    <div class="stat-label">Attendance Rate</div>
                </div>
                <div class="stat-icon" style="background:var(--green-light);color:var(--green);width:40px;height:40px;font-size:16px;">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="font-size:20px;">{{ $total }}</div>
                    <div class="stat-label">Total Sessions</div>
                </div>
                <div class="stat-icon" style="background:var(--primary-light);color:var(--primary);width:40px;height:40px;font-size:16px;">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="font-size:20px;color:var(--green);">{{ $present }}</div>
                    <div class="stat-label">Present</div>
                </div>
                <div class="stat-icon" style="background:var(--green-light);color:var(--green);width:40px;height:40px;font-size:16px;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="font-size:20px;color:#DC2626;">{{ $total - $present }}</div>
                    <div class="stat-label">Absent / Late / Excused</div>
                </div>
                <div class="stat-icon" style="background:#FEF2F2;color:#DC2626;width:40px;height:40px;font-size:16px;">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clipboard-check me-2" style="color: var(--primary);"></i>Attendance History</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $attendances->total() }} Records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Time In</th>
                        <th>Method</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $record)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                        <td><span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $record->course->code ?? '' }}</span> {{ $record->course->name ?? '' }}</td>
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
                                {{ ucfirst($record->method ?? 'Manual') }}
                            </span>
                        </td>
                        <td>{{ $record->remarks ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-check" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No attendance records for this student.</p>
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
