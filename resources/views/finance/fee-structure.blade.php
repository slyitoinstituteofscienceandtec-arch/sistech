@extends('layouts.app')
@section('title', 'Fee Structure')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Fee Structure</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage fee structures for programmes</p>
    </div>
    <button class="btn btn-sistech" data-bs-toggle="modal" data-bs-target="#createFeeModal">
        <i class="fas fa-plus me-1"></i> Add Fee Structure
    </button>
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.finance.fee-structure') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Academic Year</label>
                <select name="academic_year_id" class="form-select">
                    <option value="">All Years</option>
                    @foreach($academicYears ?? [] as $year)
                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Programme</label>
                <select name="programme_id" class="form-select">
                    <option value="">All Programmes</option>
                    @foreach($programmes ?? [] as $programme)
                        <option value="{{ $programme->id }}" {{ request('programme_id') == $programme->id ? 'selected' : '' }}>
                            {{ $programme->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-sistech flex-grow-1">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.finance.fee-structure') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-table me-2" style="color: var(--primary);"></i>Fee Structures</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $feeStructures->count() }} Total</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Programme</th>
                        <th>Academic Year</th>
                        <th class="text-end">Amount</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feeStructures as $fee)
                    <tr>
                        <td><strong>{{ $fee->programme->name ?? 'N/A' }}</strong></td>
                        <td>
                            <span class="badge" style="background: var(--primary-light); color: var(--primary);">
                                {{ $fee->academicYear->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="text-end"><strong>SLE {{ number_format($fee->amount, 2) }}</strong></td>
                        <td>{{ Str::limit($fee->description ?? '-', 50) }}</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm" title="Edit"
                                    data-id="{{ $fee->id }}"
                                    data-programme="{{ $fee->programme_id }}"
                                    data-year="{{ $fee->academic_year_id }}"
                                    data-amount="{{ $fee->amount }}"
                                    data-description="{{ $fee->description ?? '' }}"
                                    onclick="editFee(this)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.finance.fee-structure.destroy', $fee->id) }}" class="d-inline" onsubmit="return confirm('Delete this fee structure?')">
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-table" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No fee structures found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createFeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <form method="POST" action="{{ route('admin.finance.fee-structure.store') }}">
                @csrf
                <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                    <h5 class="modal-title fw-bold">Add Fee Structure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Programme <span class="text-danger">*</span></label>
                        <select name="programme_id" class="form-select" required>
                            <option value="">Select Programme</option>
                            @foreach($programmes ?? [] as $programme)
                                <option value="{{ $programme->id }}">{{ $programme->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                        <select name="academic_year_id" class="form-select" required>
                            <option value="">Select Academic Year</option>
                            @foreach($academicYears ?? [] as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount (SLE) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: var(--bg);">SLE</span>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="e.g. Tuition fees for 2026/2027 academic year"></textarea>
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

<div class="modal fade" id="editFeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <form method="POST" id="editFeeForm" action="">
                @csrf
                @method('PUT')
                <div class="modal-header" style="border-bottom: 1px solid var(--border);">
                    <h5 class="modal-title fw-bold">Edit Fee Structure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Programme <span class="text-danger">*</span></label>
                        <select name="programme_id" id="edit_programme_id" class="form-select" required>
                            <option value="">Select Programme</option>
                            @foreach($programmes ?? [] as $programme)
                                <option value="{{ $programme->id }}">{{ $programme->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                        <select name="academic_year_id" id="edit_academic_year_id" class="form-select" required>
                            <option value="">Select Academic Year</option>
                            @foreach($academicYears ?? [] as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Amount (SLE) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: var(--bg);">SLE</span>
                            <input type="number" name="amount" id="edit_amount" class="form-control" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="2"></textarea>
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
function editFee(btn) {
    document.getElementById('editFeeForm').action = '{{ url("admin/finance/fee-structure") }}/' + btn.getAttribute('data-id');
    document.getElementById('edit_programme_id').value = btn.getAttribute('data-programme');
    document.getElementById('edit_academic_year_id').value = btn.getAttribute('data-year');
    document.getElementById('edit_amount').value = btn.getAttribute('data-amount');
    document.getElementById('edit_description').value = btn.getAttribute('data-description');
    new bootstrap.Modal(document.getElementById('editFeeModal')).show();
}
</script>
@endsection
