<!DOCTYPE html>
<html lang="en" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SISTECH CMS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎓</text></svg>">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066CC;
            --primary-dark: #004C99;
            --primary-light: #E6F0FF;
            --green: #00B050;
            --green-light: #E6F7ED;
            --white: #FFFFFF;
            --bg: #F1F5F9;
            --card-bg: #FFFFFF;
            --text: #1E293B;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --sidebar-bg: #0F172A;
            --sidebar-text: #94A3B8;
            --sidebar-active: #0066CC;
            --shadow: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
        }

        [data-theme="dark"] {
            --bg: #0F172A;
            --card-bg: #1E293B;
            --text: #F1F5F9;
            --text-muted: #94A3B8;
            --border: #334155;
            --sidebar-bg: #0B1120;
            --primary-light: #1E3A5F;
            --green-light: #1A3A2A;
        }

        * { font-family: 'Inter', sans-serif; }
        body { background: var(--bg); color: var(--text); margin: 0; }

        .sidebar {
            position: fixed; top: 0; left: 0; width: 260px; height: 100vh;
            background: var(--sidebar-bg); z-index: 1000; overflow-y: auto;
            transition: all 0.3s; border-right: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand {
            padding: 20px; display: flex; align-items: center; gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand .logo {
            width: 42px; height: 42px; background: var(--primary); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: white; font-size: 14px;
        }

        .sidebar-brand .brand-text h5 { margin: 0; color: white; font-weight: 700; font-size: 15px; }
        .sidebar-brand .brand-text small { color: var(--sidebar-text); font-size: 11px; }

        .sidebar-nav { padding: 12px 0; }

        .sidebar-nav .nav-section {
            padding: 8px 20px 4px; font-size: 10px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px; color: var(--sidebar-text);
        }

        .sidebar-nav a {
            display: flex; align-items: center; gap: 12px; padding: 10px 20px;
            color: var(--sidebar-text); text-decoration: none; font-size: 13.5px;
            font-weight: 500; transition: all 0.2s; border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover { color: white; background: rgba(255,255,255,0.05); }
        .sidebar-nav a.active {
            color: white; background: rgba(0,102,204,0.15); border-left-color: var(--primary);
        }

        .sidebar-nav a i { width: 20px; text-align: center; font-size: 15px; }

        .main-content { margin-left: 260px; min-height: 100vh; }

        .topbar {
            background: var(--card-bg); border-bottom: 1px solid var(--border);
            padding: 12px 24px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar .menu-toggle { display: none; cursor: pointer; font-size: 20px; color: var(--text); }
        .topbar .search-box { position: relative; }
        .topbar .search-box input {
            background: var(--bg); border: 1px solid var(--border); border-radius: 8px;
            padding: 8px 12px 8px 36px; width: 300px; font-size: 13px; color: var(--text);
        }
        .topbar .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }

        .topbar .user-menu { display: flex; align-items: center; gap: 16px; }
        .topbar .user-menu .notification-btn {
            position: relative; background: none; border: none; font-size: 18px;
            color: var(--text-muted); cursor: pointer;
        }
        .topbar .user-menu .notification-btn .badge {
            position: absolute; top: -5px; right: -5px; background: #EF4444; color: white;
            font-size: 10px; padding: 2px 5px; border-radius: 10px;
        }

        .topbar .user-info {
            display: flex; align-items: center; gap: 10px; cursor: pointer;
        }
        .topbar .user-info .avatar {
            width: 36px; height: 36px; border-radius: 50%; background: var(--primary);
            display: flex; align-items: center; justify-content: center; color: white;
            font-weight: 600; font-size: 14px;
        }
        .topbar .user-info .name { font-weight: 600; font-size: 13px; }
        .topbar .user-info .role { font-size: 11px; color: var(--text-muted); }

        .page-content { padding: 24px; }

        .stat-card {
            background: var(--card-bg); border-radius: 12px; padding: 20px;
            border: 1px solid var(--border); transition: all 0.2s;
        }
        .stat-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: 10px; display: flex;
            align-items: center; justify-content: center; font-size: 20px;
        }
        .stat-card .stat-value { font-size: 24px; font-weight: 700; margin: 8px 0 2px; }
        .stat-card .stat-label { font-size: 13px; color: var(--text-muted); }

        .card-sistech {
            background: var(--card-bg); border-radius: 12px; border: 1px solid var(--border);
        }
        .card-sistech .card-header {
            background: none; border-bottom: 1px solid var(--border);
            padding: 16px 20px; font-weight: 600;
        }
        .card-sistech .card-body { padding: 20px; }

        .btn-sistech { background: var(--primary); color: white; border: none; border-radius: 8px; padding: 8px 16px; font-weight: 500; }
        .btn-sistech:hover { background: var(--primary-dark); color: white; }
        .btn-sistech-green { background: var(--green); color: white; border: none; border-radius: 8px; padding: 8px 16px; font-weight: 500; }
        .btn-sistech-green:hover { background: #009944; color: white; }

        .table-sistech { border-radius: 12px; }
        .table-sistech thead th { background: var(--bg); border: none; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); padding: 12px 16px; }
        .table-sistech tbody td { padding: 12px 16px; border-top: 1px solid var(--border); font-size: 13.5px; vertical-align: middle; }

        .badge-status { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
        .badge-active { background: var(--green-light); color: var(--green); }
        .badge-inactive { background: #FEF2F2; color: #DC2626; }
        .badge-pending { background: #FEF9C3; color: #CA8A04; }
        .badge-paid { background: var(--green-light); color: var(--green); }
        .badge-unpaid { background: #FEF2F2; color: #DC2626; }
        .badge-partial { background: #FEF9C3; color: #CA8A04; }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar .menu-toggle { display: block; }
            .topbar .search-box input { width: 160px; }
        }

        .dropdown-menu { border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); }
        .dropdown-item { font-size: 13px; padding: 8px 16px; }
        .dropdown-item:hover { background: var(--bg); }
    </style>
    @yield('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('images/badge.png') }}" alt="SISTECH Badge" style="width:42px;height:42px;border-radius:10px;object-fit:cover;">
            <div class="brand-text">
                <h5>SISTECH</h5>
                <small>College Management System</small>
            </div>
        </div>
        <nav class="sidebar-nav">
            @php $role = auth()->user()->role; @endphp

            <div class="nav-section">Main</div>
            @if($role === 'student')
                <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="{{ route('student.courses') }}" class="{{ request()->routeIs('student.courses') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> My Courses
                </a>
                <a href="{{ route('student.results') }}" class="{{ request()->routeIs('student.results') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> My Results
                </a>
                <a href="{{ route('student.attendance') }}" class="{{ request()->routeIs('student.attendance') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> My Attendance
                </a>
                <a href="{{ route('student.profile') }}" class="{{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <div class="nav-section">Resources</div>
                <a href="{{ route('student.announcements') }}" class="{{ request()->routeIs('student.announcements') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
                <a href="{{ route('student.notifications') }}" class="{{ request()->routeIs('student.notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="{{ route('admin.library.index') }}" class="{{ request()->routeIs('admin.library.*') ? 'active' : '' }}">
                    <i class="fas fa-book-reader"></i> Library
                </a>
            @elseif($role === 'lecturer')
                <a href="{{ route('lecturer.dashboard') }}" class="{{ request()->routeIs('lecturer.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="{{ route('lecturer.courses') }}" class="{{ request()->routeIs('lecturer.courses') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> My Courses
                </a>
                <a href="{{ route('lecturer.attendance') }}" class="{{ request()->routeIs('lecturer.attendance*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> Attendance
                </a>
                <a href="{{ route('lecturer.results') }}" class="{{ request()->routeIs('lecturer.results*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i> Results
                </a>
                <a href="{{ route('lecturer.profile') }}" class="{{ request()->routeIs('lecturer.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <div class="nav-section">Resources</div>
                <a href="{{ route('lecturer.announcements') }}" class="{{ request()->routeIs('lecturer.announcements') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Announcements
                </a>
                <a href="{{ route('lecturer.notifications') }}" class="{{ request()->routeIs('lecturer.notifications') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="{{ route('admin.library.index') }}" class="{{ request()->routeIs('admin.library.*') ? 'active' : '' }}">
                    <i class="fas fa-book-reader"></i> Library
                </a>
            @elseif(in_array($role, ['super_admin', 'principal', 'registrar', 'accountant', 'staff']))
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            @endif

            @if(in_array($role, ['super_admin', 'principal', 'registrar', 'accountant', 'staff']))
            <div class="nav-section">Management</div>
            <a href="{{ route('admin.students.index') }}" class="{{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> Students
            </a>
            @if(in_array($role, ['super_admin', 'principal', 'registrar']))
            <a href="{{ route('admin.staff.index') }}" class="{{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Staff
            </a>
            <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Departments
            </a>
            @endif
            <a href="{{ route('admin.programmes.index') }}" class="{{ request()->routeIs('admin.programmes.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i> Programmes
            </a>
            <a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Courses
            </a>
            <a href="{{ route('admin.course-registrations.index') }}" class="{{ request()->routeIs('admin.course-registrations.*') ? 'active' : '' }}">
                <i class="fas fa-link"></i> Course Registrations
            </a>
            @endif

            @if(in_array($role, ['super_admin', 'principal', 'registrar', 'accountant', 'staff']))
            <div class="nav-section">Academic</div>
            @if(in_array($role, ['super_admin', 'principal']))
            <a href="{{ route('admin.academic.years') }}" class="{{ request()->routeIs('admin.academic.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Academic Year
            </a>
            @endif
            <a href="{{ route('admin.attendance.index') }}" class="{{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i> Attendance
            </a>
            <a href="{{ route('admin.results.index') }}" class="{{ request()->routeIs('admin.results.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Results
            </a>
            @endif

            @if(!in_array($role, ['student', 'lecturer']))
            <div class="nav-section">Resources</div>
                @if(in_array($role, ['super_admin', 'principal', 'registrar']))
            <a href="{{ route('admin.inbox.index') }}" class="{{ request()->routeIs('admin.inbox.*') ? 'active' : '' }}">
                <i class="fas fa-inbox"></i> Inbox
                @php $newEnquiries = Cache::remember('badge_new_enquiries', 60, fn() => \App\Models\Enquiry::where('status', 'new')->count()); @endphp
                @if($newEnquiries > 0)
                <span class="badge bg-danger ms-auto" style="font-size:10px;">{{ $newEnquiries }}</span>
                @endif
            </a>
            <a href="{{ route('admin.applications.index') }}" class="{{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Applications
                @php $pendingApps = Cache::remember('badge_pending_apps', 60, fn() => \App\Models\Application::where('status', 'pending')->count()); @endphp
                @if($pendingApps > 0)
                <span class="badge bg-warning ms-auto" style="font-size:10px;">{{ $pendingApps }}</span>
                @endif
            </a>
            @endif
            <a href="{{ route('admin.library.index') }}" class="{{ request()->routeIs('admin.library.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i> Library
            </a>
            @if(in_array($role, ['super_admin', 'principal', 'registrar', 'accountant']))
            <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Gallery
            </a>
            <a href="{{ route('admin.communication.announcements') }}" class="{{ request()->routeIs('admin.communication.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Announcements
            </a>
            @endif
            @if(in_array($role, ['super_admin', 'principal', 'accountant']))
            <a href="{{ route('admin.finance.index') }}" class="{{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Finance
            </a>
            @endif
            @endif

            @if(in_array($role, ['super_admin', 'principal']))
            <div class="nav-section">System</div>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
            @endif
        </nav>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <span class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i>
                </span>
                <div class="search-box d-none d-md-block">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." id="globalSearch">
                </div>
            </div>
            <div class="user-menu">
                @php $unreadNotifs = Cache::remember('badge_unread_notifs_'.auth()->id(), 60, fn() => \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count()); @endphp
                <div class="dropdown">
                    <button class="notification-btn" title="Notifications" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        @if($unreadNotifs > 0)
                        <span class="badge">{{ $unreadNotifs }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="width: 320px; max-height: 400px; overflow-y: auto;">
                        <li class="px-3 py-2 fw-bold" style="font-size: 14px;">Notifications</li>
                        <li><hr class="dropdown-divider"></li>
                        @php $recentNotifs = Cache::remember('recent_notifs_'.auth()->id(), 60, fn() => \App\Models\Notification::where('user_id', auth()->id())->latest()->take(5)->get()); @endphp
                        @forelse($recentNotifs as $notif)
                        <li>
                            <a class="dropdown-item" href="{{ $notif->link ?? '#' }}" style="white-space: normal; font-size: 13px; {{ !$notif->is_read ? 'background: var(--primary-light);' : '' }}">
                                <div class="fw-semibold" style="font-size: 13px;">{{ $notif->title ?? 'Notification' }}</div>
                                <small class="text-muted">{{ $notif->message ?? '' }}</small>
                            </a>
                        </li>
                        @empty
                        <li class="text-center text-muted py-3" style="font-size: 13px;">No notifications yet.</li>
                        @endforelse
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="@if(auth()->user()->role === 'student'){{ route('student.notifications') }}@elseif(auth()->user()->role === 'lecturer'){{ route('lecturer.notifications') }}@else{{ route('admin.communication.notifications') }}@endif" style="font-size: 13px; font-weight: 600;">View All Notifications</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <div class="user-info dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <div class="d-none d-md-block">
                            <div class="name">{{ auth()->user()->name }}</div>
                            <div class="role">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="@if(auth()->user()->role === 'student'){{ route('student.profile') }}@elseif(auth()->user()->role === 'lecturer'){{ route('lecturer.profile') }}@else{{ route('admin.dashboard') }}@endif"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        document.getElementById('globalSearch')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter' && this.value.trim()) {
                window.location.href = '{{ url("/admin/students") }}?search=' + encodeURIComponent(this.value);
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
