@extends('layouts.app')
@section('title', 'Staff Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 style="color: var(--primary); font-weight: 700;">Staff Profile</h2>
        </div>
        <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-sistech">
            <i class="bi bi-pencil me-1"></i> Edit Profile
        </a>
    </div>

    @if(session('login_credentials'))
    @php $creds = session('login_credentials'); @endphp
    <div class="card mb-4" style="border: 2px solid var(--green); background: var(--green-light); border-radius: 12px;">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3" style="padding: 16px 20px;">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle" style="color: var(--green); font-size: 20px;"></i>
                <strong style="color: var(--green);">Staff Registered Successfully!</strong>
            </div>
            <div class="d-flex flex-wrap gap-4" style="font-size: 13px;">
                <div><span class="text-muted">Login:</span> <strong>{{ $creds['email'] }}</strong></div>
                <div><span class="text-muted">Password:</span> <code style="background: white; padding: 3px 8px; border-radius: 4px;">{{ $creds['password'] }}</code></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Staff Info Card -->
    <div class="card shadow-sm mb-4" style="border-top: 4px solid var(--primary);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: var(--primary); color: #fff; font-size: 2.5rem; font-weight: 700;">
                        {{ strtoupper(substr($staff->user->name ?? '', 0, 2)) }}
                    </div>
                </div>
                <div class="col-md-5">
                    <h3 class="mb-1 fw-bold" style="color: var(--primary);">{{ $staff->user->name ?? '' }}</h3>
                    <p class="text-muted mb-2">
                        <i class="bi bi-hash me-1"></i> {{ $staff->staff_id ?? 'N/A' }}
                    </p>
                    <p class="mb-1">
                        <i class="bi bi-envelope me-2" style="color: var(--primary);"></i> {{ $staff->user->email ?? '' }}
                    </p>
                    @if($staff->user->phone ?? false)
                        <p class="mb-0">
                            <i class="bi bi-telephone me-2" style="color: var(--primary);"></i> {{ $staff->user->phone }}
                        </p>
                    @endif
                </div>
                <div class="col-md-5 text-md-end">
                    <div class="mb-2">
                        <span class="badge px-3 py-2" style="background: var(--primary); color: #fff; font-size: 0.9rem;">
                            {{ ucfirst(str_replace('_', ' ', $staff->position)) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 0.85rem;">
                            {{ ucfirst(str_replace('_', ' ', $staff->employment_type ?? '')) }}
                        </span>
                    </div>
                    <div>
                        @if($staff->status === 'active')
                            <span class="badge px-3 py-2" style="background: var(--green); color: #fff; font-size: 0.85rem;">Active</span>
                        @elseif($staff->status === 'inactive')
                            <span class="badge bg-secondary px-3 py-2">Inactive</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">{{ ucfirst($staff->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Personal Details -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold" style="background: var(--primary); color: #fff;">
                    <i class="bi bi-person me-2"></i> Personal Details
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 40%;">Full Name</td>
                                <td class="fw-semibold">{{ $staff->user->name ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td class="fw-semibold">{{ $staff->user->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Phone</td>
                                <td class="fw-semibold">{{ $staff->user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Qualification</td>
                                <td class="fw-semibold">{{ $staff->qualification ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Specialization</td>
                                <td class="fw-semibold">{{ $staff->specialization ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Employment Details -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header fw-semibold" style="background: var(--primary); color: #fff;">
                    <i class="bi bi-briefcase me-2"></i> Employment Details
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width: 40%;">Staff ID</td>
                                <td class="fw-semibold" style="color: var(--primary);">{{ $staff->staff_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Department</td>
                                <td class="fw-semibold">{{ $staff->department->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Position</td>
                                <td class="fw-semibold">
                                    <span class="badge" style="background: var(--primary); color: #fff;">
                                        {{ ucfirst(str_replace('_', ' ', $staff->position)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Employment Type</td>
                                <td class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $staff->employment_type ?? '')) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Hire Date</td>
                                <td class="fw-semibold">{{ $staff->hire_date ? \Carbon\Carbon::parse($staff->hire_date)->format('d M Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Salary</td>
                                <td class="fw-semibold" style="color: var(--green);">
                                    {{ $staff->salary ? 'SLE ' . number_format($staff->salary, 2) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td class="fw-semibold">
                                    @if($staff->status === 'active')
                                        <span class="badge" style="background: var(--green); color: #fff;">Active</span>
                                    @elseif($staff->status === 'inactive')
                                        <span class="badge bg-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($staff->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary px-4">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
        <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-sistech px-4">
            <i class="bi bi-pencil me-1"></i> Edit Profile
        </a>
    </div>
</div>
@endsection
