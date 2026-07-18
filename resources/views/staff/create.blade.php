@extends('layouts.app')
@section('title', 'Add Staff')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 style="color: var(--primary); font-weight: 700;">Add Staff Member</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.staff.store') }}">
                @csrf

                <div class="row g-4">
                    <!-- Personal Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3 pb-2" style="color: var(--primary); border-bottom: 2px solid var(--primary);">
                            <i class="bi bi-person me-2"></i>Personal Information
                        </h5>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required placeholder="Enter full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required placeholder="Enter email address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" placeholder="Enter phone number">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="qualification" class="form-label fw-semibold">Qualification</label>
                            <input type="text" name="qualification" id="qualification" class="form-control @error('qualification') is-invalid @enderror"
                                   value="{{ old('qualification') }}" placeholder="e.g. PhD in Computer Science">
                            @error('qualification')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="specialization" class="form-label fw-semibold">Specialization</label>
                            <input type="text" name="specialization" id="specialization" class="form-control @error('specialization') is-invalid @enderror"
                                   value="{{ old('specialization') }}" placeholder="e.g. Software Engineering">
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Login Password</label>
                            <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   value="{{ old('password') }}" placeholder="Leave blank for auto-generated">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Min 6 characters. Leave blank to auto-generate.</small>
                        </div>
                    </div>

                    <!-- Employment Details -->
                    <div class="col-md-6">
                        <h5 class="mb-3 pb-2" style="color: var(--primary); border-bottom: 2px solid var(--primary);">
                            <i class="bi bi-briefcase me-2"></i>Employment Details
                        </h5>

                        <div class="mb-3">
                            <label for="department_id" class="form-label fw-semibold">Department <span class="text-danger">*</span></label>
                            <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                            <select name="position" id="position" class="form-select @error('position') is-invalid @enderror" required>
                                <option value="">Select Position</option>
                                @foreach(['lecturer','hod','registrar','accountant','admin','librarian','it_support','security','cleaner','other'] as $pos)
                                    <option value="{{ $pos }}" {{ old('position') === $pos ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $pos)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="employment_type" class="form-label fw-semibold">Employment Type <span class="text-danger">*</span></label>
                            <select name="employment_type" id="employment_type" class="form-select @error('employment_type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                @foreach(['full_time','part_time','contract','visiting'] as $type)
                                    <option value="{{ $type }}" {{ old('employment_type') === $type ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hire_date" class="form-label fw-semibold">Hire Date <span class="text-danger">*</span></label>
                            <input type="date" name="hire_date" id="hire_date" class="form-control @error('hire_date') is-invalid @enderror"
                                   value="{{ old('hire_date') }}" required>
                            @error('hire_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label fw-semibold">Salary</label>
                            <div class="input-group">
                                <span class="input-group-text">SLE</span>
                                <input type="number" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror"
                                       value="{{ old('salary') }}" step="0.01" min="0" placeholder="0.00">
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-sistech px-4">
                        <i class="bi bi-check-lg me-1"></i> Register Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
