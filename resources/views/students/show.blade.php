@extends('layouts.app')
@section('title', 'Student Profile')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 12px; padding: 30px; color: white; position: relative; overflow: hidden;
    }
    .profile-header::after {
        content: ''; position: absolute; top: -50%; right: -20%; width: 300px; height: 300px;
        background: rgba(255,255,255,0.05); border-radius: 50%;
    }
    .profile-avatar {
        width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.2);
        display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700;
        border: 3px solid rgba(255,255,255,0.3);
    }
    .nav-tab-sistech .nav-link {
        font-size: 13px; font-weight: 500; color: var(--text-muted); border: none; padding: 10px 20px;
        border-bottom: 2px solid transparent; border-radius: 0;
    }
    .nav-tab-sistech .nav-link.active {
        color: var(--primary); border-bottom-color: var(--primary); background: none;
    }
    .nav-tab-sistech .nav-link:hover { color: var(--text); background: none; }
    .info-row { padding: 10px 0; border-bottom: 1px solid var(--border); }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 14px; font-weight: 500; color: var(--text); }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Student Profile</h4>
        <p class="text-muted mb-0" style="font-size:13px;">{{ $student->student_id }} - {{ $student->user->name ?? '' }}</p>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->user()->role !== 'staff')
        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sistech">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        @endif
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

