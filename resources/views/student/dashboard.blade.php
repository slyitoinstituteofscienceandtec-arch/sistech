@extends('layouts.app')
@section('title', 'Student Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Welcome, {{ auth()->user()->name }}!</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Student Portal Dashboard</p>
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
                    <div class="stat-value">{{ $courses->count() ?? 0 }}</div>
                    <div class="stat-label">Enrolled Courses</div>
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
                    <div class="stat-value" style="color: var(--green);">{{ number_format($attendanceRate ?? 0, 0) }}%</div>
                    <div class="stat-label">Attendance Rate</div>
                </div>
                <div class="stat-icon" style="background: var(--green-light); color: var(--green);">
                    <i class="fas fa-clipboard-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="color: #D97706;">{{ number_format($cgpa ?? 0, 2) }}</div>
                    <div class="stat-label">Current CGPA</div>
                </div>
                <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-sistech mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-book me-2" style="color: var(--primary);"></i>My Courses</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th>Lecturer</th>
                                <th class="text-center">Attendance</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses ?? [] as $reg)
                            <tr>
                                <td><strong style="color: var(--primary);">{{ $reg->course->code ?? '-' }}</strong></td>
                                <td>{{ $reg->course->name ?? '-' }}</td>
                                <td>{{ $reg->course->lecturer->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @php
                                        $courseAtts = $student->attendances->where('course_id', $reg->course_id);
                                        $courseTotal = $courseAtts->count();
                                        $coursePresent = $courseAtts->where('status', 'present')->count();
                                        $rate = $courseTotal > 0 ? round(($coursePresent / $courseTotal) * 100) : 0;
                                    @endphp
                                    <span style="color: {{ $rate >= 75 ? 'var(--green)' : ($rate >= 50 ? '#D97706' : '#DC2626') }};">
                                        {{ number_format($rate, 0) }}%
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge-status badge-active">Enrolled</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No courses enrolled.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar me-2" style="color: var(--green);"></i>Recent Results</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th class="text-center">CA</th>
                                <th class="text-center">Exam</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results ?? [] as $result)
                            <tr>
                                <td><strong>{{ $result->course->code ?? '-' }}</strong></td>
                                <td class="text-center">{{ number_format($result->ca_score, 1) }}</td>
                                <td class="text-center">{{ number_format($result->exam_score, 1) }}</td>
                                <td class="text-center fw-bold">{{ number_format($result->total_score, 1) }}</td>
                                <td class="text-center">
                                    <span class="fw-bold" style="color: {{ ($result->total_score ?? 0) >= 70 ? 'var(--green)' : (($result->total_score ?? 0) >= 50 ? '#D97706' : '#DC2626') }};">
                                        {{ $result->grade ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No results yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-sistech mb-3">
            <div class="card-header">
                <i class="fas fa-user me-2" style="color: var(--primary);"></i>Profile
            </div>
            <div class="card-body" style="font-size: 13px;">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Programme</span>
                    <strong>{{ $student->programme->name ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Department</span>
                    <strong>{{ $student->programme->department->name ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Year of Study</span>
                    <strong>{{ ucfirst(str_replace('_', ' ', $student->level ?? 'N/A')) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Status</span>
                    <span class="badge-status badge-active">{{ ucfirst($student->status ?? 'Active') }}</span>
                </div>
            </div>
        </div>

        <div class="card-sistech mb-3">
            <div class="card-header">
                <i class="fas fa-bullhorn me-2" style="color: #D97706;"></i>Announcements
            </div>
            <div class="card-body">
                @forelse($recentAnnouncements ?? [] as $announcement)
                <div class="mb-2 pb-2" style="border-bottom: 1px solid var(--border);">
                    <strong style="font-size: 12.5px;">{{ $announcement->title }}</strong>
                    <p class="text-muted mb-0" style="font-size: 11.5px;">{{ Str::limit($announcement->content, 60) }}</p>
                    <small class="text-muted">{{ $announcement->created_at?->diffForHumans() }}</small>
                </div>
                @empty
                <p class="text-center text-muted mb-0">No announcements</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
