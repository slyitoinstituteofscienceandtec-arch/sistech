@extends('layouts.app')
@section('title', 'Academic Years')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Academic Years</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage academic years and sessions</p>
    </div>
    <button class="btn btn-sistech" data-bs-toggle="modal" data-bs-target="#createYearModal">
        <i class="fas fa-plus me-1"></i> Add Academic Year
    </button>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-calendar-alt me-2" style="color: var(--primary);"></i>All Academic Years</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $academicYears->count() }} Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Current</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($academicYears as $year)
                    <tr>
                        <td><strong>{{ $year->name }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($year->start_date)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($year->end_date)->format('M d, Y') }}</td>
                        <td>
                            @if(now()->between($year->start_date, $year->end_date))
                                <span class="badge-status badge-active">Active</span>
                            @else
                                <span class="badge-status badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($year->is_current)
                                <span class="badge" style="background: var(--green-light); color: var(--green);">
                                    <i class="fas fa-check me-1"></i>Current
                                </span>
                            @else
                                <span class="text-muted" style="font-size: 12px;">—</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <form method="POST" action="{{ route('admin.academic.years.set-current', $year->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm" title="Set as Current" {{ $year->is_current ? 'disabled' : '' }}>
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                                <button class="btn btn-outline-primary btn-sm" title="Edit"
                                    data-id="{{ $year->id }}"
                                    data-name="{{ $year->name }}"
                                    data-start="{{ \Carbon\Carbon::parse($year->start_date)->format('Y-m-d') }}"
                                    data-end="{{ \Carbon\Carbon::parse($year->end_date)->format('Y-m-d') }}"
                                    data-current="{{ $year->is_current ? '1' : '0' }}"
                                    onclick="editYear(this)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.academic.years.destroy', $year->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this academic year?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-alt" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No academic years found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createYearModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <form method="POST" action="{{ route('admin.academic.years.store') }}">
                @csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                    <h5 class="modal-title fw-bold">Add Academic Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Year Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. 2025/2026" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_current" value="1" id="isCurrent">
                            <label class="form-check-label fw-semibold" for="isCurrent">Set as Current Academic Year</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border);">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sistech">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editYearModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <form method="POST" id="editYearForm" action="">
                @csrf
                @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                    <h5 class="modal-title fw-bold">Edit Academic Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Year Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" id="edit_start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" id="edit_end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_current" value="1" id="edit_is_current">
                            <label class="form-check-label fw-semibold" for="edit_is_current">Set as Current Academic Year</label>
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
function editYear(btn) {
    var id = btn.getAttribute('data-id');
    document.getElementById('editYearForm').action = '{{ url("admin/academic/years") }}/' + id;
    document.getElementById('edit_name').value = btn.getAttribute('data-name');
    document.getElementById('edit_start_date').value = btn.getAttribute('data-start');
    document.getElementById('edit_end_date').value = btn.getAttribute('data-end');
    document.getElementById('edit_is_current').checked = btn.getAttribute('data-current') === '1';
    new bootstrap.Modal(document.getElementById('editYearModal')).show();
}
</script>
@endsection
