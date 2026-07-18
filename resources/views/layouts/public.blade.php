<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SISTECH') - Slyito Institute of Science and Technology</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0066CC;
            --primary-dark: #004C99;
            --primary-darker: #003366;
            --primary-light: #E6F0FF;
            --primary-50: #F0F7FF;
            --green: #00B050;
            --green-dark: #009944;
            --green-light: #E6F7EE;
            --text: #1E293B;
            --text-secondary: #475569;
            --text-muted: #94A3B8;
            --bg: #FFFFFF;
            --bg-alt: #F8FAFC;
            --bg-gray: #F1F5F9;
            --border: #E2E8F0;
            --border-light: #F1F5F9;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, sans-serif; color: var(--text); background: var(--bg); line-height: 1.6; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        img { max-width: 100%; display: block; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ── Navbar ── */
        .navbar {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226,232,240,0.8);
            position: sticky; top: 0; z-index: 1000;
            transition: var(--transition);
        }
        .navbar.scrolled { box-shadow: var(--shadow-lg); background: rgba(255,255,255,0.98); }
        .navbar .container { display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-brand { display: flex; align-items: center; gap: 14px; }
        .nav-logo {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 15px; font-weight: 800;
            box-shadow: 0 2px 8px rgba(0,102,204,0.3);
        }
        .nav-brand-text { font-weight: 700; font-size: 18px; color: var(--primary-darker); line-height: 1.2; }
        .nav-brand-text small { display: block; font-size: 10px; font-weight: 500; color: var(--text-muted); letter-spacing: 1.5px; text-transform: uppercase; }
        .nav-links { display: flex; align-items: center; gap: 2px; list-style: none; }
        .nav-links a {
            padding: 8px 18px; border-radius: 10px;
            font-size: 14px; font-weight: 500; color: var(--text-secondary);
            transition: var(--transition); position: relative;
        }
        .nav-links a:hover { color: var(--primary); background: var(--primary-50); }
        .nav-links a.active { color: var(--primary); background: var(--primary-light); font-weight: 600; }
        .nav-actions { display: flex; gap: 10px; align-items: center; }

        .btn {
            padding: 10px 22px; border-radius: 10px;
            font-size: 14px; font-weight: 600; border: none; cursor: pointer;
            transition: var(--transition); display: inline-flex; align-items: center; gap: 8px;
            font-family: inherit; line-height: 1.4;
        }
        .btn:active { transform: scale(0.98); }
        .btn-primary { background: var(--primary); color: white; box-shadow: 0 2px 8px rgba(0,102,204,0.3); }
        .btn-primary:hover { background: var(--primary-dark); box-shadow: 0 4px 12px rgba(0,102,204,0.4); transform: translateY(-1px); }
        .btn-green { background: var(--green); color: white; box-shadow: 0 2px 8px rgba(0,176,80,0.3); }
        .btn-green:hover { background: var(--green-dark); box-shadow: 0 4px 12px rgba(0,176,80,0.4); transform: translateY(-1px); }
        .btn-outline { background: transparent; color: var(--primary); border: 1.5px solid var(--primary); }
        .btn-outline:hover { background: var(--primary); color: white; }
        .btn-white { background: white; color: var(--primary); box-shadow: var(--shadow); }
        .btn-white:hover { background: var(--primary-light); transform: translateY(-1px); }
        .btn-ghost { background: rgba(255,255,255,0.15); color: white; border: 1.5px solid rgba(255,255,255,0.3); backdrop-filter: blur(10px); }
        .btn-ghost:hover { background: white; color: var(--primary); border-color: white; }
        .btn-lg { padding: 14px 32px; font-size: 16px; border-radius: 12px; }
        .btn-sm { padding: 8px 16px; font-size: 13px; border-radius: 8px; }

        .hamburger { display: none; background: none; border: none; font-size: 22px; color: var(--text); cursor: pointer; padding: 8px; border-radius: 8px; }
        .hamburger:hover { background: var(--bg-gray); }

        .mobile-nav {
            display: none; position: fixed; top: 72px; left: 0; right: 0;
            background: white; border-bottom: 1px solid var(--border);
            padding: 16px; box-shadow: var(--shadow-xl); z-index: 999;
        }
        .mobile-nav.open { display: block; }
        .mobile-nav a {
            display: block; padding: 14px 18px; border-radius: 10px;
            font-size: 15px; font-weight: 500; color: var(--text-secondary);
            margin-bottom: 4px; transition: var(--transition);
        }
        .mobile-nav a:hover, .mobile-nav a.active { background: var(--primary-light); color: var(--primary); }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(135deg, var(--primary-darker) 0%, var(--primary) 60%, #0088EE 100%);
            color: white; padding: 110px 0 90px; position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -200px; right: -100px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        }
        .hero::after {
            content: ''; position: absolute; bottom: -150px; left: -50px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        }
        .hero .container { position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2);
            padding: 6px 16px; border-radius: 100px; font-size: 13px; font-weight: 500;
            margin-bottom: 24px; backdrop-filter: blur(10px);
        }
        .hero-badge i { color: var(--green); }
        .hero h1 { font-size: 52px; font-weight: 800; line-height: 1.1; margin-bottom: 20px; letter-spacing: -0.02em; }
        .hero h1 span { background: linear-gradient(135deg, #60D0FF, #A0E8FF); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero p { font-size: 18px; opacity: 0.9; max-width: 560px; margin-bottom: 36px; line-height: 1.7; }
        .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; }

        /* ── Sections ── */
        .section { padding: 100px 0; }
        .section-alt { background: var(--bg-alt); }
        .section-gray { background: var(--bg-gray); }
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-header .overline {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;
            color: var(--primary); margin-bottom: 14px;
        }
        .section-header .overline::before, .section-header .overline::after {
            content: ''; width: 24px; height: 2px; background: var(--primary); border-radius: 1px;
        }
        .section-header h2 { font-size: 36px; font-weight: 800; color: var(--text); margin-bottom: 16px; letter-spacing: -0.02em; }
        .section-header p { color: var(--text-muted); font-size: 17px; max-width: 560px; margin: 0 auto; line-height: 1.7; }

        /* ── Stats ── */
        .stats-row {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;
            margin-top: -56px; position: relative; z-index: 10;
        }
        .stat-card {
            background: white; border-radius: var(--radius-lg); padding: 28px;
            text-align: center; box-shadow: var(--shadow-xl);
            border: 1px solid var(--border-light); transition: var(--transition);
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-xl); }
        .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; font-size: 20px;
        }
        .stat-icon.blue { background: var(--primary-light); color: var(--primary); }
        .stat-icon.green { background: var(--green-light); color: var(--green); }
        .stat-number { font-size: 36px; font-weight: 800; color: var(--text); line-height: 1; }
        .stat-label { font-size: 13px; color: var(--text-muted); margin-top: 6px; font-weight: 500; }

        /* ── Feature Cards ── */
        .feature-card {
            background: white; border-radius: var(--radius-lg); padding: 36px;
            border: 1px solid var(--border); transition: var(--transition); position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--green));
            transform: scaleX(0); transform-origin: left; transition: var(--transition);
        }
        .feature-card:hover { border-color: var(--primary); box-shadow: var(--shadow-lg); transform: translateY(-4px); }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-icon {
            width: 60px; height: 60px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 24px;
        }
        .feature-icon.blue { background: var(--primary-light); color: var(--primary); }
        .feature-icon.green { background: var(--green-light); color: var(--green); }
        .feature-icon.purple { background: #F3E8FF; color: #7C3AED; }
        .feature-card h4 { font-size: 18px; font-weight: 700; margin-bottom: 10px; color: var(--text); }
        .feature-card p { font-size: 14px; color: var(--text-muted); line-height: 1.7; }

        /* ── Cards ── */
        .card {
            background: white; border-radius: var(--radius-lg);
            border: 1px solid var(--border); overflow: hidden; transition: var(--transition);
        }
        .card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
        .card-body { padding: 28px; }

        /* ── Grids ── */
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 28px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; }

        /* ── Course Card ── */
        .course-card { border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden; transition: var(--transition); background: white; }
        .course-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
        .course-top { padding: 24px 24px 20px; background: linear-gradient(135deg, var(--primary-50), var(--primary-light)); border-bottom: 1px solid var(--border-light); }
        .course-code { font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px; }
        .course-top h5 { font-size: 17px; font-weight: 700; color: var(--text); line-height: 1.3; }
        .course-bottom { padding: 20px 24px; }
        .course-meta { display: flex; flex-wrap: wrap; gap: 14px; }
        .course-meta span { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted); font-weight: 500; }
        .course-meta i { font-size: 11px; color: var(--primary); }

        /* ── Badge ── */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 600; letter-spacing: 0.3px; }
        .badge-blue { background: var(--primary-light); color: var(--primary); }
        .badge-green { background: var(--green-light); color: var(--green); }
        .badge-purple { background: #F3E8FF; color: #7C3AED; }
        .badge-orange { background: #FFF7ED; color: #D97706; }
        .badge-red { background: #FEF2F2; color: #DC2626; }

        /* ── Page Header ── */
        .page-hero {
            background: linear-gradient(135deg, var(--primary-darker) 0%, var(--primary) 100%);
            color: white; padding: 70px 0 60px; position: relative; overflow: hidden;
        }
        .page-hero::before {
            content: ''; position: absolute; top: -100px; right: -50px;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
        }
        .page-hero .container { position: relative; z-index: 1; }
        .page-hero h1 { font-size: 40px; font-weight: 800; margin-bottom: 12px; letter-spacing: -0.02em; }
        .page-hero p { font-size: 17px; opacity: 0.85; max-width: 500px; }
        .breadcrumb { display: flex; gap: 8px; font-size: 13px; margin-top: 16px; opacity: 0.7; font-weight: 500; }
        .breadcrumb a:hover { opacity: 1; }

        /* ── Footer ── */
        .footer { background: var(--primary-darker); color: #94A3B8; padding: 70px 0 0; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.2fr; gap: 48px; padding-bottom: 48px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .footer h4 { color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; }
        .footer p { font-size: 14px; line-height: 1.8; }
        .footer ul { list-style: none; }
        .footer ul li { margin-bottom: 12px; }
        .footer ul a { font-size: 14px; color: #94A3B8; transition: var(--transition); }
        .footer ul a:hover { color: white; padding-left: 4px; }
        .footer-contact li { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 16px; }
        .footer-contact i { margin-top: 3px; color: var(--primary); font-size: 14px; }
        .footer-bottom { padding: 24px 0; text-align: center; font-size: 13px; }

        /* ── Forms ── */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: var(--text); }
        .form-control {
            width: 100%; padding: 12px 16px; border: 1.5px solid var(--border);
            border-radius: 10px; font-size: 14px; font-family: inherit;
            transition: var(--transition); background: white; color: var(--text);
        }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(0,102,204,0.1); }
        textarea.form-control { resize: vertical; min-height: 120px; }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394A3B8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 14px center; padding-right: 40px;
        }

        /* ── Alerts ── */
        .alert { padding: 16px 20px; border-radius: 12px; font-size: 14px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 12px; }
        .alert-success { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
        .alert-success i { color: var(--green); font-size: 18px; margin-top: 1px; }
        .alert-error { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }

        /* ── Gallery ── */
        .gallery-item {
            border-radius: var(--radius-lg); overflow: hidden; position: relative;
            cursor: pointer; aspect-ratio: 4/3; background: var(--bg-gray);
            display: flex; align-items: center; justify-content: center;
            transition: var(--transition);
        }
        .gallery-item:hover { transform: scale(1.02); box-shadow: var(--shadow-lg); }
        .gallery-item .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(0,102,204,0.9), rgba(0,51,102,0.95));
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            opacity: 0; transition: var(--transition); gap: 8px;
        }
        .gallery-item:hover .overlay { opacity: 1; }
        .gallery-item .overlay i { font-size: 28px; color: white; }
        .gallery-item .overlay span { color: white; font-weight: 600; font-size: 14px; }
        .gallery-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-muted); font-size: 13px; gap: 12px; width: 100%; height: 100%; }
        .gallery-placeholder i { font-size: 40px; opacity: 0.2; }

        /* ── CTA Banner ── */
        .cta-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-darker) 100%);
            border-radius: var(--radius-xl); padding: 60px; text-align: center;
            color: white; position: relative; overflow: hidden;
        }
        .cta-banner::before {
            content: ''; position: absolute; top: -50px; right: -50px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .cta-banner h2 { font-size: 32px; font-weight: 800; margin-bottom: 14px; }
        .cta-banner p { font-size: 16px; opacity: 0.85; margin-bottom: 28px; max-width: 500px; margin-left: auto; margin-right: auto; }

        /* ── Timeline ── */
        .timeline { position: relative; padding-left: 40px; }
        .timeline::before { content: ''; position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: var(--border); }
        .timeline-item { position: relative; margin-bottom: 32px; }
        .timeline-dot {
            position: absolute; left: -33px; top: 6px;
            width: 12px; height: 12px; border-radius: 50%;
            background: var(--primary); border: 3px solid var(--primary-light);
        }
        .timeline-dot.green { background: var(--green); border-color: var(--green-light); }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .grid-3, .grid-4 { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
            .hero h1 { font-size: 38px; }
            .section-header h2 { font-size: 28px; }
        }
        @media (max-width: 768px) {
            .nav-links, .nav-actions .btn-outline { display: none; }
            .hamburger { display: flex; }
            .hero { padding: 70px 0 60px; }
            .hero h1 { font-size: 30px; }
            .hero p { font-size: 15px; }
            .stats-row { grid-template-columns: 1fr 1fr; gap: 14px; margin-top: -36px; }
            .stat-card { padding: 20px; }
            .stat-number { font-size: 28px; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .section { padding: 60px 0; }
            .section-header { margin-bottom: 40px; }
            .page-hero { padding: 50px 0 40px; }
            .page-hero h1 { font-size: 28px; }
            .footer-grid { grid-template-columns: 1fr; gap: 32px; }
            .cta-banner { padding: 40px 24px; }
            .cta-banner h2 { font-size: 24px; }
        }
        @media (max-width: 480px) {
            .hero-actions { flex-direction: column; }
            .hero-actions .btn { width: 100%; justify-content: center; }
            .stats-row { grid-template-columns: 1fr 1fr; gap: 10px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="{{ route('public.home') }}" class="nav-brand">
                <img src="{{ asset('images/badge.png') }}" alt="SISTECH Badge" class="nav-logo" style="width: 42px; height: 42px; border-radius: 10px; object-fit: cover;">
                <div class="nav-brand-text">
                    SISTECH
                    <small>Connecting People to Technology</small>
                </div>
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('public.courses') }}" class="{{ request()->routeIs('public.courses') ? 'active' : '' }}">Courses</a></li>
                <li><a href="{{ route('public.academic') }}" class="{{ request()->routeIs('public.academic') ? 'active' : '' }}">Academic</a></li>
                <li><a href="{{ route('public.gallery') }}" class="{{ request()->routeIs('public.gallery') ? 'active' : '' }}">Gallery</a></li>
                <li><a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">Contact</a></li>
            </ul>
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login</a>
                <a href="{{ route('public.enrollment') }}" class="btn btn-primary btn-sm">Apply Now</a>
                <button class="hamburger" onclick="document.getElementById('mobileNav').classList.toggle('open')"><i class="fas fa-bars"></i></button>
            </div>
        </div>
        <div class="mobile-nav" id="mobileNav">
            <a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'active' : '' }}">About</a>
            <a href="{{ route('public.courses') }}" class="{{ request()->routeIs('public.courses') ? 'active' : '' }}">Courses</a>
            <a href="{{ route('public.academic') }}" class="{{ request()->routeIs('public.academic') ? 'active' : '' }}">Academic</a>
            <a href="{{ route('public.gallery') }}" class="{{ request()->routeIs('public.gallery') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">Contact</a>
            <a href="{{ route('public.enrollment') }}" style="color:var(--primary);font-weight:700;">Apply Now →</a>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                        <img src="{{ asset('images/badge.png') }}" alt="SISTECH Badge" style="width:40px;height:40px;border-radius:10px;object-fit:cover;">
                        <div style="color:white;font-weight:700;font-size:16px;">SISTECH</div>
                    </div>
                    <p>Slyito Institute of Science and Technology — Empowering the next generation of technology leaders in Sierra Leone.</p>
                    <div style="display:flex;gap:10px;margin-top:20px;">
                        <a href="https://www.facebook.com/share/17HwYVC5XF/" target="_blank" rel="noopener noreferrer" style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:#94A3B8;transition:var(--transition);"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/slyito5611" target="_blank" rel="noopener noreferrer" style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:#94A3B8;transition:var(--transition);"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/accounts/edit/?__pwa=1" target="_blank" rel="noopener noreferrer" style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:#94A3B8;transition:var(--transition);"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/slyitoinstituteofscienceandtechnology/" target="_blank" rel="noopener noreferrer" style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;color:#94A3B8;transition:var(--transition);"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('public.about') }}">About Us</a></li>
                        <li><a href="{{ route('public.courses') }}">Our Courses</a></li>
                        <li><a href="{{ route('public.academic') }}">Academic Calendar</a></li>
                        <li><a href="{{ route('public.enrollment') }}">Apply Now</a></li>
                        <li><a href="{{ route('public.contact') }}">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Programmes</h4>
                    <ul>
                        <li><a href="{{ route('public.courses') }}">Office Productivity</a></li>
                        <li><a href="{{ route('public.courses') }}">Information Technology</a></li>
                        <li><a href="{{ route('public.courses') }}">Nursing Programme</a></li>
                        <li><a href="{{ route('public.courses') }}">BECE Preparation</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contact Us</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> {{ $settings['institution_address'] ?? 'Freetown, Sierra Leone' }}</li>
                        <li><i class="fas fa-phone"></i> {{ $settings['institution_phone'] ?? '+232 77 893 327' }}<br><span style="margin-left: 26px;">{{ $settings['institution_phone2'] ?? '+232 34 145 006' }}</span></li>
                        <li><i class="fas fa-envelope"></i> {{ $settings['institution_email'] ?? 'sistech2025@gmail.com' }}</li>
                        <li><i class="fas fa-globe"></i> {{ $settings['institution_website'] ?? 'https://sistech.website' }}</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Slyito Institute of Science and Technology. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
        });
    </script>
    @yield('scripts')
</body>
</html>
