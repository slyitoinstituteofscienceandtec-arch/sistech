@extends('layouts.app')

@section('title', 'Inbox')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="margin: 0; font-weight: 700;"><i class="fas fa-inbox me-2" style="color: var(--primary);"></i>Inbox</h4>
        <small class="text-muted">{{ $newCount }} new enquiry(s)</small>
    </div>
</div>

<div class="card-sistech">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $enquiry)
                    <tr style="{{ $enquiry->status === 'new' ? 'font-weight: 600; background: var(--primary-light);' : '' }}">
                        <td>
                            @if($enquiry->status === 'new')
                            <i class="fas fa-envelope" style="color: var(--primary);"></i>
                            @elseif($enquiry->status === 'read')
                            <i class="fas fa-envelope-open" style="color: var(--text-muted);"></i>
                            @else
                            <i class="fas fa-reply" style="color: var(--green);"></i>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 13.5px;">{{ $enquiry->name }}</div>
                            <small class="text-muted">{{ $enquiry->email }}</small>
                        </td>
                        <td>{{ $enquiry->subject }}</td>
                        <td><small class="text-muted">{{ $enquiry->created_at->format('M d, Y') }}</small></td>
                        <td>
                            @if($enquiry->status === 'new')
                            <span class="badge-status badge-pending">New</span>
                            @elseif($enquiry->status === 'read')
                            <span class="badge-status badge-active">Read</span>
                            @else
                            <span class="badge-status" style="background: #E6F7ED; color: #00B050;">Replied</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.inbox.show', $enquiry) }}" class="btn btn-outline-primary btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="opacity: 0.3;"></i>
                            No enquiries yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($enquiries, 'links'))
    <div class="card-footer d-flex justify-content-center" style="background: var(--bg); border-top: 1px solid var(--border);">
        {{ $enquiries->links() }}
    </div>
    @endif
</div>
@endsection
