@extends('layouts.app')
@section('title', 'Announcements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Announcements</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Stay updated with the latest announcements</p>
    </div>
</div>

@forelse($announcements ?? [] as $announcement)
<div class="card-sistech mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold mb-0" style="font-size:15px;">{{ $announcement->title }}</h5>
                @if($announcement->type)
                    <span class="badge-status" style="background: var(--primary-light); color: var(--primary);">{{ ucfirst($announcement->type) }}</span>
                @endif
            </div>
            <small class="text-muted">{{ $announcement->publish_date ? \Carbon\Carbon::parse($announcement->publish_date)->format('d M Y') : $announcement->created_at?->format('d M Y') }}</small>
        </div>
        <p class="mb-2" style="font-size:13.5px; color: var(--text-muted);">{{ Str::limit($announcement->content, 200) }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fas fa-user-circle me-1"></i> {{ $announcement->creator->name ?? 'Administration' }}
            </small>
            <small class="text-muted">{{ $announcement->created_at?->diffForHumans() }}</small>
        </div>
    </div>
</div>
@empty
<div class="card-sistech">
    <div class="card-body text-center py-5">
        <i class="fas fa-bullhorn fa-3x mb-3" style="opacity:0.2;"></i>
        <p class="text-muted mb-0">No announcements available at this time.</p>
    </div>
</div>
@endforelse

@if($announcements ?? false)
<div class="d-flex justify-content-center mt-4">
    {{ $announcements->links() }}
</div>
@endif
@endsection
