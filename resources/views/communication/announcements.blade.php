@extends('layouts.app')
@section('title', 'Announcements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Announcements</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage institutional announcements</p>
    </div>
    <a href="{{ route('admin.communication.announcements.create') }}" class="btn btn-sistech">
        <i class="fas fa-plus me-1"></i> Create Announcement
    </a>
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
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary btn-sm" title="View"
                            data-id="{{ $announcement->id }}"
                            data-title="{{ $announcement->title }}"
                            data-content="{{ $announcement->content }}"
                            data-type="{{ $announcement->type ?? 'general' }}"
                            data-target="{{ $announcement->target ?? 'all' }}"
                            data-date="{{ $announcement->publish_date }}"
                            data-author="{{ $announcement->creator->name ?? 'Admin' }}"
                            onclick="viewAnnouncement(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-warning btn-sm" title="Edit"
                            data-id="{{ $announcement->id }}"
                            data-title="{{ $announcement->title }}"
                            data-content="{{ $announcement->content }}"
                            data-type="{{ $announcement->type ?? 'general' }}"
                            data-target="{{ $announcement->target ?? 'all' }}"
                            onclick="editAnnouncement(this)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.communication.announcements.destroy', $announcement->id) }}" class="d-inline" onsubmit="return confirm('Delete this announcement?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
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
                <div class="d-flex justify-content-between">
                    <small class="text-muted"><i class="fas fa-user me-1"></i> <span id="viewAuthor"></span></small>
                    <small class="text-muted"><i class="fas fa-bullseye me-1"></i> Target: <span id="viewTarget"></span></small>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border);">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Announcement Modal -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <form method="POST" id="editAnnouncementForm" action="">
                @csrf
                @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                    <h5 class="modal-title fw-bold">Edit Announcement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="edit_content" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                            <select name="type" id="edit_type" class="form-select" required>
                                <option value="general">General</option>
                                <option value="academic">Academic</option>
                                <option value="finance">Finance</option>
                                <option value="events">Events</option>
                                <option value="urgent">Urgent</option>
                                <option value="exam">Exam</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Target <span class="text-danger">*</span></label>
                            <select name="target" id="edit_target" class="form-select" required>
                                <option value="all">All</option>
                                <option value="students">Students</option>
                                <option value="lecturers">Lecturers</option>
                                <option value="staff">Staff</option>
                                <option value="parents">Parents</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border);">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sistech">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                </div>
            </form>
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
    var target = btn.getAttribute('data-target');
    var date = btn.getAttribute('data-date');
    var author = btn.getAttribute('data-author');

    document.getElementById('viewTitle').textContent = title;
    document.getElementById('viewContent').textContent = content;
    document.getElementById('viewDate').textContent = date ? new Date(date).toLocaleDateString('en-GB', {day:'numeric', month:'long', year:'numeric'}) : '';
    document.getElementById('viewAuthor').textContent = author;
    document.getElementById('viewTarget').textContent = target.charAt(0).toUpperCase() + target.slice(1);
    var typeEl = document.getElementById('viewType');
    typeEl.textContent = type.charAt(0).toUpperCase() + type.slice(1);
    var colors = {general:'var(--primary)',academic:'#D97706',finance:'var(--green)',emergency:'#DC2626',event:'#7C3AED',exam:'#7C3AED'};
    typeEl.style.background = colors[type] || 'var(--primary)';
    typeEl.style.color = '#fff';
    new bootstrap.Modal(document.getElementById('viewAnnouncementModal')).show();
}

function editAnnouncement(btn) {
    var id = btn.getAttribute('data-id');
    document.getElementById('editAnnouncementForm').action = '{{ url("admin/communication/announcements") }}/' + id;
    document.getElementById('edit_title').value = btn.getAttribute('data-title');
    document.getElementById('edit_content').value = btn.getAttribute('data-content');
    document.getElementById('edit_type').value = btn.getAttribute('data-type');
    document.getElementById('edit_target').value = btn.getAttribute('data-target');
    new bootstrap.Modal(document.getElementById('editAnnouncementModal')).show();
}
</script>
@endsection
