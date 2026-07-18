@extends('layouts.public')

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <h1>Our Courses</h1>
        <p>Explore our technology and skills programmes at SISTECH</p>
        <div class="breadcrumb">
            <a href="{{ route('public.home') }}">Home</a>
            <span>/</span>
            <span>Courses</span>
        </div>
    </div>
</div>

<!-- Filter Section -->
<section class="section">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('public.courses') }}" style="display: flex; align-items: flex-end; gap: 1rem; flex-wrap: wrap;">
                    <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name or code..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-control">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="height: 46px;">
                        <i class="fas fa-search" style="margin-right: 0.5rem;"></i> Filter
                    </button>
                    @if(request('department') || request('search'))
                        <a href="{{ route('public.courses') }}" class="btn btn-outline" style="height: 46px;">
                            <i class="fas fa-times" style="margin-right: 0.5rem;"></i> Clear Filters
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Course Grid -->
<section class="section" style="padding-top: 0;">
    <div class="container">
        @if($courses->count())
            <div class="grid-3">
                @foreach($courses as $course)
                    <div class="course-card" style="transition: transform 0.2s, box-shadow 0.2s;">
                        <div class="course-top">
                            <span class="course-code">{{ $course->code }}</span>
                            <h5 class="course-name" style="margin: 0.5rem 0 0; font-size: 1.05rem;">
                                {{ $course->name }}
                            </h5>
                        </div>
                        <div class="course-bottom">
                            <div class="course-meta">
                                @if($course->department)
                                    <span>
                                        <i class="fas fa-building"></i> {{ $course->department->name }}
                                    </span>
                                @endif
                                <span>
                                    <i class="fas fa-clock"></i> {{ $course->credit_units ?? '-' }} Credits
                                </span>
                                <span>
                                    <i class="fas fa-calendar"></i> {{ $course->semester ?? '-' }}
                                </span>
                            </div>
                            @if($course->programme)
                                <div style="padding-top: 0.75rem; border-top: 1px solid #f1f5f9; margin-top: 0.75rem;">
                                    <span class="badge badge-blue">
                                        <i class="fas fa-graduation-cap" style="margin-right: 0.25rem;"></i>
                                        {{ $course->programme->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; color: #94a3b8;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2rem;">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 style="color: #475569; margin-bottom: 0.5rem;">No Courses Found</h3>
                <p style="margin: 0;">We couldn't find any courses matching your criteria. Try adjusting your filters or check back later.</p>
                @if(request('department'))
                    <a href="{{ route('public.courses') }}" class="btn btn-outline" style="margin-top: 1.5rem;">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

<!-- Pagination -->
@if($courses->hasPages())
<section style="padding-bottom: 3rem;">
    <div class="container">
        <div style="text-align: center;">
            {{ $courses->withQueryString()->links() }}
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section class="cta-banner">
    <div class="container" style="text-align: center;">
        <h2 style="color: #fff; margin-bottom: 1rem;">Can't Find What You're Looking For?</h2>
        <p style="color: rgba(255,255,255,0.85); margin-bottom: 2rem; font-size: 1.125rem;">Our team is here to help you find the perfect programme for your career goals.</p>
        <a href="{{ route('public.contact') }}" class="btn btn-primary btn-lg" style="background: #fff; color: #2563eb;">
            Contact Us <i class="fas fa-envelope" style="margin-left: 0.5rem;"></i>
        </a>
    </div>
</section>
@endsection