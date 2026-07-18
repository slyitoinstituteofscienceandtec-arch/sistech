@extends('layouts.app')
@section('title', 'Enter Results')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Enter Results</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Enter CA and exam scores for students</p>
    </div>
    <a href="{{ route('admin.results.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<form method="POST" action="{{ route('admin.results.store') }}" id="resultsForm">
    @csrf
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-sistech">
                <div class="card-body">
                    <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                    <select name="course_id" id="courseSelect" class="form-select" required>
                        <option value="">Choose course...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
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
                    <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                    <select name="academic_year_id" id="yearSelect" class="form-select" required>
                        <option value="">Choose year...</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-sistech">
                <div class="card-body">
                    <label class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                    <select name="semester_id" id="semesterSelect" class="form-select" required>
                        <option value="">Choose semester...</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                        @endforeach
                    </select>
                    @error('semester_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
                            <th>Student ID</th>
                            <th>Name</th>
                            <th style="width: 150px;" class="text-center">CA Score (30%)</th>
                            <th style="width: 150px;" class="text-center">Exam Score (70%)</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Grade</th>
                        </tr>
                    </thead>
                    <tbody id="studentsBody">
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Select course, year, semester and click "Load Students"
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
            <button type="submit" class="btn btn-sistech btn-lg">
                <i class="fas fa-save me-1"></i> Save Results
            </button>
        </div>
    </div>
</form>
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

    const studentsUrl = '{{ url("admin/results/students") }}/';
    fetch(studentsUrl + courseId)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('studentsBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">No students enrolled in this course.</td></tr>';
            } else {
                data.forEach((student, index) => {
                    tbody.innerHTML += `
                        <tr>
                            <td class="text-muted">${index + 1}</td>
                            <td><strong>${student.student_id}</strong></td>
                            <td>${student.user.name}</td>
                            <td>
                                <input type="hidden" name="results[${index}][student_id]" value="${student.id}">
                                <input type="number" name="results[${index}][ca_score]" class="form-control form-control-sm text-center"
                                    min="0" max="30" step="0.5"
                                    oninput="calculateTotal(${index})" required>
                            </td>
                            <td>
                                <input type="number" name="results[${index}][exam_score]" class="form-control form-control-sm text-center"
                                    min="0" max="70" step="0.5"
                                    oninput="calculateTotal(${index})" required>
                            </td>
                            <td class="text-center fw-bold" id="total_${index}">-</td>
                            <td class="text-center"><span id="grade_${index}" class="fw-bold">-</span></td>
                        </tr>
                    `;
                });
            }

            document.getElementById('studentCount').textContent = data.length + ' Students';
            document.getElementById('studentsCard').style.display = 'block';
        })
        .catch(() => alert('Failed to load students.'))
        .finally(() => {
            this.innerHTML = '<i class="fas fa-users me-1"></i> Load Students';
            this.disabled = false;
        });
});

function calculateTotal(index) {
    const ca = parseFloat(document.querySelector(`input[name="results[${index}][ca_score]"]`)?.value) || 0;
    const exam = parseFloat(document.querySelector(`input[name="results[${index}][exam_score]"]`)?.value) || 0;
    const total = ca + exam;

    document.getElementById(`total_${index}`).textContent = total > 0 ? total.toFixed(1) : '-';

    let grade = '-';
    let color = 'var(--text-muted)';
    if (total >= 80) { grade = 'A'; color = 'var(--green)'; }
    else if (total >= 70) { grade = 'B'; color = 'var(--green)'; }
    else if (total >= 60) { grade = 'C'; color = '#D97706'; }
    else if (total >= 50) { grade = 'D'; color = '#D97706'; }
    else if (total >= 40) { grade = 'E'; color = '#DC2626'; }
    else if (total > 0) { grade = 'F'; color = '#DC2626'; }

    const gradeEl = document.getElementById(`grade_${index}`);
    gradeEl.textContent = grade;
    gradeEl.style.color = color;
}
</script>
@endsection
