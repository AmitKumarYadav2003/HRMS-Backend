<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HRMS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
        }
        :root {
    --sb-top: #0B2540;
    --sb-bottom: #1B4F72;
    --primary: #2E86DE;
    --accent: #F2994A;
}
body { font-family: 'Inter', sans-serif; }

.sidebar {
    width: 260px;
    min-height: 100vh;
    position: sticky;
    top: 0;
    display: flex;
    flex-direction: column;
    padding: 22px 14px;
    background: linear-gradient(180deg, var(--sb-top) 0%, var(--sb-bottom) 100%);
    color: #fff;
    box-shadow: 4px 0 20px rgba(11, 37, 64, 0.15);
}
.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 4px 10px 22px;
    margin-bottom: 8px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
.brand-logo {
    width: 40px; height: 40px;
    border-radius: 14px;
    background: linear-gradient(135deg, #d99c67, #ea9c73);
    display: grid; place-items: center;
    font-family: 'Poppins', sans-serif;
    font-weight: 800; font-size: 14px;
    box-shadow: 0 4px 12px rgba(242, 152, 74, 0.29);
}
.brand-name { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 15.5px; }
.brand-sub { font-size: 11px; color: rgba(255, 255, 255, 0.55); }

.nav-section {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: rgba(255, 255, 255, 0.45);
    padding: 18px 12px 8px;
}
.nav-item {
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 9px 12px;
    margin: 3px 0;
    border: none;
    border-radius: 10px;
    background: transparent;
    color: rgba(255, 255, 255, 0.78);
    text-decoration: none;
    text-align: left;
    font-size: 13.5px;
    font-weight: 500;
    transition: all 0.2s ease;
}
.nav-icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    display: grid; place-items: center;
    background: rgba(255, 255, 255, 0.07);
    font-size: 15px;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.nav-item:hover { background: rgba(255, 255, 255, 0.08); color: #fff; }
.nav-item:hover .nav-icon { background: rgba(255, 255, 255, 0.14); }
.nav-item.active { background: rgba(46, 134, 222, 0.25); color: #fff; font-weight: 600; }
.nav-item.active .nav-icon {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 4px 10px rgba(46, 134, 222, 0.4);
}
.nav-item.active::before {
    content: '';
    position: absolute;
    left: -14px; top: 20%; bottom: 20%;
    width: 4px;
    border-radius: 0 4px 4px 0;
    background: var(--accent);
}
.nav-item.disabled { opacity: 0.4; pointer-events: none; }
.soon {
    margin-left: auto;
    font-size: 9.5px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
    background: rgba(242, 153, 74, 0.18);
    color: #F9B97A;
}

.user-card {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.07);
}
.avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #fff;
    color: var(--sb-bottom);
    display: grid; place-items: center;
    font-family: 'Poppins', sans-serif;
    font-weight: 700; font-size: 13px;
    flex-shrink: 0;
}
.user-name { font-size: 13px; font-weight: 600; line-height: 1.2; }
.user-role { font-size: 11px; color: rgba(255, 255, 255, 0.55); }

.logout-btn { color: #FCA5A5; }
.logout-btn .nav-icon { background: rgba(239, 68, 68, 0.15); color: #FCA5A5; }
.logout-btn:hover { background: rgba(239, 68, 68, 0.12); color: #fff; }
        .navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .content {
            padding: 30px;
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #2E86DE;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1B4F72;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
    <div class="brand">
        <div class="brand-logo">HR</div>
        <div>
            <div class="brand-name">HRMS Admin</div>
            <div class="brand-sub">Management Console</div>
        </div>
    </div>

    <nav>
        <div class="nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item @if(request()->routeIs('admin.dashboard')) active @endif">
            <span class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></span> Dashboard
        </a>

        <div class="nav-section">People</div>
        <a href="{{ route('admin.employees.index') }}" class="nav-item @if(request()->routeIs('admin.employees*')) active @endif">
            <span class="nav-icon"><i class="bi bi-people-fill"></i></span> Employees
        </a>
        <a href="{{ route('admin.leaves.index') }}" class="nav-item @if(request()->routeIs('admin.leaves*')) active @endif">
            <span class="nav-icon"><i class="bi bi-calendar2-check-fill"></i></span> Leave Management
        </a>

        <div class="nav-section">Communication</div>
        <a href="{{ route('admin.announcements.index') }}" class="nav-item @if(request()->routeIs('admin.announcements*')) active @endif">
            <span class="nav-icon"><i class="bi bi-megaphone-fill"></i></span> Announcements
        </a>

        <!-- <div class="nav-section">Coming soon</div> -->
        <a href="{{ route('admin.holidays.index') }}" class="nav-item @if(request()->routeIs('admin.holidays*')) active @endif">
    <span class="nav-icon"><i class="bi bi-calendar-event-fill"></i></span> Holidays
</a>
        <a href="{{ route('admin.payroll.index') }}" class="nav-item @if(request()->routeIs('admin.payroll*')) active @endif">
    <span class="nav-icon"><i class="bi bi-cash-coin"></i></span> Payroll
</a>
    </nav>

    <div class="user-card">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
            <div class="user-name">{{ auth()->user()->name }}</div>
            <div class="user-role">Administrator</div>
        </div>
    </div>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-item logout-btn">
            <span class="nav-icon"><i class="bi bi-box-arrow-left"></i></span> Logout
        </button>
    </form>
</div>

        <!-- Main Content -->
        <div style="flex: 1;">
            <!-- Top Navbar -->
            <nav class="navbar navbar-light">
                <div class="container-fluid">
                    <span class="navbar-text">Welcome, {{ auth()->user()->name }}</span>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>