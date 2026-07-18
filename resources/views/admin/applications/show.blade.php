@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="margin: 0; font-weight: 700;"><i class="fas fa-file-alt me-2" style="color: var(--primary);"></i>{{ $application->application_number }}</h4>
        <small class="text-muted">{{ $application->first_name }} {{ $application->last_name }}</small>
    </div>
    <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Applications
    </a>
</div>

<div class="row g-4">
    @if(session('approval_credentials'))
    @php $creds = session('approval_credentials'); @endphp
    <div class="col-12">
        <div class="card-sistech" style="border: 2px solid var(--green); background: var(--green-light);">
            <div class="card-header" style="background: var(--green); color: white; font-weight: 600;">
                <i class="fas fa-check-circle me-2"></i> Application Approved — Student Account Created
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <small class="text-muted d-block mb-1">Student Name</small>
                        <strong>{{ $creds['student_name'] }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block mb-1">Student ID</small>
                        <strong style="color: var(--primary); font-size: 16px;">{{ $creds['student_id'] }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block mb-1">Login Email</small>
                        <strong>{{ $creds['email'] }}</strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block mb-1">Default Password</small>
                        <code style="font-size: 16px; background: white; padding: 4px 10px; border-radius: 6px;">{{ $creds['password'] }}</code>
                    </div>
                </div>
                <div class="mt-3" style="font-size: 13px; color: var(--text-muted);">
                    <i class="fas fa-info-circle me-1"></i>
                    Share these credentials with the student. The student should change their password after first login.
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-lg-8">
        <div class="card-sistech mb-4">
            <div class="card-header">
                <i class="fas fa-user me-2" style="color: var(--primary);"></i> Personal Information
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Full Name</small>
                        <strong>{{ $application->first_name }} {{ $application->last_name }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Email</small>
                        <span>{{ $application->email }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Phone</small>
                        <span>{{ $application->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Gender</small>
                        <span>{{ ucfirst($application->gender) }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Date of Birth</small>
                        <span>{{ $application->date_of_birth->format('F d, Y') }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Address</small>
                        <span>{{ $application->address ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-sistech mb-4">
            <div class="card-header">
                <i class="fas fa-graduation-cap me-2" style="color: var(--green);"></i> Academic Information
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Programme</small>
                        <strong>{{ $application->programme->name ?? 'N/A' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Previous School</small>
                        <span>{{ $application->previous_school ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Qualification</small>
                        <span>{{ $application->qualification ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-sistech mb-4">
            <div class="card-header">
                <i class="fas fa-users me-2" style="color: #9333ea;"></i> Guardian Information
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Guardian Name</small>
                        <strong>{{ $application->guardian_name ?? 'N/A' }}</strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block mb-1">Guardian Phone</small>
                        <span>{{ $application->guardian_phone ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($application->status === 'approved' || $application->status === 'rejected')
        <div class="card-sistech mb-4" style="border-left: 4px solid {{ $application->status === 'approved' ? 'var(--green)' : '#DC2626' }};">
            <div class="card-header" style="background: {{ $application->status === 'approved' ? 'var(--green-light)' : '#FEF2F2' }};">
                <i class="fas fa-{{ $application->status === 'approved' ? 'check-circle' : 'times-circle' }} me-2"></i>
                Review Decision
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                    <span class="text-muted">Reviewed by</span>
                    <span>{{ $application->reviewedBy->name ?? 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                    <span class="text-muted">Reviewed at</span>
                    <span>{{ $application->reviewed_at?->format('M d, Y h:i A') }}</span>
                </div>
                @if($application->review_notes)
                <div class="mt-2">
                    <small class="text-muted">Notes:</small>
                    <div style="font-size: 13px; white-space: pre-wrap;">{{ $application->review_notes }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card-sistech mb-4">
            <div class="card-header"><i class="fas fa-info-circle me-2"></i> Status</div>
            <div class="card-body text-center">
                @if($application->status === 'pending')
                <span class="badge-status badge-pending" style="font-size: 14px; padding: 8px 20px;">Pending Review</span>
                @elseif($application->status === 'approved')
                <span class="badge-status badge-active" style="font-size: 14px; padding: 8px 20px;">Approved</span>
                @else
                <span class="badge-status badge-inactive" style="font-size: 14px; padding: 8px 20px;">Rejected</span>
                @endif

                <div class="mt-3 text-muted" style="font-size: 12px;">
                    Applied: {{ $application->created_at->format('M d, Y') }}
                </div>
            </div>
        </div>

        @if($application->status === 'pending')
        <div class="card-sistech mb-4" style="border-top: 3px solid var(--green);">
            <div class="card-header" style="background: var(--green-light);">
                <i class="fas fa-check me-2" style="color: var(--green);"></i> Approve
            </div>
            <div class="card-body">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 1rem;">
                    This will create a student account with default password: <code>password</code>
                </p>
                <form method="POST" action="{{ route('admin.applications.approve', $application) }}" onsubmit="return confirm('Approve this application and create a student account?')">
                    @csrf
                    <button type="submit" class="btn btn-sistech-green w-100">
                        <i class="fas fa-check me-1"></i> Approve Application
                    </button>
                </form>
            </div>
        </div>

        <div class="card-sistech mb-4" style="border-top: 3px solid #DC2626;">
            <div class="card-header" style="background: #FEF2F2;">
                <i class="fas fa-times me-2" style="color: #DC2626;"></i> Reject
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.applications.reject', $application) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="review_notes" class="form-control" rows="3" placeholder="Reason for rejection (optional)" style="border-radius: 8px; font-size: 13px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Reject this application?')">
                        <i class="fas fa-times me-1"></i> Reject Application
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
