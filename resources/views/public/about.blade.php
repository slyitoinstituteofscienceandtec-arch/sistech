@extends('layouts.public')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>About SISTECH</h1>
        <p>Empowering Sierra Leone through Technology Education since 2021</p>
        <div class="breadcrumb">
            <a href="{{ route('public.home') }}">Home</a>
            <span>/</span>
            <span>About</span>
        </div>
    </div>
</div>

<!-- Institutional Profile -->
<section class="section">
    <div class="container">
        <div class="grid-2" style="align-items: start;">
            <div>
                <div class="overline" style="display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--primary); margin-bottom: 14px;">
                    Our Story
                </div>
                <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 20px; letter-spacing: -0.02em;">Slyito Institute of Science and Technology</h2>
                <p style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 16px;">
                    Slyito Institute of Science and Technology (SISTECH) is a private technology and vocational training institution located in Waterloo, Sierra Leone. Established in <strong>2021</strong>, the institute is dedicated to providing practical, career-oriented education in science, technology, business, and digital skills.
                </p>
                <p style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 16px;">
                    SISTECH equips learners with the knowledge and hands-on experience required to excel in today's rapidly evolving digital economy while promoting innovation, entrepreneurship, and lifelong learning.
                </p>
                <p style="color: var(--text-secondary); line-height: 1.8;">
                    The institute emphasizes practical instruction, industry-relevant training, and professional development to prepare students for employment, self-employment, and higher education.
                </p>
            </div>
            <div>
                <div class="card" style="border-top: 4px solid var(--primary);">
                    <div class="card-body" style="padding: 32px;">
                        <h4 style="margin-bottom: 24px; color: var(--primary);">Educational Philosophy</h4>
                        <p style="color: var(--text-secondary); line-height: 1.8;">
                            SISTECH believes that education should be practical, innovative, affordable, and accessible. The institution focuses on <strong>competency-based learning</strong> where students develop both theoretical knowledge and practical skills that can immediately be applied in workplaces and business environments.
                        </p>
                        <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                <i class="fas fa-award" style="color: var(--green); font-size: 18px;"></i>
                                <strong style="font-size: 14px;">Excellence</strong>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                <i class="fas fa-handshake" style="color: var(--primary); font-size: 18px;"></i>
                                <strong style="font-size: 14px;">Integrity</strong>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                <i class="fas fa-lightbulb" style="color: #D97706; font-size: 18px;"></i>
                                <strong style="font-size: 14px;">Innovation</strong>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-users" style="color: #7C3AED; font-size: 18px;"></i>
                                <strong style="font-size: 14px;">Professionalism</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section section-alt">
    <div class="container">
        <div class="grid-2">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div class="feature-icon blue" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 style="margin: 0;">Our Mission</h3>
                    </div>
                    <p style="color: #64748b; line-height: 1.8; margin: 0;">
                        To provide quality, affordable, and practical education through competent instruction, modern technology, and industry-based training that prepares students to become skilled professionals, responsible citizens, and innovative entrepreneurs.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <div class="feature-icon green" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 style="margin: 0;">Our Vision</h3>
                    </div>
                    <p style="color: #64748b; line-height: 1.8; margin: 0;">
                        To become a leading institution in science, technology, healthcare, and technical education that empowers individuals with practical knowledge, innovation, creativity, and leadership skills for sustainable national and global development.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="overline">Our Values</div>
            <h2>Core Values</h2>
            <p>The principles that guide everything we do at SISTECH</p>
        </div>
        <div class="grid-3">
            @php
                $values = [
                    ['icon' => 'fa-award', 'color' => 'blue', 'title' => 'Excellence', 'desc' => 'We strive for the highest standards in education and professional practice.'],
                    ['icon' => 'fa-handshake', 'color' => 'green', 'title' => 'Integrity', 'desc' => 'We uphold honesty, transparency, and ethical conduct in all our interactions.'],
                    ['icon' => 'fa-lightbulb', 'color' => 'purple', 'title' => 'Innovation', 'desc' => 'We embrace creative thinking and modern approaches to problem-solving.'],
                    ['icon' => 'fa-user-tie', 'color' => 'blue', 'title' => 'Professionalism', 'desc' => 'We maintain the highest standards of professional behavior and competence.'],
                    ['icon' => 'fa-clipboard-check', 'color' => 'green', 'title' => 'Accountability', 'desc' => 'We take responsibility for our actions and outcomes.'],
                    ['icon' => 'fa-graduation-cap', 'color' => 'purple', 'title' => 'Lifelong Learning', 'desc' => 'We promote continuous personal and professional development.'],
                ];
            @endphp
            @foreach($values as $value)
            <div class="feature-card">
                <div class="feature-icon {{ $value['color'] }}">
                    <i class="fas {{ $value['icon'] }}"></i>
                </div>
                <h4>{{ $value['title'] }}</h4>
                <p>{{ $value['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Objectives -->
<section class="section section-gray">
    <div class="container">
        <div class="section-header">
            <div class="overline">Our Goals</div>
            <h2>Objectives</h2>
        </div>
        <div class="grid-2" style="gap: 16px;">
            @php
                $objectives = [
                    'Deliver quality technology and vocational education.',
                    'Promote digital literacy within communities.',
                    'Prepare students for employment and entrepreneurship.',
                    'Encourage research, innovation, and creativity.',
                    'Develop competent professionals with ethical values.',
                    'Bridge the gap between education and industry needs.',
                    'Support national development through technology and skills training.',
                ];
            @endphp
            @foreach($objectives as $obj)
            <div style="display: flex; align-items: start; gap: 14px; padding: 16px 20px; background: white; border-radius: 12px; border: 1px solid var(--border);">
                <i class="fas fa-check-circle" style="color: var(--green); margin-top: 2px; font-size: 16px;"></i>
                <span style="font-size: 14px; color: var(--text-secondary); line-height: 1.6;">{{ $obj }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose SISTECH -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="overline">Benefits</div>
            <h2>Why Choose SISTECH?</h2>
            <p>What makes us the right choice for your education</p>
        </div>
        <div class="grid-3">
            @php
                $reasons = [
                    ['icon' => 'fa-cogs', 'title' => 'Practical Training', 'desc' => 'Industry-focused, hands-on training that prepares you for the real world.'],
                    ['icon' => 'fa-money-bill-wave', 'title' => 'Affordable Tuition', 'desc' => 'Quality education at fees that are accessible to all.'],
                    ['icon' => 'fa-chalkboard-teacher', 'title' => 'Qualified Instructors', 'desc' => 'Learn from experienced professionals and industry experts.'],
                    ['icon' => 'fa-laptop', 'title' => 'Technology-Driven', 'desc' => 'Modern computer labs and digital learning environments.'],
                    ['icon' => 'fa-users', 'title' => 'Small Class Sizes', 'desc' => 'Personalized attention for every student.'],
                    ['icon' => 'fa-briefcase', 'title' => 'Career-Oriented', 'desc' => 'Curriculum designed to meet industry demands.'],
                ];
            @endphp
            @foreach($reasons as $reason)
            <div class="feature-card">
                <div class="feature-icon blue">
                    <i class="fas {{ $reason['icon'] }}"></i>
                </div>
                <h4>{{ $reason['title'] }}</h4>
                <p>{{ $reason['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Facilities -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="overline">Infrastructure</div>
            <h2>Our Facilities</h2>
            <p>Modern infrastructure that supports effective teaching and learning</p>
        </div>
        <div class="grid-3">
            @php
                $facilities = [
                    ['icon' => 'fa-desktop', 'title' => 'Computer Laboratories', 'desc' => 'Fully equipped labs with modern computers and software.'],
                    ['icon' => 'fa-wifi', 'title' => 'Internet-Enabled Learning', 'desc' => 'Campus-wide internet access for research and digital learning.'],
                    ['icon' => 'fa-tv', 'title' => 'Multimedia Facilities', 'desc' => 'Presentation and multimedia equipment for interactive learning.'],
                    ['icon' => 'fa-tools', 'title' => 'Practical Training Equipment', 'desc' => 'Hands-on tools and equipment for technical training.'],
                    ['icon' => 'fa-building', 'title' => 'Technology Classrooms', 'desc' => 'Modern classrooms designed for technology-enhanced instruction.'],
                    ['icon' => 'fa-headset', 'title' => 'Student Support Services', 'desc' => 'Dedicated support for academic and personal development.'],
                ];
            @endphp
            @foreach($facilities as $fac)
            <div class="feature-card">
                <div class="feature-icon green">
                    <i class="fas {{ $fac['icon'] }}"></i>
                </div>
                <h4>{{ $fac['title'] }}</h4>
                <p>{{ $fac['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats -->
<section class="section section-gray">
    <div class="container">
        <div class="stats-row grid-4">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-number">{{ $studentCount }}</div>
                <div class="stat-label">Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stat-number">{{ $staffCount }}</div>
                <div class="stat-label">Staff</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-building"></i></div>
                <div class="stat-number">{{ $departments->count() }}</div>
                <div class="stat-label">Departments</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-book-open"></i></div>
                <div class="stat-number">{{ $programmes->count() }}</div>
                <div class="stat-label">Programmes</div>
            </div>
        </div>
    </div>
</section>

<!-- Teaching Methodology -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="overline">How We Teach</div>
            <h2>Teaching Methodology</h2>
        </div>
        <div class="grid-4">
            @php
                $methods = [
                    ['icon' => 'fa-flask', 'label' => 'Lab Sessions'],
                    ['icon' => 'fa-laptop-code', 'label' => 'Hands-on Training'],
                    ['icon' => 'fa-project-diagram', 'label' => 'Project-Based Learning'],
                    ['icon' => 'fa-chalkboard', 'label' => 'Interactive Instruction'],
                    ['icon' => 'fa-clipboard-list', 'label' => 'Continuous Assessment'],
                    ['icon' => 'fa-user-graduate', 'label' => 'Professional Mentoring'],
                    ['icon' => 'fa-tasks', 'label' => 'Real-World Assignments'],
                    ['icon' => 'fa-desktop', 'label' => 'Demonstrations'],
                ];
            @endphp
            @foreach($methods as $method)
            <div style="text-align: center; padding: 24px 16px; background: white; border-radius: 12px; border: 1px solid var(--border);">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                    <i class="fas {{ $method['icon'] }}"></i>
                </div>
                <span style="font-size: 13px; font-weight: 600;">{{ $method['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section section-alt">
    <div class="container">
        <div class="cta-banner">
            <h2>Start Your Journey at SISTECH</h2>
            <p>Join us and become part of the next generation of technology leaders in Sierra Leone.</p>
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('public.enrollment') }}" class="btn btn-white btn-lg">Apply Now <i class="fas fa-arrow-right"></i></a>
                <a href="{{ route('public.contact') }}" class="btn btn-ghost btn-lg">Contact Us</a>
            </div>
        </div>
    </div>
</section>
@endsection
