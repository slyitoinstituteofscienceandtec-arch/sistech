@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Profile</h4>
        <p class="text-muted mb-0" style="font-size:13px;">View your full profile information</p>
    </div>
    <span class="badge" style="background: var(--primary-light); color: var(--primary); padding: 8px 14px; border-radius: 8px; font-size: 12px;">
        <i class="fas fa-id-card me-1"></i> {{ $student->student_id ?? 'N/A' }}
    </span>
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center gap-4">
            <div style="width:80px;height:80px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:28px;">
                {{ substr($student->user->name ?? auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <h4 class="fw-bold mb-1">{{ $student->user->name ?? auth()->user()->name }}</h4>
                <p class="text-muted mb-1" style="font-size:13px;">
                    <i class="fas fa-id-card me-1"></i> {{ $student->student_id ?? 'N/A' }}
                    <span class="mx-2">|</span>
                    <i class="fas fa-envelope me-1"></i> {{ $student->user->email ?? auth()->user()->email }}
                </p>
                <span class="badge-status badge-active">{{ ucfirst($student->status ?? 'Active') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card-sistech h-100">
            <div class="card-header">
                <i class="fas fa-user me-2" style="color: var(--primary);"></i>Personal Information
            </div>
            <div class="card-body" style="font-size: 13px;">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Full Name</span>
                    <strong>{{ $student->user->name ?? auth()->user()->name }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Email</span>
                    <strong>{{ $student->user->email ?? auth()->user()->email }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Phone</span>
                    <strong>{{ $student->user->phone ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Gender</span>
                    <strong>{{ ucfirst($student->gender ?? 'N/A') }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Date of Birth</span>
                    <strong>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">National ID</span>
                    <strong>{{ $student->national_id ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Address</span>
                    <strong class="text-end" style="max-width:60%;">{{ $student->address ?? 'N/A' }}</strong>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-sistech h-100">
            <div class="card-header">
                <i class="fas fa-graduation-cap me-2" style="color: var(--green);"></i>Academic Information
            </div>
            <div class="card-body" style="font-size: 13px;">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Student ID</span>
                    <strong>{{ $student->student_id ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Index Number</span>
                    <strong>{{ $student->index_number ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Programme</span>
                    <strong>{{ $student->programme->name ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Department</span>
                    <strong>{{ $student->programme->department->name ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Academic Year</span>
                    <strong>{{ $student->academicYear->name ?? 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Admission Date</span>
                    <strong>{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d M Y') : 'N/A' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Status</span>
                    <span class="badge-status badge-active">{{ ucfirst($student->status ?? 'Active') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-sistech mb-4">
    <div class="card-header">
        <i class="fas fa-users me-2" style="color: #D97706;"></i>Guardian Information
    </div>
    <div class="card-body" style="font-size: 13px;">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Guardian Name</span>
                    <strong>{{ $student->guardian_name ?? 'N/A' }}</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Guardian Phone</span>
                    <strong>{{ $student->guardian_phone ?? 'N/A' }}</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Guardian Email</span>
                    <strong>{{ $student->guardian_email ?? 'N/A' }}</strong>
                </div>
            </div>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-md-4">
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Relationship</span>
                    <strong>{{ $student->relationship ?? 'N/A' }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header">
        <i class="fas fa-school me-2" style="color: var(--primary);"></i>Previous School & Qualifications
    </div>
    <div class="card-body" style="font-size: 13px;">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Previous School</span>
                    <strong class="text-end" style="max-width:60%;">{{ $student->previous_school ?? 'N/A' }}</strong>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                    <span class="text-muted">Qualification</span>
                    <strong>{{ $student->qualification ?? 'N/A' }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
