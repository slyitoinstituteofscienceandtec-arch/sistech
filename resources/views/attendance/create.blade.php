@extends('layouts.app')
@section('title', 'Record Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Record Attendance</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Mark attendance for students in a course</p>
    </div>
    <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<form method="POST" action="{{ route('admin.attendance.record') }}" id="attendanceForm">
    @csrf
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-sistech">
                <div class="card-body">
                    <label class="form-label fw-semibold">Select Course <span class="text-danger">*</span></label>
                    <select name="course_id" id="courseSelect" class="form-select" required>
                        <option value="">Choose a course...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" data-course="{{ $course->id }}">
                                {{ $course->code }} - {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-sistech">
                <div class="card-body">
                    <label class="form-label fw-semibold">Attendance Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="attendanceDate" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-sistech">
                <div class="card-body">
                    <label class="form-label fw-semibold">Method</label>
                    <select name="method" class="form-select">
                        <option value="manual">Manual</option>
                        <option value="qr">QR Code</option>
                        <option value="biometric">Biometric</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" id="loadStudents" class="btn btn-sistech w-100">
                <i class="fas fa-users me-1"></i> Load Students
            </button>
        </div>
    </div>

    <div class="card-sistech" id="studentsCard" style="display: none;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-graduate me-2" style="color: var(--primary);"></i>Students</span>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-success" onclick="markAll('present')">
                    <i class="fas fa-check me-1"></i> All Present
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="markAll('absent')">
                    <i class="fas fa-times me-1"></i> All Absent
                </button>
                <span class="badge" style="background: var(--primary-light); color: var(--primary);" id="studentCount">0 Students</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sistech mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th style="width: 200px;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="studentsBody">
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Select a course and click "Load Students" to begin
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end" style="border-top: 1px solid var(--border);">
            <button type="submit" class="btn btn-sistech btn-lg">
                <i class="fas fa-save me-1"></i> Save Attendance
            </button>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.getElementById('loadStudents')?.addEventListener('click', function() {
    const courseId = document.getElementById('courseSelect').value;
    const date = document.getElementById('attendanceDate').value;

    if (!courseId) {
        alert('Please select a course first.');
        return;
    }

    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
    this.disabled = true;

        fetch('{{ route("admin.attendance.students", "COURSE_ID") }}'.replace('COURSE_ID', courseId))
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('studentsBody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">No students enrolled in this course.</td></tr>';
                } else {
                    data.forEach((item, index) => {
                        tbody.innerHTML += `
                            <tr>
                                <td class="text-muted">${index + 1}</td>
                                <td><strong>${item.student_id}</strong></td>
                                <td>${item.user.name}</td>
                                <td>
                                    <input type="hidden" name="attendance[${index}][student_id]" value="${item.id}">
                                    <select name="attendance[${index}][status]" class="form-select form-select-sm" required>
                                        <option value="present">Present</option>
                                        <option value="absent">Absent</option>
                                        <option value="late">Late</option>
                                        <option value="excused">Excused</option>
                                    </select>
                                </td>
                            </tr>
                        `;
                    });
            }

            document.getElementById('studentCount').textContent = data.length + ' Students';
            document.getElementById('studentsCard').style.display = 'block';
        })
        .catch(() => alert('Failed to load students. Please try again.'))
        .finally(() => {
            document.getElementById('loadStudents').innerHTML = '<i class="fas fa-users me-1"></i> Load Students';
            document.getElementById('loadStudents').disabled = false;
        });
});

function markAll(status) {
    document.querySelectorAll('#studentsBody select').forEach(select => {
        select.value = status;
    });
}
</script>
@endsection
