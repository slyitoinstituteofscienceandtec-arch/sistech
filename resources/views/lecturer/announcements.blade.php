@extends('layouts.app')
@section('title', 'Announcements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Announcements</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Institutional announcements and updates</p>
    </div>
</div>

<div class="row g-3">
    @forelse($announcements ?? [] as $announcement)
    <div class="col-md-6 col-xl-4">
        <div class="card-sistech h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge" style="
                        @if($announcement->type === 'general') background: var(--primary-light); color: var(--primary);
                        @elseif($announcement->type === 'academic') background: #FEF3C7; color: #D97706;
                        @elseif($announcement->type === 'finance') background: var(--green-light); color: var(--green);
                        @elseif($announcement->type === 'emergency') background: #FEF2F2; color: #DC2626;
                        @else background: #EDE9FE; color: #7C3AED;
                        @endif
                        font-size: 10px; border-radius: 4px; padding: 4px 8px;">
                        {{ ucfirst($announcement->type ?? 'General') }}
                    </span>
                    <small class="text-muted">{{ $announcement->created_at ? $announcement->created_at->diffForHumans() : '' }}</small>
                </div>
                <h6 class="fw-bold mb-2">{{ $announcement->title }}</h6>
                <p class="text-muted mb-3" style="font-size: 13px;">{{ Str::limit($announcement->content, 120) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-user me-1"></i> {{ $announcement->creator->name ?? 'Admin' }}
                    </small>
                    <button class="btn btn-sm btn-outline-primary" title="View"
                        data-title="{{ $announcement->title }}"
                        data-content="{{ $announcement->content }}"
                        data-type="{{ $announcement->type ?? 'general' }}"
                        data-date="{{ $announcement->publish_date }}"
                        data-author="{{ $announcement->creator->name ?? 'Admin' }}"
                        onclick="viewAnnouncement(this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card-sistech">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-bullhorn" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mt-2 mb-0">No announcements found.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@if(method_exists($announcements ?? collect(), 'links'))
<div class="d-flex justify-content-center mt-4">
    {{ $announcements->links() }}
</div>
@endif

<!-- View Announcement Modal -->
<div class="modal fade" id="viewAnnouncementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                <h5 class="modal-title fw-bold">Announcement Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <span class="badge" id="viewType" style="font-size: 11px; border-radius: 4px; padding: 4px 10px;"></span>
                    <small class="text-muted ms-2" id="viewDate"></small>
                </div>
                <h5 class="fw-bold" id="viewTitle"></h5>
                <hr>
                <p id="viewContent" style="font-size: 14px; line-height: 1.7; white-space: pre-wrap;"></p>
                <hr>
                <small class="text-muted"><i class="fas fa-user me-1"></i> <span id="viewAuthor"></span></small>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border);">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewAnnouncement(btn) {
    var title = btn.getAttribute('data-title');
    var content = btn.getAttribute('data-content');
    var type = btn.getAttribute('data-type');
    var date = btn.getAttribute('data-date');
    var author = btn.getAttribute('data-author');

    document.getElementById('viewTitle').textContent = title;
    document.getElementById('viewContent').textContent = content;
    document.getElementById('viewDate').textContent = date ? new Date(date).toLocaleDateString('en-GB', {day:'numeric', month:'long', year:'numeric'}) : '';
    document.getElementById('viewAuthor').textContent = author;

    var typeEl = document.getElementById('viewType');
    typeEl.textContent = type.charAt(0).toUpperCase() + type.slice(1);
    var colors = {general:'var(--primary)',academic:'#D97706',finance:'var(--green)',emergency:'#DC2626',event:'#7C3AED',exam:'#7C3AED'};
    typeEl.style.background = colors[type] || 'var(--primary)';
    typeEl.style.color = '#fff';

    new bootstrap.Modal(document.getElementById('viewAnnouncementModal')).show();
}
</script>
@endsection
