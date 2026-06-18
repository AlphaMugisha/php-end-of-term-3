<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Magerwa VTMS</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --magerwa-green: #1a6b3c;
            --magerwa-green-dark: #145430;
            --magerwa-green-light: #e7f2ec;
        }

        body {
            background-color: #f5f7f6;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Brand green mapping */
        .text-brand { color: var(--magerwa-green) !important; }
        .bg-brand { background-color: var(--magerwa-green) !important; }

        .btn-success {
            background-color: var(--magerwa-green);
            border-color: var(--magerwa-green);
        }
        .btn-success:hover,
        .btn-success:focus,
        .btn-success:active {
            background-color: var(--magerwa-green-dark) !important;
            border-color: var(--magerwa-green-dark) !important;
        }
        .btn-outline-success {
            color: var(--magerwa-green);
            border-color: var(--magerwa-green);
        }
        .btn-outline-success:hover {
            background-color: var(--magerwa-green);
            border-color: var(--magerwa-green);
        }

        /* Top navbar */
        .top-navbar {
            background-color: var(--magerwa-green);
            height: 60px;
            z-index: 1030;
        }
        .top-navbar .navbar-brand,
        .top-navbar .nav-link,
        .top-navbar .navbar-text {
            color: #fff !important;
        }
        .top-navbar .navbar-brand i { margin-right: .4rem; }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            bottom: 0;
            width: 230px;
            background-color: #fff;
            border-right: 1px solid #e3e6e4;
            padding-top: 1rem;
            overflow-y: auto;
            transition: transform .25s ease;
            z-index: 1020;
        }
        .sidebar .nav-link {
            color: #444;
            padding: .7rem 1.3rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .7rem;
            font-weight: 500;
        }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .sidebar .nav-link:hover {
            background-color: var(--magerwa-green-light);
            color: var(--magerwa-green);
        }
        .sidebar .nav-link.active {
            background-color: var(--magerwa-green);
            color: #fff;
        }

        /* Main content */
        .main-content {
            margin-top: 60px;
            margin-left: 230px;
            padding: 1.5rem;
            transition: margin-left .25s ease;
        }

        /* Sidebar backdrop for mobile */
        .sidebar-backdrop {
            position: fixed;
            inset: 60px 0 0 0;
            background: rgba(0,0,0,.4);
            z-index: 1015;
            display: none;
        }

        /* Tablet: collapsible sidebar */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 20px rgba(0,0,0,.15);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-backdrop.show { display: block; }
        }

        .stat-card {
            border: none;
            border-radius: .75rem;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
        .stat-card .icon-box {
            width: 56px; height: 56px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            background-color: var(--magerwa-green-light);
            color: var(--magerwa-green);
        }
        .card { border-radius: .6rem; }
        .table thead th { white-space: nowrap; }
    </style>
</head>
<body>

    @auth
    <!-- Top navbar -->
    <nav class="navbar fixed-top top-navbar px-3">
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-white d-lg-none me-2 p-0" id="sidebarToggle" type="button">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <a class="navbar-brand fw-bold mb-0" href="{{ route('dashboard') }}">
                <i class="fas fa-truck-moving"></i> Magerwa VTMS
            </a>
        </div>
        <div class="d-flex align-items-center">
            <span class="navbar-text me-3 d-none d-sm-inline">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-gauge-high"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                <i class="fas fa-users"></i> Clients
            </a>
            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                <i class="fas fa-car"></i> Vehicles
            </a>
            <a class="nav-link {{ request()->routeIs('linkages.*') ? 'active' : '' }}" href="{{ route('linkages.index') }}">
                <i class="fas fa-link"></i> Linkage
            </a>
        </nav>
    </aside>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    @endauth

    <main class="{{ auth()->check() ? 'main-content' : '' }}">
        @auth
            <!-- Flash messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                    <i class="fas fa-circle-check me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                    <i class="fas fa-circle-exclamation me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any() && ! request()->routeIs('login', 'register'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-circle-exclamation me-1"></i> Please correct the errors below.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endauth

        @yield('content')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle (mobile / tablet)
        (function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (toggle) {
                toggle.addEventListener('click', function () {
                    sidebar.classList.toggle('show');
                    backdrop.classList.toggle('show');
                });
            }
            if (backdrop) {
                backdrop.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                });
            }
        })();

        // Auto-dismiss flash messages after 4 seconds
        setTimeout(function () {
            document.querySelectorAll('.auto-dismiss').forEach(function (el) {
                const alert = bootstrap.Alert.getOrCreateInstance(el);
                alert.close();
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
