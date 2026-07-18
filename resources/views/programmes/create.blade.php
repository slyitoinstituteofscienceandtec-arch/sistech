@extends('layouts.app')
@section('title', 'Add Programme')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Programme</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Create a new academic programme</p>
    </div>
    <a href="{{ route('admin.programmes.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.programmes.store') }}">
            @csrf
            <div class="card-sistech mb-4">
                <div class="card-header">
                    <i class="fas fa-graduation-cap me-2" style="color:var(--primary);"></i> Programme Details
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Programme Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Programme Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('code') }}" required placeholder="e.g. BSC-CS">
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <label class="form-label" style="font-size:12px;font-weight:600;">Level <span class="text-danger">*</span></label>
                            <select name="level" class="form-select @error('level') is-invalid @enderror" style="font-size:13px;border-radius:8px;" required>
                                <option value="">Select Level</option>
                                <option value="certificate" {{ old('level') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                <option value="diploma" {{ old('level') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="hnd" {{ old('level') == 'hnd' ? 'selected' : '' }}>HND</option>
                                <option value="professional" {{ old('level') == 'professional' ? 'selected' : '' }}>Professional</option>
                                <option value="short_course" {{ old('level') == 'short_course' ? 'selected' : '' }}>Short Course</option>
                            </select>
                            @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Duration (Months) <span class="text-danger">*</span></label>
                            <input type="number" name="duration_months" class="form-control @error('duration_months') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('duration_months') }}" min="1" required placeholder="e.g. 48">
                            @error('duration_months') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                <a href="{{ route('admin.programmes.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Cancel</a>
                <button type="submit" class="btn btn-sistech"><i class="fas fa-save me-1"></i> Create Programme</button>
            </div>
        </form>
    </div>
</div>
@endsection
