@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Notifications</h4>
        <p class="text-muted mb-0" style="font-size:13px;">View and manage your notifications</p>
    </div>
    @if($notifications ?? false)
    <form method="POST" action="{{ route('student.notifications.mark-all-read') }}">
        @csrf
        <button type="submit" class="btn-sistech" style="font-size:13px; padding: 6px 14px;">
            <i class="fas fa-check-double me-1"></i> Mark All Read
        </button>
    </form>
    @endif
</div>

@forelse($notifications ?? [] as $notification)
<div class="card-sistech mb-2" style="{{ !$notification->is_read ? 'border-left: 3px solid var(--primary);' : '' }}">
    <div class="card-body py-3 px-4">
        <div class="d-flex align-items-start gap-3">
            <div class="stat-icon flex-shrink-0" style="width:40px; height:40px; font-size:16px; border-radius:10px;
                @if(($notification->type ?? '') === 'payment') background: var(--green-light); color: var(--green);
                @elseif(($notification->type ?? '') === 'academic') background: var(--primary-light); color: var(--primary);
                @elseif(($notification->type ?? '') === 'alert') background: #FEF2F2; color: #DC2626;
                @else background: #FEF3C7; color: #D97706;
                @endif">
                @if(($notification->type ?? '') === 'payment')
                    <i class="fas fa-money-bill-wave"></i>
                @elseif(($notification->type ?? '') === 'academic')
                    <i class="fas fa-graduation-cap"></i>
                @elseif(($notification->type ?? '') === 'alert')
                    <i class="fas fa-exclamation-triangle"></i>
                @else
                    <i class="fas fa-bell"></i>
                @endif
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center gap-2">
                        <strong style="font-size:13.5px;">{{ $notification->title ?? 'Notification' }}</strong>
                        @if(!$notification->is_read)
                            <span class="badge" style="background: var(--primary); color: white; font-size:9px; padding: 2px 6px; border-radius: 4px;">NEW</span>
                        @endif
                    </div>
                    <small class="text-muted">{{ $notification->created_at?->diffForHumans() }}</small>
                </div>
                <p class="mb-1 mt-1" style="font-size:13px; color: var(--text-muted);">{{ $notification->message ?? '' }}</p>
                @if(!$notification->is_read)
                <form method="POST" action="{{ route('student.notifications.read', $notification->id) }}" class="mt-1">
                    @csrf
                    <button type="submit" class="btn btn-sm" style="font-size:11px; color: var(--primary); padding: 2px 8px;">
                        <i class="fas fa-check me-1"></i> Mark as read
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@empty
<div class="card-sistech">
    <div class="card-body text-center py-5">
        <i class="fas fa-bell-slash fa-3x mb-3" style="opacity:0.2;"></i>
        <p class="text-muted mb-0">No notifications yet.</p>
    </div>
</div>
@endforelse

@if($notifications ?? false)
<div class="d-flex justify-content-center mt-4">
    {{ $notifications->links() }}
</div>
@endif
@endsection
