@extends('layouts.app')

@section('title', 'Enquiry Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="margin: 0; font-weight: 700;"><i class="fas fa-envelope me-2" style="color: var(--primary);"></i>Enquiry Details</h4>
        <small class="text-muted">{{ $enquiry->subject }}</small>
    </div>
    <a href="{{ route('admin.inbox.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Inbox
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-sistech mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user me-2"></i>{{ $enquiry->name }}</span>
                    <span class="text-muted" style="font-size: 13px;">{{ $enquiry->created_at->format('F d, Y \a\t h:i A') }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Email:</small> <span style="font-size: 13.5px;">{{ $enquiry->email }}</span>
                </div>
                <hr style="border-color: var(--border);">
                <div style="font-size: 14px; line-height: 1.7; white-space: pre-wrap;">{{ $enquiry->message }}</div>
            </div>
        </div>

        @if($enquiry->admin_reply)
        <div class="card-sistech mb-4" style="border-left: 4px solid var(--green);">
            <div class="card-header" style="background: var(--green-light);">
                <i class="fas fa-reply me-2" style="color: var(--green);"></i>
                <span>Your Reply</span>
                <span class="ms-2 text-muted" style="font-size: 12px;">{{ $enquiry->replied_at?->format('M d, Y h:i A') }}</span>
            </div>
            <div class="card-body">
                <div style="font-size: 14px; line-height: 1.7; white-space: pre-wrap;">{{ $enquiry->admin_reply }}</div>
            </div>
        </div>
        @endif

        @if($enquiry->status !== 'replied')
        <div class="card-sistech">
            <div class="card-header">
                <i class="fas fa-reply me-2" style="color: var(--primary);"></i> Reply
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.inbox.reply', $enquiry) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="admin_reply" class="form-control" rows="5" placeholder="Write your reply..." required style="border-radius: 8px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sistech">
                        <i class="fas fa-paper-plane me-1"></i> Send Reply
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card-sistech mb-4">
            <div class="card-header"><i class="fas fa-info-circle me-2"></i> Details</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                    <span class="text-muted">Status</span>
                    @if($enquiry->status === 'new')
                    <span class="badge-status badge-pending">New</span>
                    @elseif($enquiry->status === 'read')
                    <span class="badge-status badge-active">Read</span>
                    @else
                    <span class="badge-status" style="background: #E6F7ED; color: #00B050;">Replied</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                    <span class="text-muted">Received</span>
                    <span>{{ $enquiry->created_at->format('M d, Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size: 13px;">
                    <span class="text-muted">Replied By</span>
                    <span>{{ $enquiry->repliedBy->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="card-sistech">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.inbox.destroy', $enquiry) }}" onsubmit="return confirm('Delete this enquiry permanently?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-trash me-1"></i> Delete Enquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
