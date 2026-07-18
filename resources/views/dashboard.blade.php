@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge" style="background: var(--primary-light); color: var(--primary); padding: 8px 14px; border-radius: 8px; font-size: 12px;">
            <i class="fas fa-calendar me-1"></i> {{ $currentYear ? $currentYear->name : 'No Active Year' }}
        </span>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($totalStudents) }}</div>
                    <div class="stat-label">Total Students</div>
                </div>
                <div class="stat-icon" style="background: var(--primary-light); color: var(--primary);">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($totalLecturers) }}</div>
                    <div class="stat-label">Lecturers</div>
                </div>
                <div class="stat-icon" style="background: var(--green-light); color: var(--green);">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($totalCourses) }}</div>
                    <div class="stat-label">Courses</div>
                </div>
                <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($totalStaff) }}</div>
                    <div class="stat-label">Total Staff</div>
                </div>
                <div class="stat-icon" style="background: #EDE9FE; color: #7C3AED;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($totalDepartments) }}</div>
                    <div class="stat-label">Departments</div>
                </div>
                <div class="stat-icon" style="background: #ECFDF5; color: #059669;">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ number_format($todayAttendance) }}</div>
                    <div class="stat-label">Today's Attendance</div>
                </div>
                <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fas fa-clipboard-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user-graduate me-2" style="color: var(--primary);"></i>Recent Students</span>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-sistech">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Programme</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStudents as $student)
                            <tr>
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->programme->name ?? '-' }}</td>
                                <td>
                                    <span class="badge-status badge-{{ $student->status === 'active' ? 'active' : 'inactive' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No students yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-sistech">
            <div class="card-header">
                <i class="fas fa-bullhorn me-2" style="color: var(--green);"></i>Announcements
            </div>
            <div class="card-body">
                @forelse($recentAnnouncements as $announcement)
                <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--border);">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <strong style="font-size: 13px;">{{ $announcement->title }}</strong>
                        <span class="badge" style="background: var(--primary-light); color: var(--primary); font-size: 10px; border-radius: 4px;">
                            {{ ucfirst($announcement->type) }}
                        </span>
                    </div>
                    <p class="mb-1 text-muted" style="font-size: 12px;">{{ Str::limit($announcement->content, 80) }}</p>
                    <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <p class="text-center text-muted mb-0">No announcements</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">
    <div class="col-lg-4">
        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clipboard-check me-2" style="color: #D97706;"></i>Recent Attendance</span>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendance as $att)
                            <tr>
                                <td style="font-size:12px;">{{ $att->student->user->name ?? '-' }}</td>
                                <td><span class="badge" style="background:var(--primary-light);color:var(--primary);font-size:10px;">{{ $att->course->code ?? '' }}</span></td>
                                <td>
                                    @if($att->status === 'present')
                                        <span class="badge-status badge-active" style="font-size:10px;">Present</span>
                                    @elseif($att->status === 'absent')
                                        <span class="badge-status badge-inactive" style="font-size:10px;">Absent</span>
                                    @elseif($att->status === 'late')
                                        <span class="badge-status badge-pending" style="font-size:10px;">Late</span>
                                    @else
                                        <span class="badge" style="background:#EDE9FE;color:#7C3AED;font-size:10px;">Excused</span>
                                    @endif
                                </td>
                                <td style="font-size:11px;color:var(--text-muted);">{{ $att->recordedBy->name ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3" style="font-size:12px;">No attendance records</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar me-2" style="color: var(--green);"></i>Recent Results</span>
                <a href="{{ route('admin.results.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Score</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentResults as $result)
                            <tr>
                                <td style="font-size:12px;">{{ $result->student->user->name ?? '-' }}</td>
                                <td><span class="badge" style="background:var(--primary-light);color:var(--primary);font-size:10px;">{{ $result->course->code ?? '' }}</span></td>
                                <td style="font-size:12px;"><strong>{{ $result->total_score ?? '-' }}</strong></td>
                                <td>
                                    <span class="fw-bold" style="font-size:12px;color:{{ ($result->total_score ?? 0) >= 50 ? 'var(--green)' : '#DC2626' }};">
                                        {{ $result->grade ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3" style="font-size:12px;">No results entered</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-sistech">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-book-reader me-2" style="color: #7C3AED;"></i>Recent Library Books</span>
                <a href="{{ route('admin.library.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sistech mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBooks as $book)
                            <tr>
                                <td style="font-size:12px;"><strong>{{ Str::limit($book->title, 25) }}</strong></td>
                                <td style="font-size:12px;">{{ Str::limit($book->author ?? '-', 15) }}</td>
                                <td><span class="badge bg-light text-dark border" style="font-size:10px;">{{ ucfirst($book->category ?? '-') }}</span></td>
                                <td style="font-size:11px;color:var(--text-muted);">{{ $book->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3" style="font-size:12px;">No books in library</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
