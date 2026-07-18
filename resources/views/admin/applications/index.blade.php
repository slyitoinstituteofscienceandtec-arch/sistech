@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="margin: 0; font-weight: 700;"><i class="fas fa-file-alt me-2" style="color: var(--primary);"></i>Applications</h4>
        <small class="text-muted">{{ $pendingCount }} pending review</small>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('admin.applications.index') }}" class="text-decoration-none">
            <div class="stat-card" style="border-left: 4px solid #CA8A04;">
                <div class="stat-icon" style="background: #FEF9C3; color: #CA8A04;"><i class="fas fa-clock"></i></div>
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.applications.index', ['status' => 'approved']) }}" class="text-decoration-none">
            <div class="stat-card" style="border-left: 4px solid var(--green);">
                <div class="stat-icon" style="background: var(--green-light); color: var(--green);"><i class="fas fa-check-circle"></i></div>
                <div class="stat-value">{{ $approvedCount }}</div>
                <div class="stat-label">Approved</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.applications.index', ['status' => 'rejected']) }}" class="text-decoration-none">
            <div class="stat-card" style="border-left: 4px solid #DC2626;">
                <div class="stat-icon" style="background: #FEF2F2; color: #DC2626;"><i class="fas fa-times-circle"></i></div>
                <div class="stat-value">{{ $rejectedCount }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </a>
    </div>
</div>

<div class="card-sistech">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>App #</th>
                        <th>Applicant</th>
                        <th>Programme</th>
                        <th>Applied</th>
                        <th>Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td><strong style="color: var(--primary);">{{ $app->application_number }}</strong></td>
                        <td>
                            <div style="font-size: 13.5px;">{{ $app->first_name }} {{ $app->last_name }}</div>
                            <small class="text-muted">{{ $app->email }}</small>
                        </td>
                        <td><span style="font-size: 13px;">{{ $app->programme->name ?? 'N/A' }}</span></td>
                        <td><small class="text-muted">{{ $app->created_at->format('M d, Y') }}</small></td>
                        <td>
                            @if($app->status === 'pending')
                            <span class="badge-status badge-pending">Pending</span>
                            @elseif($app->status === 'approved')
                            <span class="badge-status badge-active">Approved</span>
                            @else
                            <span class="badge-status badge-inactive">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-outline-primary btn-sm" title="Review">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-file-alt fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                            No applications found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($applications, 'links'))
    <div class="card-footer d-flex justify-content-center" style="background: var(--bg); border-top: 1px solid var(--border);">
        {{ $applications->links() }}
    </div>
    @endif
</div>
@endsection
