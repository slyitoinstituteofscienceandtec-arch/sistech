@extends('layouts.app')
@section('title', 'Edit Department')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Edit Department</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Update department information</p>
    </div>
    <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.departments.update', $department) }}">
            @csrf
            @method('PUT')
            <div class="card-sistech mb-4">
                <div class="card-header">
                    <i class="fas fa-building me-2" style="color:var(--primary);"></i> Department Details
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('name', $department->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Department Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" style="font-size:13px;border-radius:8px;" value="{{ old('code', $department->code) }}" required>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Head of Department</label>
                            <select name="head_of_department_id" class="form-select @error('head_of_department_id') is-invalid @enderror" style="font-size:13px;border-radius:8px;">
                                <option value="">-- Select HOD --</option>
                                @foreach(\App\Models\User::where('role', 'staff')->orWhere('role', 'lecturer')->get() as $staffUser)
                                    <option value="{{ $staffUser->id }}" {{ old('head_of_department_id', $department->head_of_department_id) == $staffUser->id ? 'selected' : '' }}>{{ $staffUser->name }}</option>
                                @endforeach
                            </select>
                            @error('head_of_department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Status</label>
                            <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" style="font-size:13px;border-radius:8px;">
                                <option value="1" {{ old('is_active', $department->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $department->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label" style="font-size:12px;font-weight:600;">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" style="font-size:13px;border-radius:8px;" rows="4">{{ old('description', $department->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-3">
                <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary" style="border-radius:8px;">Cancel</a>
                <button type="submit" class="btn btn-sistech"><i class="fas fa-save me-1"></i> Update Department</button>
            </div>
        </form>
    </div>
</div>
@endsection
