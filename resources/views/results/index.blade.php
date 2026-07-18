@extends('layouts.app')
@section('title', 'Results')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Results Management</h4>
        <p class="text-muted mb-0" style="font-size:13px;">View and manage student results</p>
    </div>
    <a href="{{ route('admin.results.enter') }}" class="btn btn-sistech">
        <i class="fas fa-plus me-1"></i> Enter Results
    </a>
</div>

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.results.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Course</label>
                <select name="course_id" class="form-select">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->code }} - {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Academic Year</label>
                <select name="academic_year_id" class="form-select">
                    <option value="">All Years</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sistech flex-grow-1">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.results.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-chart-bar me-2" style="color: var(--primary);"></i>Results</span>
        <span class="badge" style="background: var(--primary-light); color: var(--primary);">{{ $results->total() }} Records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th class="text-center">CA</th>
                        <th class="text-center">Exam</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Grade</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: var(--primary); color: white; font-size: 11px; font-weight: 600;">
                                    {{ strtoupper(substr($result->student->user->name ?? 'N', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 13px;">{{ $result->student->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $result->student->student_id ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: var(--primary-light); color: var(--primary);">
                                {{ $result->course->code ?? '' }}
                            </span>
                        </td>
                        <td class="text-center">{{ number_format($result->ca_score, 1) }}</td>
                        <td class="text-center">{{ number_format($result->exam_score, 1) }}</td>
                        <td class="text-center">
                            <strong style="color: var(--primary);">{{ number_format($result->total_score, 1) }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="fw-bold" style="font-size: 14px; color: {{ $result->total_score >= 70 ? 'var(--green)' : ($result->total_score >= 50 ? '#D97706' : '#DC2626') }};">
                                {{ $result->grade ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($result->status === 'published')
                                <span class="badge-status badge-active">Published</span>
                            @else
                                <span class="badge-status badge-pending">Draft</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                @if($result->status === 'draft')
                                <form method="POST" action="{{ route('admin.results.approve', $result->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm" title="Approve">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-chart-bar" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2 mb-0">No results found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($results, 'links'))
    <div class="card-footer d-flex justify-content-center" style="background: var(--bg); border-top: 1px solid var(--border);">
        {{ $results->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
</script>
@endsection
