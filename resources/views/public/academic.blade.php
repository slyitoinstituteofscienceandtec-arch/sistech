@extends('layouts.public')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Academic Information</h1>
        <p>Our academic calendar and programme offerings</p>
        <div class="breadcrumb">
            <a href="{{ route('public.home') }}">Home</a>
            <span>/</span>
            <span>Academic</span>
        </div>
    </div>
</div>

@if($currentYear)
<section class="section">
    <div class="container">
        <div class="card" style="border: 2px solid #0066CC; overflow: hidden;">
            <div class="card-body" style="padding: 2.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <span class="badge badge-green" style="margin-bottom: 0.5rem; display: inline-block;">Current Year</span>
                        <h2 style="margin: 0; font-size: 1.75rem; color: #1a1a2e;">{{ $currentYear->name }}</h2>
                        <p style="margin: 0.5rem 0 0; color: #666; font-size: 0.95rem;">
                            {{ \Carbon\Carbon::parse($currentYear->start_date)->format('M d, Y') }}
                            &mdash;
                            {{ \Carbon\Carbon::parse($currentYear->end_date)->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                @if($currentYear->semesters && count($currentYear->semesters) > 0)
                <div style="border-top: 1px solid #e8ecf1; padding-top: 1.5rem;">
                    <h3 style="font-size: 1rem; text-transform: uppercase; letter-spacing: 0.05em; color: #888; margin-bottom: 1rem;">Semesters</h3>
                    <div class="grid-2" style="gap: 1rem;">
                        @foreach($currentYear->semesters as $semester)
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                            <div class="feature-icon blue" style="width: 48px; height: 48px; min-width: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; background: linear-gradient(135deg, #0066CC, #004999); color: #fff; font-size: 1rem; font-weight: 700;">
                                S{{ $loop->iteration }}
                            </div>
                            <div>
                                <strong style="color: #1a1a2e;">{{ $semester->name }}</strong>
                                <p style="margin: 0.25rem 0 0; font-size: 0.85rem; color: #666;">
                                    {{ \Carbon\Carbon::parse($semester->start_date)->format('M d') }}
                                    &mdash;
                                    {{ \Carbon\Carbon::parse($semester->end_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <span class="overline">ACADEMIC CALENDAR</span>
            <h2>Academic Years</h2>
        </div>

        @if($academicYears && count($academicYears) > 0)
        <div class="timeline" style="max-width: 800px; margin: 2rem auto 0;">
            @foreach($academicYears as $year)
            @php
                $isCurrent = $currentYear && $year->id === $currentYear->id;
            @endphp
            <div class="timeline-item">
                <div class="timeline-dot {{ $isCurrent ? 'green' : '' }}"></div>
                <div class="card" style="margin-bottom: 1.5rem; {{ $isCurrent ? 'border: 2px solid #22c55e; box-shadow: 0 4px 20px rgba(34,197,94,0.1);' : '' }}">
                    <div class="card-body" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.35rem;">
                                <h3 style="margin: 0; font-size: 1.2rem; color: #1a1a2e;">{{ $year->name }}</h3>
                                @if($isCurrent)
                                <span class="badge badge-green">Current</span>
                                @endif
                            </div>
                            <p style="margin: 0; color: #666; font-size: 0.9rem;">
                                {{ \Carbon\Carbon::parse($year->start_date)->format('M d, Y') }}
                                &mdash;
                                {{ \Carbon\Carbon::parse($year->end_date)->format('M d, Y') }}
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <span class="badge badge-blue">{{ $year->semesters_count ?? $year->semesters->count() ?? 0 }} Semesters</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem; color: #888;">
                <i class="fas fa-calendar-alt" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; color: #ccc;"></i>
                <p style="margin: 0;">No academic years have been published yet.</p>
            </div>
        </div>
        @endif
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="overline">PROGRAMMES</span>
            <h2>Our Programme Offerings</h2>
        </div>

        @php
            $grouped = $programmes->groupBy(function ($p) {
                return $p->department->name ?? 'General';
            });
        @endphp

        @if(count($grouped) > 0)
        <div style="display: flex; flex-direction: column; gap: 2rem; margin-top: 2rem;">
            @foreach($grouped as $deptName => $deptProgrammes)
            <div class="card" style="overflow: hidden;">
                <div style="background: linear-gradient(135deg, #0066CC, #004999); padding: 1.25rem 1.75rem;">
                    <h3 style="margin: 0; color: #fff; font-size: 1.15rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-building"></i>
                        {{ $deptName }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="grid-2" style="gap: 1rem;">
                        @foreach($deptProgrammes as $programme)
                        <div style="padding: 1.25rem; border: 1px solid #e8ecf1; border-radius: 12px; transition: all 0.2s;" onmouseover="this.style.borderColor='#0066CC'; this.style.boxShadow='0 2px 12px rgba(0,102,204,0.08)'" onmouseout="this.style.borderColor='#e8ecf1'; this.style.boxShadow='none'">
                            <div style="display: flex; align-items: start; justify-content: space-between; gap: 1rem; margin-bottom: 0.5rem;">
                                <h4 style="margin: 0; color: #1a1a2e; font-size: 1.05rem;">{{ $programme->name }}</h4>
                                <span class="badge badge-blue" style="white-space: nowrap;">{{ $programme->code }}</span>
                            </div>
                            <p style="margin: 0; color: #888; font-size: 0.85rem;">
                                <i class="fas fa-clock" style="margin-right: 0.35rem;"></i>
                                {{ $programme->duration_months ?? '—' }} months
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="card">
            <div class="card-body" style="text-align: center; padding: 3rem; color: #888;">
                <i class="fas fa-graduation-cap" style="font-size: 2.5rem; margin-bottom: 1rem; display: block; color: #ccc;"></i>
                <p style="margin: 0;">Programme information will be available soon.</p>
            </div>
        </div>
        @endif
    </div>
</section>

<section class="section" style="padding: 0;">
    <div class="container">
        <div class="cta-banner" style="background: linear-gradient(135deg, #0066CC, #004999); border-radius: 20px; padding: 3.5rem; text-align: center; color: #fff;">
            <h2 style="margin: 0 0 0.75rem; font-size: 2rem; color: #fff;">Ready to Enrol?</h2>
            <p style="margin: 0 0 2rem; font-size: 1.1rem; opacity: 0.9;">Take the first step toward your future at SISTECH.</p>
            <a href="{{ route('public.enrollment') }}" class="btn btn-lg" style="background: #fff; color: #0066CC; font-weight: 600; padding: 1rem 2.5rem; border-radius: 12px; text-decoration: none; display: inline-block;">
                Apply Now <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
            </a>
        </div>
    </div>
</section>
@endsection
