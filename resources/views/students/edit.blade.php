@extends('layouts.app')
@section('title', 'Edit Student')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Student</h4>
        <p class="text-muted mb-0" style="font-size:13px;">{{ $student->student_id }} - {{ $student->user->name ?? '' }}</p>
    </div>
    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary" style="border-radius:8px;">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<form method="POST" action="{{ route('admin.students.update', $student) }}">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card-sistech">
                <div class="card-header">
                    <i class="fas fa-user me-2" style="color:var(--primary);"></i> Personal Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('name', $student->user->name ?? '') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('phone', $student->user->phone ?? '') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $student->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $student->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $student->gender) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('date_of_birth', $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d') : '') }}">
                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                @foreach(['active','inactive','graduated','suspended','transferred','deferred'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $student->status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" style="font-size:13px;border-radius:8px;" rows="2">{{ old('address', $student->address ?? '') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Guardian Name</label>
                            <input type="text" name="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('guardian_name', $student->guardian_name ?? '') }}">
                            @error('guardian_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Guardian Phone</label>
                            <input type="text" name="guardian_phone" class="form-control @error('guardian_phone') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('guardian_phone', $student->guardian_phone ?? '') }}">
                            @error('guardian_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Guardian Email</label>
                            <input type="email" name="guardian_email" class="form-control @error('guardian_email') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('guardian_email', $student->guardian_email ?? '') }}">
                            @error('guardian_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-sistech mb-4">
                <div class="card-header">
                    <i class="fas fa-graduation-cap me-2" style="color:var(--green);"></i> Academic Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Programme <span class="text-danger">*</span></label>
                            <select name="programme_id" class="form-select @error('programme_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Programme</option>
                                @foreach($programmes as $programme)
                                    <option value="{{ $programme->id }}" {{ old('programme_id', $student->programme_id) == $programme->id ? 'selected' : '' }}>{{ $programme->name }}</option>
                                @endforeach
                            </select>
                            @error('programme_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Department <span class="text-danger">*</span></label>
                            <select name="department_id" class="form-select @error('department_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $student->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Student ID</label>
                            <input type="text" class="form-control" style="font-size:13px;border-radius:8px;background:var(--bg);" value="{{ $student->student_id }}" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-sistech">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2" style="color:#D97706;"></i> Additional Details
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Index Number</label>
                            <input type="text" class="form-control" style="font-size:13px;border-radius:8px;background:var(--bg);" value="{{ $student->index_number ?? '-' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Admission Date</label>
                            <input type="text" class="form-control" style="font-size:13px;border-radius:8px;background:var(--bg);" value="{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d M Y') : '-' }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Email Address</label>
                            <input type="text" class="form-control" style="font-size:13px;border-radius:8px;background:var(--bg);" value="{{ $student->user->email ?? '-' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 mb-3">
        <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary" style="border-radius:8px;">Cancel</a>
        <button type="submit" class="btn btn-sistech"><i class="fas fa-save me-1"></i> Update Student</button>
    </div>
</form>
@endsection
