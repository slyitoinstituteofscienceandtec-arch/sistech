@extends('layouts.app')
@section('title', 'Semesters')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Semesters</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage semesters within academic years</p>
    </div>
    <button class="btn btn-sistech" data-bs-toggle="modal" data-bs-target="#createSemesterModal">
        <i class="fas fa-plus me-1"></i> Add Semester
    </button>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-calendar-week me-2" style="color: var(--primary);"></i>All Semesters</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $semesters->count() }} Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semesters as $semester)
                    <tr>
                        <td><strong>{{ $semester->name }}</strong></td>
                        <td>
                            <span class="badge" style="background: var(--primary-light); color: var(--primary);">
                                {{ $semester->academicYear->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($semester->start_date)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($semester->end_date)->format('M d, Y') }}</td>
                        <td>
                            @if($semester->is_current ?? false)
                                <span class="badge-status badge-active">Current</span>
                            @else
                                <span class="badge-status badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm" title="Edit"
                                    data-id="{{ $semester->id }}"
                                    data-academic-year-id="{{ $semester->academic_year_id }}"
                                    data-name="{{ $semester->name }}"
                                    data-start-date="{{ $semester->start_date?->format('Y-m-d') }}"
                                    data-end-date="{{ $semester->end_date?->format('Y-m-d') }}"
                                    data-is-current="{{ $semester->is_current ? '1' : '0' }}"
                                    onclick="editSemester(this)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.academic.semesters.destroy', $semester->id) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                            <i class="fas fa-calendar-week" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No semesters found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createSemesterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <form method="POST" action="{{ route('admin.academic.semesters.store') }}">
                @csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                    <h5 class="modal-title fw-bold">Add Semester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                        <select name="academic_year_id" class="form-select" required>
                            <option value="">Select Academic Year</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. First Semester" required>
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
                            <input class="form-check-input" type="checkbox" name="is_current" value="1" id="isCurrentSemester">
                            <label class="form-check-label fw-semibold" for="isCurrentSemester">Set as Current Semester</label>
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

<div class="modal fade" id="editSemesterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <form method="POST" id="editSemesterForm" action="">
                @csrf
                @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                    <h5 class="modal-title fw-bold">Edit Semester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                        <select name="academic_year_id" id="edit_academic_year_id" class="form-select" required>
                            <option value="">Select Academic Year</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Semester Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_sem_name" class="form-control" required>
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
                            <input class="form-check-input" type="checkbox" name="is_current" value="1" id="edit_is_current_sem">
                            <label class="form-check-label fw-semibold" for="edit_is_current_sem">Set as Current Semester</label>
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
function editSemester(btn) {
    var id = btn.getAttribute('data-id');
    document.getElementById('editSemesterForm').action = '{{ url("admin/academic/semesters") }}/' + id;
    document.getElementById('edit_academic_year_id').value = btn.getAttribute('data-academic-year-id');
    document.getElementById('edit_sem_name').value = btn.getAttribute('data-name');
    document.getElementById('edit_start_date').value = btn.getAttribute('data-start-date') || '';
    document.getElementById('edit_end_date').value = btn.getAttribute('data-end-date') || '';
    document.getElementById('edit_is_current_sem').checked = btn.getAttribute('data-is-current') === '1';
    new bootstrap.Modal(document.getElementById('editSemesterModal')).show();
}
</script>
@endsection
