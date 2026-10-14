<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HRMS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
        }
        .sidebar {
            background: linear-gradient(135deg, #2E86DE 0%, #1B4F72 100%);
            min-height: 100vh;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
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
        <div class="sidebar" style="width: 250px;">
            <h4 class="mb-30">HRMS Admin</h4>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) active @endif">📊 Dashboard</a>
                <a href="{{ route('admin.leaves.index') }}" class="@if(request()->routeIs('admin.leaves.*')) active @endif">📅 Leave Management</a>
               
                <hr style="border-color: rgba(255,255,255,0.2);">
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <!-- <button type="submit" class="btn btn-link text-white w-100 text-start" style="padding: 12px 16px;">🚪 Logout</button> -->
                </form>
            </nav>
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