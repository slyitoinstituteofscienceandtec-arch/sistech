@extends('layouts.public')
@section('title', 'Home')

@section('content')

<!-- Hero -->
<section class="hero">
    <div class="container">
        <div class="hero-badge">
            <i class="fas fa-check-circle"></i>
            Admissions Open 2026/2027
        </div>
        <h1>Empowering Future<br><span>Tech Leaders</span> in Sierra Leone</h1>
        <p>Join Sierra Leone's premier technology institution and gain the skills, knowledge, and experience to thrive in the digital world. Your future in tech starts at SISTECH.</p>
        <div class="hero-actions">
            <a href="{{ route('public.courses') }}" class="btn btn-white btn-lg">Explore Courses <i class="fas fa-arrow-right"></i></a>
            <a href="{{ route('public.enrollment') }}" class="btn btn-ghost btn-lg">Apply Now</a>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="section">
    <div class="container">
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-number">{{ $studentCount }}</div>
                <div class="stat-label">Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-number">{{ $staffCount }}</div>
                <div class="stat-label">Staff</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-number">{{ $programmes->count() }}</div>
                <div class="stat-label">Programmes</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-number">{{ $departments->count() }}</div>
                <div class="stat-label">Departments</div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose SISTECH -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="overline">Why Choose Us</div>
            <h2>Excellence in Technology Education</h2>
            <p>Discover what sets SISTECH apart as the leading technology institution in Sierra Leone</p>
        </div>
        <div class="grid-3">
            <div class="feature-card">
                <div class="feature-icon blue">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h4>Expert Faculty</h4>
                <p>Learn from highly qualified lecturers and industry professionals who bring real-world expertise and hands-on experience to every classroom session.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon green">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h4>Modern Facilities</h4>
                <p>Train in state-of-the-art computer labs and networking facilities equipped with the latest technology to give you a competitive edge.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon purple">
                    <i class="fas fa-handshake"></i>
                </div>
                <h4>Industry Partnerships</h4>
                <p>Benefit from strong partnerships with leading tech companies that provide internship opportunities, mentorship, and career pathways for graduates.</p>
            </div>
        </div>
    </div>
</section>

<!-- Our Programmes -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="overline">Our Programmes</div>
            <h2>Explore Our Programmes</h2>
            <p>Comprehensive technology programmes designed to prepare you for the digital world</p>
        </div>
        <div class="grid-3">
            @foreach($programmes as $programme)
            <div class="course-card">
                <div class="course-top">
                    <div style="margin-bottom: 12px;">
                        <span class="badge badge-blue">{{ $programme->code }}</span>
                    </div>
                    <h5>{{ $programme->name }}</h5>
                </div>
                <div class="course-bottom">
                    <div class="course-meta">
                        <span><i class="fas fa-building"></i> {{ $programme->department->name ?? 'General' }}</span>
                        <span><i class="fas fa-clock"></i> Duration: {{ $programme->duration_months ?? '12' }} months</span>
                    </div>
                    <div style="margin-top: 16px;">
                        <a href="{{ route('public.courses') }}" style="font-size: 13px; font-weight: 600; color: var(--primary);">Learn More <i class="fas fa-arrow-right" style="font-size: 11px;"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($programmes->count() > 6)
        <div style="text-align: center; margin-top: 40px;">
            <a href="{{ route('public.courses') }}" class="btn btn-primary">View All Programmes <i class="fas fa-arrow-right"></i></a>
        </div>
        @endif
    </div>
</section>

<!-- Announcements -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="overline">Announcements</div>
            <h2>Latest Updates</h2>
            <p>Stay informed with the latest news and updates from SISTECH</p>
        </div>
        <div class="grid-3">
            @forelse($announcements as $announcement)
            <div class="feature-card" style="padding: 0; overflow: hidden;">
                <div style="padding: 24px 24px 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                        @php
                            $typeClass = 'badge-blue';
                            $typeLower = strtolower($announcement->type ?? 'general');
                            if($typeLower === 'finance') $typeClass = 'badge-green';
                            elseif($typeLower === 'event') $typeClass = 'badge-orange';
                            elseif(in_array($typeLower, ['emergency', 'exam'])) $typeClass = 'badge-red';
                            elseif($typeLower !== 'academic') $typeClass = 'badge-blue';
                        @endphp
                        <span class="badge {{ $typeClass }}">{{ ucfirst($announcement->type ?? 'General') }}</span>
                        <span style="font-size: 12px; color: var(--text-muted);">{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>
                    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; line-height: 1.4;">{{ $announcement->title }}</h4>
                    <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6;">{{ Str::limit(strip_tags($announcement->content), 100) }}</p>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0; color: var(--text-muted);">
                <i class="fas fa-bullhorn" style="font-size: 40px; opacity: 0.2; margin-bottom: 16px; display: block;"></i>
                <p>No announcements at this time. Check back soon!</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Contact Info Bar -->
<section style="background: var(--primary-darker); padding: 40px 0;">
    <div class="container">
        <div style="display: flex; justify-content: center; gap: 60px; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 14px; color: white;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-envelope" style="font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size: 12px; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">Email Us</div>
                    <a href="mailto:sistech2025@gmail.com" style="color: white; font-weight: 600; font-size: 15px;">sistech2025@gmail.com</a>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 14px; color: white;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-globe" style="font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size: 12px; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">Visit Us Online</div>
                    <a href="https://sistech.website" target="_blank" style="color: white; font-weight: 600; font-size: 15px;">www.sistech.website</a>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 14px; color: white;">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-phone-alt" style="font-size: 1.1rem;"></i>
                </div>
                <div>
                    <div style="font-size: 12px; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">Call Us</div>
                    <span style="font-weight: 600; font-size: 15px;">+232 77 893 327</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>Ready to Start Your Journey?</h2>
            <p>Join thousands of students who have transformed their careers through SISTECH. Your future in technology starts here.</p>
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('public.enrollment') }}" class="btn btn-white btn-lg">Apply Now <i class="fas fa-arrow-right"></i></a>
                <a href="{{ route('public.contact') }}" class="btn btn-ghost btn-lg">Contact Us</a>
            </div>
        </div>
    </div>
</section>

@endsection
