@extends('layouts.app')
@section('title', 'Course Registrations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Course Registrations</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Register students to courses for attendance and results</p>
    </div>
    <button class="btn btn-sistech" data-bs-toggle="modal" data-bs-target="#enrollModal">
        <i class="fas fa-plus me-1"></i> Register Student
    </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" style="border-radius:10px;font-size:13px;">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" style="border-radius:10px;font-size:13px;">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card-sistech mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.course-registrations.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:12px;">Course</label>
                <select name="course_id" class="form-select form-select-sm">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->code }} - {{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:12px;">Programme</label>
                <select name="programme_id" class="form-select form-select-sm">
                    <option value="">All Programmes</option>
                    @foreach($programmes as $prog)
                        <option value="{{ $prog->id }}" {{ request('programme_id') == $prog->id ? 'selected' : '' }}>{{ $prog->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:12px;">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="registered" {{ request('status') == 'registered' ? 'selected' : '' }}>Registered</option>
                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.course-registrations.index') }}" class="btn btn-outline-secondary btn-sm w-100">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card-sistech">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sistech mb-0">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Programme</th>
                        <th>Academic Year</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td>
                            <div class="fw-semibold" style="font-size:13px;">{{ $reg->student->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $reg->student->student_id ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge" style="background:var(--primary-light);color:var(--primary);">{{ $reg->course->code ?? '' }}</span>
                            <span style="font-size:12px;">{{ $reg->course->name ?? '' }}</span>
                        </td>
                        <td style="font-size:12px;">{{ $reg->course->programme->name ?? '-' }}</td>
                        <td style="font-size:12px;">{{ $reg->academicYear->name ?? '-' }}</td>
                        <td style="font-size:12px;">{{ $reg->semester->name ?? '-' }}</td>
                        <td>
                            <span class="badge-status badge-{{ $reg->status === 'registered' ? 'active' : 'inactive' }}">{{ ucfirst($reg->status) }}</span>
                        </td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('admin.course-registrations.destroy', $reg) }}" class="d-inline" onsubmit="return confirm('Remove this registration?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-user-graduate" style="font-size:3rem;opacity:0.3;"></i>
                            <p class="mt-2 mb-0">No course registrations found.</p>
                            <small>Click "Register Student" to enroll students in courses.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($registrations, 'links'))
    <div class="card-footer d-flex justify-content-center" style="background:var(--bg);border-top:1px solid var(--border);">
        {{ $registrations->links() }}
    </div>
    @endif
</div>

<div class="modal fade" id="enrollModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:12px;border:none;">
            <form method="POST" action="{{ route('admin.course-registrations.store') }}">
                @csrf
                <div class="modal-header" style="border-bottom:1px solid var(--border);">
                    <h6 class="modal-title fw-bold"><i class="fas fa-user-plus me-2" style="color:var(--green);"></i>Register Student to Course</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                        <select name="student_id" class="form-select" required>
                            <option value="">Select student...</option>
                            @foreach(\App\Models\Student::with('user')->where('status','active')->get() as $student)
                                <option value="{{ $student->id }}">{{ $student->student_id }} - {{ $student->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select" required>
                            <option value="">Select course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                            <select name="academic_year_id" class="form-select" required>
                                @foreach(\App\Models\AcademicYear::all() as $year)
                                    <option value="{{ $year->id }}" {{ $year->is_current ? 'selected' : '' }}>{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                            <select name="semester_id" class="form-select" required>
                                @foreach(\App\Models\Semester::where('is_current', true)->get() as $sem)
                                    <option value="{{ $sem->id }}">{{ $sem->name }}</option>
                                @endforeach
                                @if(\App\Models\Semester::where('is_current', true)->count() === 0)
                                    @foreach(\App\Models\Semester::all() as $sem)
                                        <option value="{{ $sem->id }}">{{ $sem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sistech"><i class="fas fa-check me-1"></i> Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
