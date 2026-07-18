@extends('layouts.app')
@section('title', 'Student Transcript')

@section('styles')
<style>
    @media print {
        .sidebar, .topbar, .no-print { display: none !important; }
        .main-content { margin-left: 0 !important; }
        .page-content { padding: 0 !important; }
        .card-sistech { border: none !important; box-shadow: none !important; }
        body { background: white !important; }
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <h4 class="fw-bold mb-1">Academic Transcript</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Student academic transcript and GPA</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.results.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <button onclick="window.print()" class="btn btn-sistech">
            <i class="fas fa-print me-1"></i> Print Transcript
        </button>
    </div>
</div>

<div class="card-sistech" style="max-width: 900px; margin: 0 auto;">
    <div class="card-body">
        <div class="text-center mb-4" style="border-bottom: 3px double var(--primary); padding-bottom: 20px;">
            <h3 class="fw-bold" style="color: var(--primary); margin-bottom: 4px;">SISTECH COLLEGE</h3>
            <p class="text-muted mb-1" style="font-size: 13px;">"Connecting People to Technology"</p>
            <p class="text-muted mb-3" style="font-size: 12px;">Student Academic Transcript</p>
            <div class="row text-start mt-3">
                <div class="col-md-6">
                    <p class="mb-1" style="font-size: 13px;"><strong>Student Name:</strong> {{ $student->user->name ?? 'N/A' }}</p>
                    <p class="mb-1" style="font-size: 13px;"><strong>Student ID:</strong> {{ $student->student_id ?? 'N/A' }}</p>
                    <p class="mb-1" style="font-size: 13px;"><strong>Programme:</strong> {{ $student->programme->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1" style="font-size: 13px;"><strong>Department:</strong> {{ $student->programme->department->name ?? 'N/A' }}</p>
                    <p class="mb-1" style="font-size: 13px;"><strong>Date of Admission:</strong> {{ $student->created_at ? $student->created_at->format('M d, Y') : 'N/A' }}</p>
                    <p class="mb-1" style="font-size: 13px;"><strong>Status:</strong>
                        <span class="badge-status badge-{{ $student->status === 'active' ? 'active' : 'inactive' }}">{{ ucfirst($student->status ?? 'N/A') }}</span>
                    </p>
                </div>
            </div>
        </div>

        @php $cumulativeGpa = 0; $totalCredits = 0; @endphp
        @forelse($groupedResults ?? [] as $semesterName => $semesterResults)
        <div class="mb-4">
            <h5 class="fw-bold mb-3" style="color: var(--primary); font-size: 15px;">
                <i class="fas fa-calendar-alt me-1"></i> {{ $semesterName }}
            </h5>
            <div class="table-responsive">
                <table class="table table-sistech mb-2">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th class="text-center">CA</th>
                            <th class="text-center">Exam</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Credits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $semesterTotal = 0; $semesterCredits = 0; $count = 0; @endphp
                        @foreach($semesterResults as $result)
                        <tr>
                            <td><strong>{{ $result->course->code ?? '-' }}</strong></td>
                            <td>{{ $result->course->name ?? '-' }}</td>
                            <td class="text-center">{{ number_format($result->ca_score, 1) }}</td>
                            <td class="text-center">{{ number_format($result->exam_score, 1) }}</td>
                            <td class="text-center"><strong>{{ number_format($result->total_score, 1) }}</strong></td>
                            <td class="text-center">
                                <span class="fw-bold" style="color: {{ ($result->total_score ?? 0) >= 70 ? 'var(--green)' : (($result->total_score ?? 0) >= 50 ? '#D97706' : '#DC2626') }};">
                                    {{ $result->grade ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">{{ $result->credit_unit ?? 3 }}</td>
                        </tr>
                        @php
                            $semesterTotal += $result->total_score ?? 0;
                            $semesterCredits += $result->credit_unit ?? 3;
                            $count++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($count > 0)
            <div class="text-end">
                <small class="text-muted">
                    Semester Average: <strong>{{ number_format($semesterTotal / $count, 1) }}</strong> |
                    Credits: {{ $semesterCredits }}
                </small>
            </div>
            @endif
        </div>
        @php
            $totalCredits += $semesterCredits;
        @endphp
        @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-file-alt" style="font-size: 3rem; opacity: 0.3;"></i>
            <p class="mt-2 mb-0">No results available for this student.</p>
        </div>
        @endforelse

        @if(!empty($groupedResults) && count($groupedResults) > 0)
        <div style="border-top: 3px double var(--primary); padding-top: 20px; margin-top: 20px;">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Summary</h6>
                    <p class="mb-1" style="font-size: 13px;"><strong>Total Courses:</strong> {{ $totalCourses }}</p>
                    <p class="mb-1" style="font-size: 13px;"><strong>Total Credits:</strong> {{ $totalCredits }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-inline-block p-3" style="background: var(--primary-light); border-radius: 10px;">
                        <div style="font-size: 12px; color: var(--text-muted);">Cumulative GPA (CGPA)</div>
                        <div style="font-size: 32px; font-weight: 700; color: var(--primary);">
                            {{ number_format($cgpa ?? 0, 2) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-center">
                <small class="text-muted">
                    <i class="fas fa-stamp me-1"></i>
                    This transcript is issued by SISTECH College Management System on {{ now()->format('F d, Y') }}
                </small>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
