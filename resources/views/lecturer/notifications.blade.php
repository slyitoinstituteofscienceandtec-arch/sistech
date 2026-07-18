@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Notifications</h4>
        <p class="text-muted mb-0" style="font-size:13px;">System and personal notifications</p>
    </div>
    <button class="btn btn-outline-secondary" onclick="markAllRead()">
        <i class="fas fa-check-double me-1"></i> Mark All Read
    </button>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-bell me-2" style="color: var(--primary);"></i>All Notifications</span>
        @php $unreadCount = ($notifications ?? collect())->where('is_read', false)->count(); @endphp
        @if($unreadCount > 0)
        <span class="badge" style="background: #DC2626; color: white;">{{ $unreadCount }} Unread</span>
        @endif
    </div>
    <div class="card-body p-0">
        @forelse($notifications ?? [] as $notification)
        <div class="d-flex align-items-start p-3 {{ $notification->is_read ? '' : 'bg-light' }}" style="border-bottom: 1px solid var(--border);">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 40px; height: 40px;
                @if(($notification->type ?? '') === 'payment') background: var(--green-light); color: var(--green);
                @elseif(($notification->type ?? '') === 'academic') background: var(--primary-light); color: var(--primary);
                @elseif(($notification->type ?? '') === 'alert') background: #FEF2F2; color: #DC2626;
                @else background: #FEF3C7; color: #D97706; @endif">
                <i class="fas fa-{{ ($notification->type ?? '') === 'payment' ? 'credit-card' : (($notification->type ?? '') === 'academic' ? 'graduation-cap' : (($notification->type ?? '') === 'alert' ? 'exclamation-triangle' : 'bell')) }}"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong style="font-size: 13px;">{{ $notification->title ?? 'Notification' }}</strong>
                        @if(!$notification->is_read)
                            <span class="badge bg-danger ms-2" style="font-size: 8px; padding: 3px 6px;">NEW</span>
                        @endif
                    </div>
                    <small class="text-muted">{{ $notification->created_at ? $notification->created_at->diffForHumans() : '' }}</small>
                </div>
                <p class="text-muted mb-0 mt-1" style="font-size: 12.5px;">{{ $notification->message ?? '' }}</p>
            </div>
            @if(!$notification->is_read)
            <button class="btn btn-sm btn-outline-secondary ms-2" title="Mark as read" onclick="markRead({{ $notification->id }}, this)">
                <i class="fas fa-check"></i>
            </button>
            @endif
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-bell" style="font-size: 3rem; opacity: 0.3;"></i>
            <p class="mt-2 mb-0">No notifications.</p>
        </div>
        @endforelse
    </div>
</div>

@if(method_exists($notifications ?? collect(), 'links'))
<div class="d-flex justify-content-center mt-4">
    {{ $notifications->links() }}
</div>
@endif
@endsection

@section('scripts')
<script>
function markAllRead() {
    fetch('{{ url("lecturer/notifications/mark-all-read") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(() => location.reload());
}

function markRead(id, btn) {
    fetch('{{ url("lecturer/notifications") }}/' + id + '/read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(() => location.reload());
}
</script>
@endsection
