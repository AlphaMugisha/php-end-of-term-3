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
        .card {
            border-radius: .6rem;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .table thead th { white-space: nowrap; }

        /* =========================================================
         |  MICRO-INTERACTIONS & ENHANCEMENTS
         |=========================================================*/

        /* --- Global smoothing --- */
        a, .btn, .nav-link, .form-control, .form-select, .input-group-text, .badge {
            transition: all .2s ease;
        }

        /* --- Page entrance animation --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp .5s cubic-bezier(.2,.7,.3,1) both; }
        .main-content > * { animation: fadeInUp .45s ease both; }

        /* --- Buttons: lift + press + ripple --- */
        .btn {
            position: relative;
            overflow: hidden;
            letter-spacing: .2px;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0,0,0,.14); }
        .btn:active { transform: translateY(0); box-shadow: 0 2px 6px rgba(0,0,0,.12); }
        .btn-success:hover { box-shadow: 0 6px 16px rgba(26,107,60,.35); }
        .btn .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            background: rgba(255,255,255,.5);
            animation: ripple .6s linear;
            pointer-events: none;
        }
        @keyframes ripple { to { transform: scale(3.2); opacity: 0; } }

        /* --- Icon buttons in tables: pop on hover --- */
        td .btn-sm:hover { transform: translateY(-2px) scale(1.08); }

        /* --- Cards: hover lift --- */
        .stat-card:hover,
        .card.hoverable:hover { transform: translateY(-5px); box-shadow: 0 12px 26px rgba(0,0,0,.12); }

        /* --- Stat card icon: bounce + colour fill on hover --- */
        .stat-card .icon-box { transition: transform .25s ease, background-color .25s ease, color .25s ease; }
        .stat-card:hover .icon-box {
            background-color: var(--magerwa-green);
            color: #fff;
            transform: rotate(-8deg) scale(1.12);
        }

        /* --- Sidebar links: sliding indicator --- */
        .sidebar .nav-link {
            position: relative;
            transition: background-color .2s ease, color .2s ease, padding-left .2s ease;
        }
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            width: 4px; height: 0;
            background: var(--magerwa-green);
            transform: translateY(-50%);
            transition: height .25s ease;
            border-radius: 0 3px 3px 0;
        }
        .sidebar .nav-link:hover { padding-left: 1.6rem; }
        .sidebar .nav-link:hover::before { height: 60%; }
        .sidebar .nav-link.active::before { height: 100%; background: #fff; }
        .sidebar .nav-link i { transition: transform .2s ease; }
        .sidebar .nav-link:hover i { transform: scale(1.2); }

        /* --- Navbar brand pulse --- */
        .top-navbar .navbar-brand:hover i { animation: wiggle .4s ease; }
        @keyframes wiggle {
            0%,100% { transform: rotate(0); }
            30% { transform: rotate(-8deg); }
            60% { transform: rotate(6deg); }
        }

        /* --- Inputs: focus glow + lift --- */
        .form-control:focus, .form-select:focus {
            border-color: var(--magerwa-green);
            box-shadow: 0 0 0 .2rem rgba(26,107,60,.18);
        }
        .input-group-animated:focus-within .input-group-text {
            background-color: var(--magerwa-green);
            color: #fff;
            border-color: var(--magerwa-green);
        }
        .input-group-animated:focus-within { transform: translateY(-1px); }

        /* --- Table rows: hover slide + tint --- */
        .table-hover tbody tr { transition: background-color .15s ease, transform .15s ease, box-shadow .15s ease; }
        .table-hover tbody tr:hover {
            background-color: var(--magerwa-green-light) !important;
            transform: scale(1.004);
            box-shadow: inset 3px 0 0 var(--magerwa-green);
        }

        /* --- Badges --- */
        .badge.bg-brand:hover { transform: scale(1.08); }

        /* --- Flash messages slide in --- */
        .alert { animation: slideDown .4s ease both; border-radius: .55rem; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* --- Links underline grow --- */
        .link-underline-hover { position: relative; }
        .link-underline-hover::after {
            content: '';
            position: absolute; left: 0; bottom: -2px;
            width: 0; height: 2px; background: var(--magerwa-green);
            transition: width .25s ease;
        }
        .link-underline-hover:hover::after { width: 100%; }

        /* --- Auth screen extras --- */
        .auth-wrapper {
            background:
                radial-gradient(1200px 600px at 10% -10%, rgba(26,107,60,.12), transparent 60%),
                radial-gradient(1000px 500px at 110% 110%, rgba(26,107,60,.10), transparent 55%),
                #eef3f0;
        }
        .brand-badge {
            width: 70px; height: 70px; border-radius: 50%;
            background: linear-gradient(135deg, var(--magerwa-green), #2e9c5c);
            box-shadow: 0 8px 20px rgba(26,107,60,.35);
            animation: floaty 3.5s ease-in-out infinite;
        }
        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-7px); } }

        /* Shake (login error) */
        @keyframes shake {
            10%,90% { transform: translateX(-1px); }
            20%,80% { transform: translateX(2px); }
            30%,50%,70% { transform: translateX(-5px); }
            40%,60% { transform: translateX(5px); }
        }
        .shake { animation: shake .5s cubic-bezier(.36,.07,.19,.97) both; }

        /* Success pop (login success) */
        @keyframes successPop {
            0% { transform: scale(1); }
            40% { transform: scale(1.03); box-shadow: 0 14px 36px rgba(26,107,60,.30); }
            100% { transform: scale(1); }
        }
        .success-pop { animation: successPop .55s ease both; }

        /* Logout button hover */
        .top-navbar .btn-light:hover { transform: translateY(-2px); }

        /* Count-up numbers */
        .stat-number { font-variant-numeric: tabular-nums; }

        /* Modal entrance */
        .modal.fade .modal-dialog { transform: scale(.92) translateY(10px); transition: transform .25s ease; }
        .modal.show .modal-dialog { transform: scale(1) translateY(0); }

        /* --- Password strength meter (register) --- */
        .strength-bar {
            height: 6px;
            border-radius: 4px;
            background: #e3e6e4;
            overflow: hidden;
        }
        .strength-bar span {
            display: block;
            height: 100%;
            width: 0;
            border-radius: 4px;
            transition: width .35s ease, background-color .35s ease;
        }
        .strength-label, .match-hint {
            font-size: .8rem;
            display: inline-block;
            margin-top: .25rem;
            transition: color .25s ease;
        }

        /* --- Valid input check (green) --- */
        .form-control.is-valid {
            border-color: var(--magerwa-green);
            background-image: none;
        }

        /* --- Staggered table-row entrance --- */
        @keyframes rowIn { from { opacity: 0; transform: translateX(-12px); } to { opacity: 1; transform: translateX(0); } }
        .table tbody tr { animation: rowIn .4s ease both; }
        .table tbody tr:nth-child(1) { animation-delay: .03s; }
        .table tbody tr:nth-child(2) { animation-delay: .06s; }
        .table tbody tr:nth-child(3) { animation-delay: .09s; }
        .table tbody tr:nth-child(4) { animation-delay: .12s; }
        .table tbody tr:nth-child(5) { animation-delay: .15s; }
        .table tbody tr:nth-child(6) { animation-delay: .18s; }
        .table tbody tr:nth-child(7) { animation-delay: .21s; }
        .table tbody tr:nth-child(8) { animation-delay: .24s; }
        .table tbody tr:nth-child(n+9) { animation-delay: .27s; }

        /* --- Card header accent bar --- */
        .card-header {
            position: relative;
            border-bottom: 1px solid #eceeed;
        }
        .card-header::after {
            content: '';
            position: absolute;
            left: 0; bottom: -1px;
            width: 48px; height: 3px;
            background: var(--magerwa-green);
            border-radius: 0 3px 0 0;
            transition: width .3s ease;
        }
        .card:hover > .card-header::after { width: 100%; }

        /* --- Plate-number badge shimmer --- */
        .badge.bg-brand {
            position: relative;
            overflow: hidden;
            letter-spacing: .5px;
        }
        .badge.bg-brand::before {
            content: '';
            position: absolute;
            top: 0; left: -120%;
            width: 60%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,.55), transparent);
            transform: skewX(-20deg);
        }
        tr:hover .badge.bg-brand::before { animation: shimmer .8s ease; }
        @keyframes shimmer { to { left: 140%; } }

        /* --- Section headings: icon nudge on hover --- */
        h3 .fa-fw, h3 i { transition: transform .25s ease; }
        h3:hover > i { transform: translateY(-2px) scale(1.1); }

        /* --- Empty-state icon float --- */
        .fa-inbox { animation: floaty 3s ease-in-out infinite; }

        /* --- Description-list rows (show pages) --- */
        dl.row dt, dl.row dd { padding-block: .45rem; }
        dl.row dt { border-top: 1px solid #f0f2f1; }
        dl.row dd { border-top: 1px solid #f0f2f1; }
        dl.row dt:first-of-type, dl.row dd:first-of-type { border-top: 0; }

        /* Respect reduced-motion preference */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
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

        // Material-style ripple on every button
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn');
            if (!btn) return;
            const circle = document.createElement('span');
            const rect = btn.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            circle.className = 'ripple';
            circle.style.width = circle.style.height = size + 'px';
            circle.style.left = (e.clientX - rect.left - size / 2) + 'px';
            circle.style.top  = (e.clientY - rect.top  - size / 2) + 'px';
            btn.appendChild(circle);
            setTimeout(() => circle.remove(), 600);
        });

        // Show a spinner on the submit button of any standard (non-AJAX) form.
        // AJAX forms (login/register) handle their own loading state, so skip them.
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.id === 'loginForm' || form.id === 'registerForm') return;
            if (form.matches('[data-no-spinner]')) return;
            const btn = form.querySelector('button[type="submit"]');
            if (!btn || btn.disabled) return;
            // Preserve width so the layout doesn't jump, then swap to a spinner.
            btn.style.minWidth = btn.offsetWidth + 'px';
            btn.dataset.originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Please wait…';
            btn.disabled = true;
            // Re-enable on bfcache restore (e.g. user hits Back).
            window.addEventListener('pageshow', function () {
                if (btn.dataset.originalHtml) {
                    btn.innerHTML = btn.dataset.originalHtml;
                    btn.disabled = false;
                }
            });
        }, true);

        // Animated count-up for elements with [data-count]
        (function () {
            const els = document.querySelectorAll('[data-count]');
            if (!els.length) return;
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            els.forEach(function (el) {
                const target = parseInt(el.getAttribute('data-count'), 10) || 0;
                if (reduce || target === 0) { el.textContent = target.toLocaleString(); return; }
                const duration = 900;
                const start = performance.now();
                function tick(now) {
                    const p = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
                    el.textContent = Math.round(eased * target).toLocaleString();
                    if (p < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
