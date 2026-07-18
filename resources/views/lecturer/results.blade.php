@extends('layouts.app')
@section('title', 'Enter Results')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Enter Results</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Enter CA and exam scores for students</p>
    </div>
    <a href="{{ url('lecturer/dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card-sistech">
            <div class="card-body">
                <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                <select id="courseSelect" class="form-select" required>
                    <option value="">Choose course...</option>
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
                <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                <select id="yearSelect" class="form-select" required>
                    <option value="">Choose year...</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-sistech">
            <div class="card-body">
                <label class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                <select id="semesterSelect" class="form-select" required>
                    <option value="">Choose semester...</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                    @endforeach
                </select>
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
        <span><i class="fas fa-user-graduate me-2" style="color: var(--primary);"></i>Student Scores</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);" id="studentCount">0 Students</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th style="width: 150px;" class="text-center">CA Score (30%)</th>
                        <th style="width: 150px;" class="text-center">Exam Score (70%)</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody id="studentsBody">
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Select course, academic year, semester and click "Load Students"
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between" style="border-top: 1px solid var(--border);">
        <small class="text-muted d-flex align-items-center">
            <i class="fas fa-info-circle me-1"></i> CA is out of 30, Exam is out of 70. Total = CA + Exam.
        </small>
        <button type="button" id="submitResults" class="btn btn-sistech btn-lg">
            <i class="fas fa-save me-1"></i> Save Results
        </button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('loadStudents')?.addEventListener('click', function() {
    const courseId = document.getElementById('courseSelect').value;
    const yearId = document.getElementById('yearSelect').value;
    const semesterId = document.getElementById('semesterSelect').value;

    if (!courseId || !yearId || !semesterId) {
        alert('Please select course, academic year, and semester first.');
        return;
    }

    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Loading...';
    this.disabled = true;

    const url = '{{ url("lecturer/results/students/") }}/' + courseId;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('studentsBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No students enrolled in this course.</td></tr>';
            } else {
                data.forEach((student, index) => {
                    tbody.innerHTML += `
                        <tr>
                            <td class="text-muted">${index + 1}</td>
                            <td>${student.name}</td>
                            <td><strong>${student.student_id}</strong></td>
                            <td>
                                <input type="number" class="form-control form-control-sm text-center ca-score"
                                    data-index="${index}" data-student-id="${student.id}" min="0" max="30" step="0.5"
                                    oninput="calculateTotal(${index})" required>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm text-center exam-score"
                                    data-index="${index}" min="0" max="70" step="0.5"
                                    oninput="calculateTotal(${index})" required>
                            </td>
                            <td class="text-center fw-bold" id="total_${index}">-</td>
                        </tr>
                    `;
                });
            }

            document.getElementById('studentCount').textContent = data.length + ' Students';
            document.getElementById('studentsCard').style.display = 'block';
        })
        .catch(() => alert('Failed to load students.'))
        .finally(() => {
            document.getElementById('loadStudents').innerHTML = '<i class="fas fa-users me-1"></i> Load Students';
            document.getElementById('loadStudents').disabled = false;
        });
});

function calculateTotal(index) {
    const ca = parseFloat(document.querySelector(`input.ca-score[data-index="${index}"]`)?.value) || 0;
    const exam = parseFloat(document.querySelector(`input.exam-score[data-index="${index}"]`)?.value) || 0;
    const total = ca + exam;
    document.getElementById(`total_${index}`).textContent = total > 0 ? total.toFixed(1) : '-';
}

document.getElementById('submitResults')?.addEventListener('click', function() {
    const courseId = document.getElementById('courseSelect').value;
    const yearId = document.getElementById('yearSelect').value;
    const semesterId = document.getElementById('semesterSelect').value;

    if (!courseId || !yearId || !semesterId) {
        alert('Please select course, academic year, and semester.');
        return;
    }

    const caInputs = document.querySelectorAll('.ca-score');
    if (caInputs.length === 0) {
        alert('No students loaded.');
        return;
    }

    const results = [];
    caInputs.forEach(input => {
        const idx = input.dataset.index;
        const examInput = document.querySelector(`input.exam-score[data-index="${idx}"]`);
        results.push({
            student_id: input.dataset.studentId,
            ca_score: parseFloat(input.value) || 0,
            exam_score: parseFloat(examInput?.value) || 0
        });
    });

    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
    this.disabled = true;

    fetch('{{ url("lecturer/results/store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            course_id: courseId,
            academic_year_id: yearId,
            semester_id: semesterId,
            results: results
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Results saved successfully!');
        } else {
            alert(data.message || 'Failed to save results.');
        }
    })
    .catch(() => alert('Failed to save results. Please try again.'))
    .finally(() => {
        document.getElementById('submitResults').innerHTML = '<i class="fas fa-save me-1"></i> Save Results';
        document.getElementById('submitResults').disabled = false;
    });
});
</script>
@endsection
