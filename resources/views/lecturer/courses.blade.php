@extends('layouts.app')
@section('title', 'My Courses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Courses</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Courses assigned to you</p>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-book me-2" style="color: var(--primary);"></i>All Courses <span class="text-muted" style="font-weight:400;">({{ $courses->count() }})</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Course Name</th>
                        <th>Department</th>
                        <th>Programme</th>
                        <th class="text-center">Credit Units</th>
                        <th class="text-center">Registered Students</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td><strong style="color: var(--primary);">{{ $course->code }}</strong></td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->department->name ?? '-' }}</td>
                        <td>{{ $course->programme->name ?? '-' }}</td>
                        <td class="text-center">{{ $course->credit_units ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge" style="background: var(--primary-light); color: var(--primary);">
                                {{ $course->registrations->count() }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary" onclick="toggleStudents({{ $course->id }})" title="View Students">
                                <i class="fas fa-users"></i>
                            </button>
                        </td>
                    </tr>
                    <tr id="students-{{ $course->id }}" style="display: none;">
                        <td colspan="7" style="padding: 0;">
                            <div style="background: var(--bg); padding: 12px 20px;">
                                <strong style="font-size: 12px; color: var(--text-muted);">ENROLLED STUDENTS</strong>
                                <table class="table table-sm mb-0 mt-2">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($course->registrations as $reg)
                                        <tr>
                                            <td><strong>{{ $reg->student->student_id ?? '-' }}</strong></td>
                                            <td>{{ $reg->student->user->name ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No students registered.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-book fa-2x mb-2 d-block" style="color: var(--border);"></i>
                            No courses assigned to you.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleStudents(courseId) {
    const row = document.getElementById('students-' + courseId);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endsection
