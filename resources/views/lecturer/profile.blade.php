@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Profile</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Your staff profile and information</p>
    </div>
</div>

@if(isset($staff))
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card-sistech mb-3" style="border-top: 4px solid var(--primary);">
            <div class="card-body text-center py-4">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; background: var(--primary); color: #fff; font-size: 2.5rem; font-weight: 700;">
                    {{ strtoupper(substr($staff->user->name ?? '', 0, 2)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $staff->user->name ?? '' }}</h5>
                <p class="text-muted mb-2" style="font-size: 13px;">
                    <i class="fas fa-id-badge me-1"></i> {{ $staff->staff_id ?? 'N/A' }}
                </p>
                <span class="badge-status {{ ($staff->status ?? '') === 'active' ? 'badge-active' : 'badge-inactive' }}">
                    {{ ucfirst($staff->status ?? 'Active') }}
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card-sistech h-100">
                    <div class="card-header">
                        <i class="fas fa-user me-2" style="color: var(--primary);"></i>Personal Information
                    </div>
                    <div class="card-body" style="font-size: 13px;">
                        <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                            <span class="text-muted">Full Name</span>
                            <strong>{{ $staff->user->name ?? 'N/A' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                            <span class="text-muted">Email</span>
                            <strong>{{ $staff->user->email ?? 'N/A' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Phone</span>
                            <strong>{{ $staff->user->phone ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-sistech h-100">
                    <div class="card-header">
                        <i class="fas fa-briefcase me-2" style="color: var(--green);"></i>Employment Details
                    </div>
                    <div class="card-body" style="font-size: 13px;">
                        <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                            <span class="text-muted">Department</span>
                            <strong>{{ $staff->department->name ?? 'N/A' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                            <span class="text-muted">Position</span>
                            <strong>{{ ucfirst(str_replace('_', ' ', $staff->position ?? '')) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                            <span class="text-muted">Employment Type</span>
                            <strong>{{ ucfirst(str_replace('_', ' ', $staff->employment_type ?? '')) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted">Hire Date</span>
                            <strong>{{ $staff->hire_date ? \Carbon\Carbon::parse($staff->hire_date)->format('d M Y') : 'N/A' }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card-sistech">
                    <div class="card-header">
                        <i class="fas fa-graduation-cap me-2" style="color: #D97706;"></i>Qualifications
                    </div>
                    <div class="card-body" style="font-size: 13px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                                    <span class="text-muted">Qualification</span>
                                    <strong>{{ $staff->qualification ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--border);">
                                    <span class="text-muted">Specialization</span>
                                    <strong>{{ $staff->specialization ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="card-sistech">
    <div class="card-body text-center py-5 text-muted">
        <i class="fas fa-user-slash" style="font-size: 3rem; opacity: 0.3;"></i>
        <p class="mt-2 mb-0">No staff profile found. Please contact the administrator.</p>
    </div>
</div>
@endif
@endsection
