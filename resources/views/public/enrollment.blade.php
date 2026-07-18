@extends('layouts.public')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Enrollment Application</h1>
        <p>Start your journey at SISTECH today</p>
        <div class="breadcrumb">
            <a href="{{ route('public.home') }}">Home</a>
            <span>/</span>
            <span>Enrollment</span>
        </div>
    </div>
</div>

@if(session('enrollment_success'))
<section class="section" style="padding-bottom: 0;">
    <div class="container">
        <div class="alert alert-success" style="display: flex; align-items: start; gap: 1rem; padding: 1.5rem; border-radius: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;">
            <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-top: 0.15rem; color: #22c55e;"></i>
            <div>
                <strong style="display: block; margin-bottom: 0.35rem; font-size: 1.05rem;">Application Submitted Successfully!</strong>
                <span style="opacity: 0.9;">{{ session('enrollment_success') }}</span>
            </div>
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start;">

            <div>
                @if($errors->any())
                <div class="alert" style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1.25rem 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <i class="fas fa-exclamation-circle" style="margin-top: 0.2rem; color: #dc2626;"></i>
                        <div>
                            <strong style="display: block; margin-bottom: 0.35rem;">Please fix the following errors:</strong>
                            <ul style="margin: 0; padding-left: 1.25rem;">
                                @foreach($errors->all() as $error)
                                <li style="margin-bottom: 0.2rem;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('public.enrollment.store') }}" method="POST">
                    @csrf

                    <div class="card" style="margin-bottom: 1.5rem; overflow: hidden;">
                        <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid #e8ecf1; display: flex; align-items: center; gap: 0.75rem;">
                            <div class="feature-icon blue" style="width: 36px; height: 36px; min-width: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; font-size: 0.85rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3 style="margin: 0; font-size: 1.1rem; color: #1a1a2e;">Personal Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label">First Name <span style="color: #dc2626;">*</span></label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="Enter first name" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last Name <span style="color: #dc2626;">*</span></label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Enter last name" required>
                                </div>
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label">Email Address <span style="color: #dc2626;">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone Number <span style="color: #dc2626;">*</span></label>
                                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+232 77 893 327" required>
                                </div>
                            </div>
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label">Gender <span style="color: #dc2626;">*</span></label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date of Birth <span style="color: #dc2626;">*</span></label>
                                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Enter your full address">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 1.5rem; overflow: hidden;">
                        <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid #e8ecf1; display: flex; align-items: center; gap: 0.75rem;">
                            <div class="feature-icon green" style="width: 36px; height: 36px; min-width: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: linear-gradient(135deg, #16a34a, #15803d); color: #fff; font-size: 0.85rem;">
                                <i class="fas fa-book"></i>
                            </div>
                            <h3 style="margin: 0; font-size: 1.1rem; color: #1a1a2e;">Academic Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Programme <span style="color: #dc2626;">*</span></label>
                                <select name="programme_id" class="form-control" required>
                                    <option value="">Select a Programme</option>
                                    @foreach($programmes as $programme)
                                    <option value="{{ $programme->id }}" {{ old('programme_id') == $programme->id ? 'selected' : '' }}>
                                        {{ $programme->code }} — {{ $programme->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Previous School</label>
                                <input type="text" name="previous_school" class="form-control" value="{{ old('previous_school') }}" placeholder="Name of your previous school">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Previous Qualification</label>
                                <input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}" placeholder="e.g. Grade 12 Certificate">
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 2rem; overflow: hidden;">
                        <div style="padding: 1.25rem 1.75rem; border-bottom: 1px solid #e8ecf1; display: flex; align-items: center; gap: 0.75rem;">
                            <div class="feature-icon purple" style="width: 36px; height: 36px; min-width: 36px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: linear-gradient(135deg, #9333ea, #7e22ce); color: #fff; font-size: 0.85rem;">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3 style="margin: 0; font-size: 1.1rem; color: #1a1a2e;">Guardian Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="grid-2">
                                <div class="form-group">
                                    <label class="form-label">Guardian Name <span style="color: #dc2626;">*</span></label>
                                    <input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name') }}" placeholder="Full name of guardian" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Guardian Phone <span style="color: #dc2626;">*</span></label>
                                    <input type="tel" name="guardian_phone" class="form-control" value="{{ old('guardian_phone') }}" placeholder="+232 77 893 327" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        Submit Application <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <aside>
                <div class="card" style="margin-bottom: 1.5rem; overflow: hidden; position: sticky; top: 2rem;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e8ecf1;">
                        <h4 style="margin: 0; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-clipboard-list" style="color: #0066CC;"></i>
                            Requirements
                        </h4>
                    </div>
                    <div class="card-body">
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.85rem;">
                            <li style="display: flex; align-items: start; gap: 0.65rem; font-size: 0.9rem; color: #555;">
                                <i class="fas fa-check-circle" style="color: #22c55e; margin-top: 0.2rem;"></i>
                                <span>A valid email address for communication</span>
                            </li>
                            <li style="display: flex; align-items: start; gap: 0.65rem; font-size: 0.9rem; color: #555;">
                                <i class="fas fa-check-circle" style="color: #22c55e; margin-top: 0.2rem;"></i>
                                <span>Selection of your desired programme</span>
                            </li>
                            <li style="display: flex; align-items: start; gap: 0.65rem; font-size: 0.9rem; color: #555;">
                                <i class="fas fa-check-circle" style="color: #22c55e; margin-top: 0.2rem;"></i>
                                <span>Complete personal details</span>
                            </li>
                            <li style="display: flex; align-items: start; gap: 0.65rem; font-size: 0.9rem; color: #555;">
                                <i class="fas fa-check-circle" style="color: #22c55e; margin-top: 0.2rem;"></i>
                                <span>Guardian contact information</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card" style="overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e8ecf1;">
                        <h4 style="margin: 0; color: #1a1a2e; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-info-circle" style="color: #0066CC;"></i>
                            After Submission
                        </h4>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <div style="width: 28px; height: 28px; min-width: 28px; border-radius: 50%; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">1</div>
                                <p style="margin: 0; font-size: 0.9rem; color: #555;">A unique <strong>Student ID</strong> will be automatically generated for you.</p>
                            </div>
                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <div style="width: 28px; height: 28px; min-width: 28px; border-radius: 50%; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">2</div>
                                <p style="margin: 0; font-size: 0.9rem; color: #555;">Your <strong>login credentials</strong> will be displayed on screen after approval.</p>
                            </div>
                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <div style="width: 28px; height: 28px; min-width: 28px; border-radius: 50%; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">3</div>
                                <p style="margin: 0; font-size: 0.9rem; color: #555;">Use your credentials to <strong>log in</strong> and access the student portal.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>
@endsection