@if(session('login_credentials'))
@php $creds = session('login_credentials'); @endphp
<div class="card-sistech mb-4" style="border: 2px solid var(--green); background: var(--green-light);">
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3" style="padding: 16px 20px;">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-check-circle" style="color: var(--green); font-size: 20px;"></i>
            <strong style="color: var(--green);">Student Created Successfully!</strong>
        </div>
        <div class="d-flex flex-wrap gap-4" style="font-size: 13px;">
            <div><span class="text-muted">Login:</span> <strong>{{ $creds['email'] }}</strong></div>
            <div><span class="text-muted">Password:</span> <code style="background: white; padding: 3px 8px; border-radius: 4px;">{{ $creds['password'] }}</code></div>
        </div>
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-4">
        <div class="profile-header mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar">
                    {{ substr($student->user->name ?? 'S', 0, 1) }}
                </div>
                <div>
                    <h5 class="fw-bold mb-0">{{ $student->user->name ?? '-' }}</h5>
                    <small style="opacity:0.8;">{{ $student->student_id }}</small>
                </div>
            </div>
            <div class="mt-3 d-flex gap-3" style="font-size:12px;">
                <div>
                    <div style="opacity:0.7;">Index Number</div>
                    <div class="fw-bold">{{ $student->index_number ?? '-' }}</div>
                </div>
                <div>
                    <div style="opacity:0.7;">Status</div>
                    <div>
                        <span class="badge-status badge-{{ $student->status === 'active' ? 'active' : ($student->status === 'graduated' ? 'paid' : ($student->status === 'deferred' ? 'pending' : 'inactive')) }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value" style="font-size:20px;">{{ $student->courseRegistrations->count() }}</div>
                            <div class="stat-label">Courses</div>
                        </div>
                        <div class="stat-icon" style="background:var(--primary-light);color:var(--primary);width:40px;height:40px;font-size:16px;">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value" style="font-size:20px;">{{ $student->results->count() ? round($student->results->avg('grade_point') ?? 0, 2) : 'N/A' }}</div>
                            <div class="stat-label">GPA</div>
                        </div>
                        <div class="stat-icon" style="background:var(--green-light);color:var(--green);width:40px;height:40px;font-size:16px;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-value" style="font-size:20px;color:#DC2626;">SLE {{ number_format($student->invoices->sum('balance'), 2) }}</div>
                            <div class="stat-label">Outstanding</div>
                        </div>
                        <div class="stat-icon" style="background:#FEF2F2;color:#DC2626;width:40px;height:40px;font-size:16px;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            @php
                                $totalClasses = $student->attendances->count();
                                $presentClasses = $student->attendances->where('status', 'present')->count();
                                $attendanceRate = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100) : 0;
                            @endphp
                            <div class="stat-value" style="font-size:20px;">{{ $attendanceRate }}%</div>
                            <div class="stat-label">Attendance</div>
                        </div>
                        <div class="stat-icon" style="background:#FEF3C7;color:#D97706;width:40px;height:40px;font-size:16px;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card-sistech">
            <div class="card-header p-0" style="background:none;">
                <ul class="nav nav-tab-sistech" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal" type="button">
                            <i class="fas fa-user me-1"></i> Personal Info
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#academic" type="button">
                            <i class="fas fa-graduation-cap me-1"></i> Academic
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#courses" type="button">
                            <i class="fas fa-book me-1"></i> Courses
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#attendance" type="button">
                            <i class="fas fa-clipboard-check me-1"></i> Attendance
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#results" type="button">
                            <i class="fas fa-chart-bar me-1"></i> Results
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#fees" type="button">
                            <i class="fas fa-money-bill me-1"></i> Fees
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="personal">
                        <h6 class="fw-bold mb-3" style="font-size:14px;">Personal Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value">{{ $student->user->name ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Email</div>
                                    <div class="info-value">{{ $student->user->email ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Phone</div>
                                    <div class="info-value">{{ $student->user->phone ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Gender</div>
                                    <div class="info-value">{{ ucfirst($student->gender ?? '-') }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="info-value">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">National ID</div>
                                    <div class="info-value">{{ $student->national_id ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Address</div>
                                    <div class="info-value">{{ $student->address ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Guardian Name</div>
                                    <div class="info-value">{{ $student->guardian_name ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Guardian Phone</div>
                                    <div class="info-value">{{ $student->guardian_phone ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Guardian Email</div>
                                    <div class="info-value">{{ $student->guardian_email ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Previous School</div>
                                    <div class="info-value">{{ $student->previous_school ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Previous Qualification</div>
                                    <div class="info-value">{{ $student->qualification ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="academic">
                        <h6 class="fw-bold mb-3" style="font-size:14px;">Academic Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Student ID</div>
                                    <div class="info-value">{{ $student->student_id }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Index Number</div>
                                    <div class="info-value">{{ $student->index_number ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Programme</div>
                                    <div class="info-value">{{ $student->programme->name ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Department</div>
                                    <div class="info-value">{{ $student->department->name ?? '-' }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Academic Year</div>
                                    <div class="info-value">{{ $student->academicYear->name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Admission Date</div>
                                    <div class="info-value">{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <div class="info-label">Status</div>
                                    <div class="info-value">
                                        <span class="badge-status badge-{{ $student->status === 'active' ? 'active' : ($student->status === 'graduated' ? 'paid' : ($student->status === 'deferred' ? 'pending' : 'inactive')) }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="courses">
                        <h6 class="fw-bold mb-3" style="font-size:14px;">Registered Courses</h6>
                        <div class="table-responsive">
                            <table class="table table-sistech mb-0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Course Name</th>
                                        <th>Credit</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($student->courseRegistrations as $reg)
                                    <tr>
                                        <td><strong>{{ $reg->course->code ?? '-' }}</strong></td>
                                        <td>{{ $reg->course->name ?? '-' }}</td>
                                        <td>{{ $reg->course->credit_units ?? '-' }}</td>
                                        <td>{{ $reg->semester->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ $reg->status === 'registered' ? 'active' : 'pending' }}">
                                                {{ ucfirst($reg->status ?? '-') }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">No courses registered</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="attendance">
                        <h6 class="fw-bold mb-3" style="font-size:14px;">Attendance Records</h6>
                        <div class="table-responsive">
                            <table class="table table-sistech mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th>Time In</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($student->attendances as $att)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                                        <td><strong>{{ $att->course->code ?? '-' }} - {{ $att->course->name ?? '-' }}</strong></td>
                                        <td>
                                            <span class="badge-status badge-{{ $att->status === 'present' ? 'active' : ($att->status === 'late' ? 'pending' : 'inactive') }}">
                                                {{ ucfirst($att->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $att->time_in ?? '-' }}</td>
                                        <td>{{ $att->remarks ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">No attendance records</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @php
                            $totalClasses = $student->attendances->count();
                            $presentCount = $student->attendances->where('status', 'present')->count();
                            $lateCount = $student->attendances->where('status', 'late')->count();
                            $absentCount = $student->attendances->where('status', 'absent')->count();
                            $excusedCount = $student->attendances->where('status', 'excused')->count();
                        @endphp
                        @if($totalClasses > 0)
                        <div class="row g-3 mt-3">
                            <div class="col-3">
                                <div class="text-center p-2 rounded" style="background: var(--green-light);">
                                    <div class="fw-bold" style="color: var(--green); font-size: 18px;">{{ $presentCount }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Present</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="text-center p-2 rounded" style="background: #FEF3C7;">
                                    <div class="fw-bold" style="color: #D97706; font-size: 18px;">{{ $lateCount }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Late</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="text-center p-2 rounded" style="background: #FEF2F2;">
                                    <div class="fw-bold" style="color: #DC2626; font-size: 18px;">{{ $absentCount }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Absent</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="text-center p-2 rounded" style="background: var(--primary-light);">
                                    <div class="fw-bold" style="color: var(--primary); font-size: 18px;">{{ $excusedCount }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Excused</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="results">
                        <h6 class="fw-bold mb-3" style="font-size:14px;">Academic Results</h6>
                        <div class="table-responsive">
                            <table class="table table-sistech mb-0">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Score</th>
                                        <th>Grade</th>
                                        <th>Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($student->results as $result)
                                    <tr>
                                        <td><strong>{{ $result->course->name ?? '-' }}</strong></td>
                                        <td>{{ $result->total_score ?? '-' }}</td>
                                        <td>
                                            <span class="badge-status badge-{{ ($result->grade ?? '') === 'F' ? 'inactive' : 'active' }}">
                                                {{ $result->grade ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $result->course->credit_units ?? '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No results available</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="fees">
                        <h6 class="fw-bold mb-3" style="font-size:14px;">Fee Records</h6>
                        <div class="table-responsive">
                            <table class="table table-sistech mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($student->invoices as $invoice)
                                    <tr>
                                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                        <td>{{ $invoice->description ?? '-' }}</td>
                                        <td>SLE {{ number_format($invoice->amount, 2) }}</td>
                                        <td>SLE {{ number_format($invoice->paid_amount, 2) }}</td>
                                        <td style="color:{{ $invoice->balance > 0 ? '#DC2626' : 'var(--green)' }};">
                                            SLE {{ number_format($invoice->balance, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge-status badge-{{ $invoice->status === 'paid' ? 'paid' : ($invoice->status === 'partial' ? 'partial' : 'unpaid') }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">No fee records</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
