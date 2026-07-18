@extends('layouts.app')
@section('title', 'Admit New Student')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Admit New Student</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Fill in the student details for admission</p>
    </div>
    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<form method="POST" action="{{ route('admin.students.store') }}">
    @csrf

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
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('phone') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">National ID</label>
                            <input type="text" name="national_id" class="form-control @error('national_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('national_id') }}">
                            @error('national_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" style="font-size:13px;border-radius:8px;" rows="2">{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Login Password</label>
                            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('password') }}" placeholder="Leave blank for auto-generated password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Min 6 characters. Leave blank to auto-generate.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Previous School</label>
                            <input type="text" name="previous_school" class="form-control @error('previous_school') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('previous_school') }}">
                            @error('previous_school') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Previous Qualification</label>
                            <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('qualification') }}" placeholder="e.g. WASSCE, BECE">
                            @error('qualification') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Programme <span class="text-danger">*</span></label>
                            <select name="programme_id" class="form-select @error('programme_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Programme</option>
                                @foreach($programmes as $programme)
                                    <option value="{{ $programme->id }}" {{ old('programme_id') == $programme->id ? 'selected' : '' }}>{{ $programme->name }}</option>
                                @endforeach
                            </select>
                            @error('programme_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Department <span class="text-danger">*</span></label>
                            <select name="department_id" class="form-select @error('department_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Academic Year</label>
                            <select name="academic_year_id" class="form-select @error('academic_year_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;">
                                <option value="">Select Year</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                @endforeach
                            </select>
                            @error('academic_year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Admission Date <span class="text-danger">*</span></label>
                            <input type="date" name="admission_date" class="form-control @error('admission_date') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('admission_date', date('Y-m-d')) }}" required>
                            @error('admission_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-sistech">
                <div class="card-header">
                    <i class="fas fa-users me-2" style="color:#D97706;"></i> Guardian Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Guardian Name</label>
                            <input type="text" name="guardian_name" class="form-control @error('guardian_name') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('guardian_name') }}">
                            @error('guardian_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Guardian Phone</label>
                            <input type="text" name="guardian_phone" class="form-control @error('guardian_phone') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('guardian_phone') }}">
                            @error('guardian_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Guardian Email</label>
                            <input type="email" name="guardian_email" class="form-control @error('guardian_email') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('guardian_email') }}">
                            @error('guardian_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4 mb-3">
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Cancel</a>
        <button type="submit" class="btn btn-sistech"><i class="fas fa-save me-1"></i> Admit Student</button>
    </div>
</form>
@endsection
