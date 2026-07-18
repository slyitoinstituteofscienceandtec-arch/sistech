@extends('layouts.app')
@section('title', 'Add Course')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Course</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Create a new course</p>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.courses.store') }}">
            @csrf
            <div class="card-sistech mb-4">
                <div class="card-header">
                    <i class="fas fa-book me-2" style="color:var(--primary);"></i> Course Details
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Course Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('code') }}" required placeholder="e.g. CSC101">
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Course Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
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
                            <label class="form-label" style="font-size:12px;font-weight:600;">Programme <span class="text-danger">*</span></label>
                            <select name="programme_id" class="form-select @error('programme_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Programme</option>
                                @foreach($programmes as $prog)
                                    <option value="{{ $prog->id }}" {{ old('programme_id') == $prog->id ? 'selected' : '' }}>{{ $prog->name }}</option>
                                @endforeach
                            </select>
                            @error('programme_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Credit Units <span class="text-danger">*</span></label>
                            <input type="number" name="credit_units" class="form-control @error('credit_units') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('credit_units') }}" min="1" max="10" required>
                            @error('credit_units') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Semester <span class="text-danger">*</span></label>
                            <select name="semester" class="form-select @error('semester') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Semester</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                            </select>
                            @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Level <span class="text-danger">*</span></label>
                            <select name="level" class="form-select @error('level') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Level</option>
                                @for($i = 100; $i <= 500; $i += 100)
                                    <option value="{{ $i }}" {{ old('level') == $i ? 'selected' : '' }}>{{ $i }} Level</option>
                                @endfor
                            </select>
                            @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Lecturer</label>
                            <select name="lecturer_id" class="form-select @error('lecturer_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;">
                                <option value="">Select Lecturer</option>
                                @foreach($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ old('lecturer_id') == $lecturer->id ? 'selected' : '' }}>{{ $lecturer->name }}</option>
                                @endforeach
                            </select>
                            @error('lecturer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Status</label>
                            <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" style="font-size:13px;border-radius:8px;">
                                <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" style="font-size:13px;border-radius:8px;" rows="4">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-3">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Cancel</a>
                <button type="submit" class="btn btn-sistech"><i class="fas fa-save me-1"></i> Create Course</button>
            </div>
        </form>
    </div>
</div>
@endsection
