@extends('layouts.app')
@section('title', 'Lecturer Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Welcome, {{ auth()->user()->name }}!</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Lecturer Portal Dashboard</p>
    </div>
    <span class="badge" style="background: var(--primary-light); color: var(--primary); padding: 8px 14px; border-radius: 8px; font-size: 12px;">
        <i class="fas fa-chalkboard-teacher me-1"></i> Lecturer
    </span>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $totalCourses ?? 0 }}</div>
                    <div class="stat-label">My Courses</div>
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
                    <div class="stat-value">{{ $totalStudents ?? 0 }}</div>
                    <div class="stat-label">My Students</div>
                </div>
                <div class="stat-icon" style="background: var(--green-light); color: var(--green);">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $todayAttendance ?? 0 }}</div>
                    <div class="stat-label">Today's Attendance</div>
                </div>
                <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fas fa-clipboard-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $pendingResults ?? 0 }}</div>
                    <div class="stat-label">Pending Results</div>
                </div>
                <div class="stat-icon" style="background: #FEF2F2; color: #DC2626;">
                    <i class="fas fa-hourglass-half"></i>
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
                                <th>Department</th>
                                <th class="text-center">Students</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myCourses ?? [] as $course)
                            <tr>
                                <td><strong style="color: var(--primary);">{{ $course->code }}</strong></td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->department->name ?? '-' }}</td>
                                <td class="text-center">{{ $course->registrations->count() }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ url('lecturer/attendance') }}?course_id={{ $course->id }}" class="btn btn-outline-success btn-sm" title="Take Attendance">
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                        <a href="{{ url('lecturer/results') }}?course_id={{ $course->id }}" class="btn btn-outline-primary btn-sm" title="Enter Results">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No courses assigned.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock me-2" style="color: #D97706;"></i>Recent Attendance</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Course</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendance ?? [] as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                                <td>{{ $record->student->user->name ?? '-' }}</td>
                                <td>{{ $record->course->code ?? '-' }}</td>
                                <td class="text-center">
                                    @if($record->status === 'present')
                                        <span class="badge-status badge-active">Present</span>
                                    @elseif($record->status === 'absent')
                                        <span class="badge-status badge-inactive">Absent</span>
                                    @elseif($record->status === 'late')
                                        <span class="badge-status badge-pending">Late</span>
                                    @else
                                        <span class="badge-status" style="background: #EDE9FE; color: #7C3AED;">Excused</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No recent attendance records.</td>
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
                <i class="fas fa-bullhorn me-2" style="color: var(--green);"></i>Announcements
            </div>
            <div class="card-body">
                @forelse($announcements ?? [] as $announcement)
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

        <div class="card-sistech">
            <div class="card-header">
                <i class="fas fa-bolt me-2" style="color: #D97706;"></i>Quick Actions
            </div>
            <div class="card-body">
                <a href="{{ url('lecturer/attendance') }}" class="btn btn-sistech w-100 mb-2">
                    <i class="fas fa-clipboard-check me-1"></i> Take Attendance
                </a>
                <a href="{{ url('lecturer/results') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-edit me-1"></i> Enter Results
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
