@extends('layouts.app')
@section('title', 'My Results')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">My Results</h4>
        <p class="text-muted mb-0" style="font-size:13px;">View your academic results and transcript</p>
    </div>
    <span class="badge" style="background: var(--primary-light); color: var(--primary); padding: 8px 14px; border-radius: 8px; font-size: 12px;">
        <i class="fas fa-id-card me-1"></i> {{ $student->student_id ?? 'N/A' }}
    </span>
</div>

@php
    $gpa = $student->results->count() > 0 ? round($student->results->avg('grade_point'), 2) : 0;
    $totalCredits = $student->results->sum('course.credit_units') ?? 0;
@endphp

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $student->results->count() ?? 0 }}</div>
                    <div class="stat-label">Total Results</div>
                </div>
                <div class="stat-icon" style="background: var(--primary-light); color: var(--primary);">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="color: #D97706;">{{ $gpa }}</div>
                    <div class="stat-label">Current GPA</div>
                </div>
                <div class="stat-icon" style="background: #FEF3C7; color: #D97706;">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value" style="color: var(--green);">{{ $totalCredits }}</div>
                    <div class="stat-label">Total Credits</div>
                </div>
                <div class="stat-icon" style="background: var(--green-light); color: var(--green);">
                    <i class="fas fa-award"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-chart-bar me-2" style="color: var(--green);"></i>Academic Results</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th class="text-center">CA Score</th>
                        <th class="text-center">Exam Score</th>
                        <th class="text-center">Total Score</th>
                        <th class="text-center">Grade</th>
                        <th class="text-center">Credit Units</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->results ?? [] as $result)
                    @php
                        $total = $result->total_score ?? 0;
                        $color = $total >= 70 ? 'var(--green)' : ($total >= 50 ? '#D97706' : '#DC2626');
                    @endphp
                    <tr>
                        <td><strong style="color: var(--primary);">{{ $result->course->code ?? '-' }}</strong></td>
                        <td>{{ $result->course->name ?? '-' }}</td>
                        <td class="text-center">{{ number_format($result->ca_score, 1) }}</td>
                        <td class="text-center">{{ number_format($result->exam_score, 1) }}</td>
                        <td class="text-center fw-bold" style="color: {{ $color }};">{{ number_format($total, 1) }}</td>
                        <td class="text-center">
                            <span class="fw-bold" style="color: {{ $color }};">{{ $result->grade ?? '-' }}</span>
                        </td>
                        <td class="text-center">{{ $result->course->credit_units ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-chart-bar fa-2x mb-2 d-block" style="opacity:0.3;"></i>
                            No results available yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
