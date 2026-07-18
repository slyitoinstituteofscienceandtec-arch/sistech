@extends('layouts.app')
@section('title', 'Staff')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--primary); font-weight: 700;">Staff Management</h2>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-sistech">
            <i class="bi bi-plus-lg me-1"></i> Add Staff Member
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4 shadow-sm" style="border-left: 4px solid var(--primary);">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.staff.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, or staff ID..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Position</label>
                    <select name="position" class="form-select">
                        <option value="">All Positions</option>
                        @foreach(['lecturer','hod','registrar','accountant','admin','librarian','it_support','security','cleaner','other'] as $pos)
                            <option value="{{ $pos }}" {{ request('position') === $pos ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $pos)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-sistech flex-grow-1">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: var(--primary); color: #fff;">
                        <tr>
                            <th class="ps-3">Staff ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Employment Type</th>
                            <th>Status</th>
                            <th class="text-center pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $member)
                            <tr>
                                <td class="ps-3 fw-semibold" style="color: var(--primary);">{{ $member->staff_id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px; background: var(--primary); color: #fff; font-size: 0.85rem;">
                                            {{ strtoupper(substr($member->user->name ?? '', 0, 2)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $member->user->name ?? '' }}</span>
                                    </div>
                                </td>
                                <td>{{ $member->user->email ?? '' }}</td>
                                <td>{{ $member->department->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge" style="background: var(--primary); color: #fff;">
                                        {{ ucfirst(str_replace('_', ' ', $member->position)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ ucfirst(str_replace('_', ' ', $member->employment_type)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($member->status === 'active')
                                        <span class="badge" style="background: var(--green); color: #fff;">Active</span>
                                    @elseif($member->status === 'inactive')
                                        <span class="badge bg-secondary">Inactive</span>
                                    @else
                                        <span class="badge bg-danger">Suspended</span>
                                    @endif
                                </td>
                                <td class="text-center pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.staff.show', $member->id) }}" class="btn btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.staff.edit', $member->id) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.staff.destroy', $member->id) }}" onsubmit="return confirm('Are you sure you want to delete this staff member?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-people" style="font-size: 3rem; color: var(--primary); opacity: 0.4;"></i>
                                    <p class="mt-2 mb-0">No staff members found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($staff, 'links'))
            <div class="card-footer d-flex justify-content-center" style="background: #f8f9fa;">
                {{ $staff->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
