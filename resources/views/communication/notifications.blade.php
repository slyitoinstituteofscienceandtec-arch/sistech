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

<div class="row g-3">
    <div class="col-lg-8">
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
                    <form method="POST" action="{{ route('admin.communication.notifications.read', $notification->id) }}" class="ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Mark as read">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
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
    </div>

    <div class="col-lg-4">
        <div class="card-sistech">
            <div class="card-header">
                <i class="fas fa-filter me-2" style="color: var(--primary);"></i>Filter
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.communication.notifications') }}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Type</label>
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payment</option>
                            <option value="academic" {{ request('type') === 'academic' ? 'selected' : '' }}>Academic</option>
                            <option value="alert" {{ request('type') === 'alert' ? 'selected' : '' }}>Alert</option>
                            <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sistech w-100">
                        <i class="fas fa-filter me-1"></i> Apply Filter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function markAllRead() {
    fetch('{{ route("admin.communication.notifications.mark-all-read") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(() => location.reload());
}
</script>
@endsection
