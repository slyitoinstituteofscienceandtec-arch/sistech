@extends('layouts.app')
@section('title', 'Record Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Record Attendance</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Mark attendance for students in a course</p>
    </div>
    <a href="{{ url('lecturer/dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card-sistech">
            <div class="card-body">
                <label class="form-label fw-semibold">Select Course <span class="text-danger">*</span></label>
                <select id="courseSelect" class="form-select" required>
                    <option value="">Choose a course...</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-sistech">
            <div class="card-body">
                <label class="form-label fw-semibold">Attendance Date <span class="text-danger">*</span></label>
                <input type="date" id="attendanceDate" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>
    </div>
    <div class="col-md-3 d-flex align-items-end">
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
                        <th>Student Name</th>
                        <th>Student ID</th>
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
        <button type="button" id="submitAttendance" class="btn btn-sistech btn-lg">
            <i class="fas fa-save me-1"></i> Save Attendance
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('loadStudents')?.addEventListener('click', function() {
    const courseId = document.getElementById('courseSelect').value;
    if (!courseId) {
        alert('Please select a course first.');
        return;
    }

    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
    this.disabled = true;

    const url = '{{ url("lecturer/attendance/students/") }}/' + courseId;
    fetch(url)
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
                            <td>${item.name}</td>
                            <td><strong>${item.student_id}</strong></td>
                            <td>
                                <select class="form-select form-select-sm attendance-status" data-student-id="${item.id}" required>
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
    document.querySelectorAll('.attendance-status').forEach(select => {
        select.value = status;
    });
}

document.getElementById('submitAttendance')?.addEventListener('click', function() {
    const courseId = document.getElementById('courseSelect').value;
    const date = document.getElementById('attendanceDate').value;

    if (!courseId) {
        alert('Please select a course.');
        return;
    }

    const statuses = document.querySelectorAll('.attendance-status');
    if (statuses.length === 0) {
        alert('No students loaded.');
        return;
    }

    const records = [];
    statuses.forEach(select => {
        records.push({
            student_id: select.dataset.studentId,
            status: select.value
        });
    });

    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
    this.disabled = true;

    fetch('{{ url("lecturer/attendance/record") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            course_id: courseId,
            date: date,
            records: records
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Attendance recorded successfully!');
        } else {
            alert(data.message || 'Failed to save attendance.');
        }
    })
    .catch(() => alert('Failed to save attendance. Please try again.'))
    .finally(() => {
        document.getElementById('submitAttendance').innerHTML = '<i class="fas fa-save me-1"></i> Save Attendance';
        document.getElementById('submitAttendance').disabled = false;
    });
});
</script>
@endsection
