@extends('layouts.app')
@section('title', 'Departments')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Departments</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage academic departments</p>
    </div>
    <a href="{{ route('admin.departments.create') }}" class="btn btn-sistech">
        <i class="fas fa-plus me-1"></i> Add Department
    </a>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-building me-2" style="color:var(--primary);"></i>All Departments <span class="text-muted" style="font-weight:400;">({{ $departments->count() }})</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>HOD</th>
                        <th>Programmes</th>
                        <th>Courses</th>
                        <th>Students</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                    <tr>
                        <td>
                            <a href="{{ route('admin.departments.show', $department) }}" style="color:var(--text);text-decoration:none;font-weight:500;">
                                {{ $department->name }}
                            </a>
                        </td>
                        <td><span class="badge" style="background:var(--primary-light);color:var(--primary);">{{ $department->code }}</span></td>
                        <td>{{ $department->head->name ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $department->programmes_count ?? $department->programmes->count() }}</span></td>
                        <td><span class="badge bg-light text-dark border">{{ $department->courses_count ?? $department->courses->count() }}</span></td>
                        <td><span class="badge bg-light text-dark border">{{ $department->students_count ?? 0 }}</span></td>
                        <td>
                            <span class="badge-status badge-{{ $department->is_active ? 'active' : 'inactive' }}">
                                {{ $department->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-sm" style="color:var(--text-muted);" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.departments.show', $department) }}"><i class="fas fa-eye me-2"></i> View</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.departments.edit', $department) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.departments.destroy', $department) }}" onsubmit="return confirm('Are you sure you want to delete this department?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-building fa-2x mb-2 d-block" style="color:var(--border);"></i>
                            No departments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(method_exists($departments, 'hasPages') && $departments->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3" style="font-size:13px;">
    <span class="text-muted">Showing {{ $departments->firstItem() }} to {{ $departments->lastItem() }} of {{ $departments->total() }} departments</span>
    {{ $departments->withQueryString()->links() }}
</div>
@endif
@endsection
