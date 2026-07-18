@extends('layouts.app')
@section('title', 'Programmes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Programmes</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage academic programmes</p>
    </div>
    @if(auth()->user()->role !== 'staff')
    <a href="{{ route('admin.programmes.create') }}" class="btn btn-sistech">
        <i class="fas fa-plus me-1"></i> Add Programme
    </a>
    @endif
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.programmes.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Search</label>
                    <input type="text" name="search" class="form-control" style="font-size:13px;border-radius:8px;" placeholder="Name, code..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Department</label>
                    <select name="department_id" class="form-select" style="font-size:13px;border-radius:8px;">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-size:12px;font-weight:600;">Status</label>
                    <select name="status" class="form-select" style="font-size:13px;border-radius:8px;">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sistech w-100"><i class="fas fa-filter me-1"></i> Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-graduation-cap me-2" style="color:var(--primary);"></i>All Programmes <span class="text-muted" style="font-weight:400;">({{ $programmes->total() }})</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programmes as $programme)
                    <tr>
                        <td>
                            <a href="{{ route('admin.programmes.show', $programme) }}" style="color:var(--text);text-decoration:none;font-weight:500;">
                                {{ $programme->name }}
                            </a>
                        </td>
                        <td><span class="badge" style="background:var(--primary-light);color:var(--primary);">{{ $programme->code }}</span></td>
                        <td>{{ $programme->department->name ?? '-' }}</td>
                        <td>{{ $programme->level ?? '-' }}</td>
                        <td>{{ $programme->duration_months ? $programme->duration_months . ' months' : '-' }}</td>
                        <td>
                            <span class="badge-status badge-{{ $programme->is_active ? 'active' : 'inactive' }}">
                                {{ $programme->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm" style="color:var(--text-muted);" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.programmes.show', $programme) }}"><i class="fas fa-eye me-2"></i> View</a></li>
                                    @if(auth()->user()->role !== 'staff')
                                    <li><a class="dropdown-item" href="{{ route('admin.programmes.edit', $programme) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.programmes.destroy', $programme) }}" onsubmit="return confirm('Are you sure you want to delete this programme?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-graduation-cap fa-2x mb-2 d-block" style="color:var(--border);"></i>
                            No programmes found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($programmes, 'hasPages') && $programmes->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3" style="font-size:13px;">
    <span class="text-muted">Showing {{ $programmes->firstItem() }} to {{ $programmes->lastItem() }} of {{ $programmes->total() }} programmes</span>
    {{ $programmes->withQueryString()->links() }}
</div>
@endif
@endsection
