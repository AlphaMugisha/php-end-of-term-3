<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f5132">
    <title>@yield('title', 'Dashboard') — Magerwa VTMS</title>

    <!-- Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 (grid + utilities only; heavily restyled below) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        /* =========================================================
         |  DESIGN TOKENS
         |=========================================================*/
        :root {
            /* Brand (forest green) */
            --brand-50:  #ecfdf3;
            --brand-100: #d1fadf;
            --brand-200: #a6f4c5;
            --brand-400: #32b667;
            --brand-500: #1a8d4c;
            --brand:     #156c39;   /* primary */
            --brand-600: #156c39;
            --brand-700: #0f5132;
            --brand-800: #0b3b25;

            /* Neutrals (slate) */
            --bg:        #f6f7f9;
            --surface:   #ffffff;
            --surface-2: #fbfcfd;
            --border:    #e9ebef;
            --border-2:  #eef0f3;

            --text:        #161b22;
            --text-muted:  #5b6573;
            --text-subtle: #8b95a4;

            /* Accents for stat tiles */
            --c-blue:   #2f6fed;  --c-blue-bg:   #eaf1ff;
            --c-violet: #7a5af8;  --c-violet-bg: #f0ecff;
            --c-amber:  #e8910a;  --c-amber-bg:  #fdf2dd;
            --c-rose:   #e5484d;  --c-rose-bg:   #fdecec;

            /* Radius */
            --r-sm: 9px;
            --r:    13px;
            --r-lg: 18px;
            --r-pill: 999px;

            /* Shadows (layered, subtle) */
            --shadow-xs: 0 1px 2px rgba(16,24,40,.05);
            --shadow-sm: 0 1px 3px rgba(16,24,40,.07), 0 1px 2px rgba(16,24,40,.04);
            --shadow-md: 0 6px 16px -4px rgba(16,24,40,.10), 0 3px 6px -2px rgba(16,24,40,.06);
            --shadow-lg: 0 18px 40px -12px rgba(16,24,40,.18);
            --ring: 0 0 0 4px rgba(21,108,57,.14);

            /* Motion */
            --ease: cubic-bezier(.2,.7,.3,1);
            --t-fast: .15s;
            --t: .22s;
        }

        /* =========================================================
         |  BASE
         |=========================================================*/
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
            font-size: .94rem;
            letter-spacing: -0.01em;
        }
        h1,h2,h3,h4,h5,h6 { letter-spacing: -0.02em; font-weight: 700; color: var(--text); }
        .text-muted { color: var(--text-muted) !important; }
        a { color: var(--brand-600); text-decoration: none; }
        a:hover { color: var(--brand-700); }
        ::selection { background: var(--brand-100); color: var(--brand-800); }

        /* Scrollbars */
        * { scrollbar-width: thin; scrollbar-color: #d4d8de transparent; }
        *::-webkit-scrollbar { width: 9px; height: 9px; }
        *::-webkit-scrollbar-thumb { background: #d4d8de; border-radius: 99px; border: 2px solid transparent; background-clip: content-box; }
        *::-webkit-scrollbar-thumb:hover { background: #b9bfc8; background-clip: content-box; }

        /* Brand helpers */
        .text-brand { color: var(--brand-600) !important; }
        .bg-brand   { background-color: var(--brand-600) !important; }

        /* =========================================================
         |  BUTTONS
         |=========================================================*/
        .btn {
            --bs-btn-font-weight: 600;
            border-radius: var(--r-sm);
            padding: .55rem 1rem;
            font-size: .9rem;
            letter-spacing: -0.01em;
            position: relative;
            overflow: hidden;
            transition: transform var(--t-fast) var(--ease), box-shadow var(--t) var(--ease),
                        background-color var(--t) var(--ease), border-color var(--t) var(--ease), color var(--t) var(--ease);
        }
        .btn-lg { padding: .8rem 1.25rem; font-size: .98rem; border-radius: var(--r); }
        .btn-sm { padding: .4rem .6rem; font-size: .82rem; border-radius: 8px; }
        .btn i { font-size: .9em; }

        .btn-success {
            background: linear-gradient(180deg, var(--brand-500), var(--brand-600));
            border: 1px solid var(--brand-700);
            color: #fff;
            box-shadow: var(--shadow-xs), inset 0 1px 0 rgba(255,255,255,.18);
        }
        .btn-success:hover, .btn-success:focus, .btn-success:active {
            background: linear-gradient(180deg, var(--brand-600), var(--brand-700)) !important;
            border-color: var(--brand-800) !important;
            color: #fff !important;
            box-shadow: var(--shadow-md), 0 6px 18px -6px rgba(21,108,57,.55) !important;
        }
        .btn-outline-success { color: var(--brand-600); border-color: var(--border); background: var(--surface); }
        .btn-outline-success:hover { background: var(--brand-50); border-color: var(--brand-200); color: var(--brand-700); }

        .btn-secondary {
            background: var(--surface); color: var(--text); border: 1px solid var(--border);
            box-shadow: var(--shadow-xs);
        }
        .btn-secondary:hover { background: var(--surface-2); color: var(--text); border-color: #dcdfe4; }

        .btn-warning { background: #fff5e6; color: #b4690e; border: 1px solid #f7e2c0; box-shadow: var(--shadow-xs); }
        .btn-warning:hover { background: #ffedd3; color: #95560a; border-color: #f0d3a3; }
        .btn-danger { background: #fff0f0; color: #c0383c; border: 1px solid #f6d4d5; box-shadow: var(--shadow-xs); }
        .btn-danger:hover { background: #ffe2e2; color: #a52a2e; border-color: #efbfc0; }
        .btn-light { background: rgba(255,255,255,.9); border: 1px solid var(--border); color: var(--text); }

        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn:focus-visible { outline: none; box-shadow: var(--ring); }

        /* Ripple */
        .btn .ripple {
            position: absolute; border-radius: 50%; transform: scale(0);
            background: rgba(255,255,255,.45); animation: ripple .6s linear; pointer-events: none;
        }
        @keyframes ripple { to { transform: scale(3.2); opacity: 0; } }

        /* =========================================================
         |  TOP NAVBAR
         |=========================================================*/
        .top-navbar {
            background: rgba(255,255,255,.8);
            backdrop-filter: saturate(180%) blur(14px);
            -webkit-backdrop-filter: saturate(180%) blur(14px);
            height: 62px;
            border-bottom: 1px solid var(--border);
            z-index: 1030;
        }
        .top-navbar .navbar-brand {
            color: var(--text) !important; font-weight: 800; font-size: 1.05rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .brand-mark {
            width: 34px; height: 34px; border-radius: 10px;
            display: grid; place-items: center; color: #fff; font-size: .95rem;
            background: linear-gradient(140deg, var(--brand-500), var(--brand-700));
            box-shadow: var(--shadow-sm), inset 0 1px 0 rgba(255,255,255,.25);
        }
        .top-navbar .navbar-text { color: var(--text-muted) !important; }
        .nav-user {
            display: flex; align-items: center; gap: .55rem;
            padding: .3rem .65rem .3rem .35rem; border-radius: var(--r-pill);
            border: 1px solid var(--border); background: var(--surface);
        }
        .nav-avatar {
            width: 30px; height: 30px; border-radius: 50%; flex: 0 0 auto;
            display: grid; place-items: center; color: #fff; font-weight: 700; font-size: .8rem;
            background: linear-gradient(140deg, var(--brand-400), var(--brand-700));
        }

        /* =========================================================
         |  SIDEBAR
         |=========================================================*/
        .sidebar {
            position: fixed; top: 62px; left: 0; bottom: 0; width: 248px;
            background: var(--surface); border-right: 1px solid var(--border);
            padding: 1.1rem .75rem; overflow-y: auto;
            transition: transform var(--t) var(--ease); z-index: 1020;
        }
        .sidebar .nav-section {
            font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
            color: var(--text-subtle); padding: .4rem .85rem; margin-top: .25rem;
        }
        .sidebar .nav-link {
            color: var(--text-muted); padding: .62rem .85rem; border-radius: var(--r-sm);
            display: flex; align-items: center; gap: .8rem; font-weight: 600; font-size: .9rem;
            margin-bottom: 2px; position: relative;
            transition: background-color var(--t) var(--ease), color var(--t) var(--ease), transform var(--t-fast) var(--ease);
        }
        .sidebar .nav-link i { width: 20px; text-align: center; font-size: .98rem; color: var(--text-subtle); transition: color var(--t) var(--ease), transform var(--t) var(--ease); }
        .sidebar .nav-link:hover { background: var(--surface-2); color: var(--text); }
        .sidebar .nav-link:hover i { color: var(--brand-600); transform: scale(1.1); }
        .sidebar .nav-link.active {
            background: var(--brand-50); color: var(--brand-700);
            box-shadow: inset 0 0 0 1px var(--brand-100);
        }
        .sidebar .nav-link.active i { color: var(--brand-600); }
        .sidebar .nav-link.active::before {
            content: ''; position: absolute; left: -.75rem; top: 50%; transform: translateY(-50%);
            width: 3px; height: 60%; background: var(--brand-600); border-radius: 0 3px 3px 0;
        }
        .sidebar .nav-link .nav-chevron { margin-left: auto; opacity: 0; transform: translateX(-4px); transition: all var(--t) var(--ease); font-size: .7rem; }
        .sidebar .nav-link:hover .nav-chevron, .sidebar .nav-link.active .nav-chevron { opacity: 1; transform: translateX(0); }

        .sidebar-footer {
            margin-top: 1rem; padding: .85rem; border-radius: var(--r); background: var(--surface-2);
            border: 1px solid var(--border); font-size: .8rem; color: var(--text-muted);
        }

        /* =========================================================
         |  LAYOUT
         |=========================================================*/
        .main-content {
            margin-top: 62px; margin-left: 248px; padding: 1.85rem 2rem 3rem;
            transition: margin-left var(--t) var(--ease);
            max-width: 1320px;
        }
        .sidebar-backdrop { position: fixed; inset: 62px 0 0 0; background: rgba(16,24,40,.4); z-index: 1015; display: none; backdrop-filter: blur(2px); }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); box-shadow: var(--shadow-lg); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 1.25rem 1.1rem 3rem; }
            .sidebar-backdrop.show { display: block; }
        }

        /* Page header pattern */
        .page-header { margin-bottom: 1.5rem; }
        .page-header h3 { font-size: 1.5rem; font-weight: 800; margin: 0; }
        .page-header .sub { color: var(--text-muted); font-size: .9rem; margin-top: .15rem; }
        .breadcrumb-mini { font-size: .78rem; color: var(--text-subtle); font-weight: 600; margin-bottom: .35rem; display: flex; align-items: center; gap: .4rem; }
        .breadcrumb-mini a { color: var(--text-subtle); } .breadcrumb-mini a:hover { color: var(--brand-600); }

        /* =========================================================
         |  CARDS
         |=========================================================*/
        .card {
            background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg);
            box-shadow: var(--shadow-sm);
            transition: transform var(--t) var(--ease), box-shadow var(--t) var(--ease), border-color var(--t) var(--ease);
        }
        .card-body { padding: 1.4rem 1.5rem; }
        .card-header {
            background: transparent; border-bottom: 1px solid var(--border);
            padding: 1.05rem 1.5rem; font-weight: 700; border-radius: var(--r-lg) var(--r-lg) 0 0;
        }
        .card.hoverable:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: #dfe2e7; }

        /* Stat cards */
        .stat-card { border-radius: var(--r-lg); overflow: hidden; }
        .stat-card .card-body { display: flex; align-items: flex-start; gap: 1rem; padding: 1.35rem 1.4rem; }
        .stat-card .icon-box {
            width: 46px; height: 46px; border-radius: 12px; flex: 0 0 auto;
            display: grid; place-items: center; font-size: 1.15rem;
            transition: transform var(--t) var(--ease);
        }
        .stat-card:hover .icon-box { transform: scale(1.08) rotate(-4deg); }
        .stat-card .stat-label { font-size: .78rem; font-weight: 600; color: var(--text-muted); text-transform: none; letter-spacing: 0; }
        .stat-card .stat-number { font-size: 1.9rem; font-weight: 800; line-height: 1.1; font-variant-numeric: tabular-nums; letter-spacing: -.03em; }
        .stat-card .stat-trend { font-size: .76rem; font-weight: 600; display: inline-flex; align-items: center; gap: .3rem; margin-top: .35rem; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .tile-blue   .icon-box { background: var(--c-blue-bg);   color: var(--c-blue); }
        .tile-violet .icon-box { background: var(--c-violet-bg); color: var(--c-violet); }
        .tile-amber  .icon-box { background: var(--c-amber-bg);  color: var(--c-amber); }
        .tile-green  .icon-box { background: var(--brand-50);    color: var(--brand-600); }
        .stat-card .accent { position: absolute; inset: 0 auto 0 0; width: 3px; border-radius: 3px; }

        /* =========================================================
         |  FORMS
         |=========================================================*/
        .form-label { font-weight: 600; font-size: .85rem; color: var(--text); margin-bottom: .4rem; }
        .form-control, .form-select {
            border: 1px solid var(--border); border-radius: var(--r-sm); padding: .62rem .8rem;
            font-size: .92rem; background-color: var(--surface); color: var(--text);
            transition: border-color var(--t) var(--ease), box-shadow var(--t) var(--ease), background-color var(--t) var(--ease);
        }
        .form-control::placeholder { color: var(--text-subtle); }
        .form-control:hover, .form-select:hover { border-color: #d6dae0; }
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-400); box-shadow: var(--ring); background-color: #fff;
        }
        .form-control.is-invalid, .was-validated .form-control:invalid { border-color: var(--c-rose); }
        .form-control.is-invalid:focus { box-shadow: 0 0 0 4px rgba(229,72,77,.14); }
        .form-control.is-valid { border-color: var(--brand-400); background-image: none; }
        .invalid-feedback { font-size: .8rem; font-weight: 500; }

        .input-group-text { background: var(--surface-2); border: 1px solid var(--border); color: var(--text-subtle); border-radius: var(--r-sm); }
        .input-group .form-control { border-radius: 0; }
        .input-group > :first-child { border-top-left-radius: var(--r-sm); border-bottom-left-radius: var(--r-sm); }
        .input-group > :last-child { border-top-right-radius: var(--r-sm); border-bottom-right-radius: var(--r-sm); }
        .input-group-animated { transition: transform var(--t) var(--ease); border-radius: var(--r-sm); }
        .input-group-animated:focus-within { transform: translateY(-1px); }
        .input-group-animated:focus-within .input-group-text { background: var(--brand-50); color: var(--brand-600); border-color: var(--brand-200); }
        .input-group-animated:focus-within .form-control { border-color: var(--brand-400); }

        .form-check-input { border-color: #cfd4db; }
        .form-check-input:checked { background-color: var(--brand-600); border-color: var(--brand-600); }
        .form-check-input:focus { box-shadow: var(--ring); border-color: var(--brand-400); }

        .form-section-title { font-size: .78rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: var(--text-subtle); margin: .25rem 0 1rem; padding-bottom: .6rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: .5rem; }

        /* =========================================================
         |  TABLES
         |=========================================================*/
        .table { color: var(--text); margin: 0; --bs-table-bg: transparent; }
        .table thead th {
            font-size: .72rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
            color: var(--text-subtle); background: var(--surface-2); border-bottom: 1px solid var(--border);
            padding: .75rem 1rem; white-space: nowrap;
        }
        .table tbody td { padding: .85rem 1rem; border-bottom: 1px solid var(--border-2); vertical-align: middle; font-size: .9rem; }
        .table tbody tr:last-child td { border-bottom: 0; }
        .table-striped > tbody > tr:nth-of-type(odd) > * { --bs-table-accent-bg: transparent; background: transparent; }
        .table-hover tbody tr { transition: background-color var(--t-fast) var(--ease); }
        .table-hover tbody tr:hover { background: var(--brand-50) !important; box-shadow: inset 3px 0 0 var(--brand-500); }
        .card > .card-body > .table-responsive { border-radius: var(--r); overflow: hidden; }
        td .btn-sm { transition: transform var(--t-fast) var(--ease); }
        td .btn-sm:hover { transform: translateY(-2px); }
        .table-actions { display: inline-flex; gap: .35rem; }

        /* Avatar cell */
        .cell-avatar {
            width: 36px; height: 36px; border-radius: 10px; flex: 0 0 auto;
            display: grid; place-items: center; font-weight: 700; font-size: .82rem; color: #fff;
            background: linear-gradient(140deg, var(--brand-400), var(--brand-700));
        }
        .cell-name { display: flex; align-items: center; gap: .7rem; }
        .cell-sub { font-size: .78rem; color: var(--text-subtle); font-weight: 500; }

        /* =========================================================
         |  BADGES
         |=========================================================*/
        .badge { font-weight: 600; font-size: .74rem; padding: .4em .7em; border-radius: var(--r-pill); letter-spacing: .01em; }
        .badge.bg-brand { background: var(--brand-50) !important; color: var(--brand-700) !important; border: 1px solid var(--brand-100); position: relative; overflow: hidden; }
        .badge-plate { font-family: 'Inter'; font-weight: 700; letter-spacing: .06em; }
        .badge.bg-brand::before {
            content: ''; position: absolute; top: 0; left: -120%; width: 55%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(21,108,57,.18), transparent); transform: skewX(-20deg);
        }
        tr:hover .badge.bg-brand::before { animation: shimmer .8s ease; }
        @keyframes shimmer { to { left: 150%; } }

        /* =========================================================
         |  ALERTS / TOASTS
         |=========================================================*/
        .alert {
            border-radius: var(--r); border: 1px solid transparent; font-size: .9rem; font-weight: 500;
            padding: .85rem 1.1rem; box-shadow: var(--shadow-sm); display: flex; align-items: center;
        }
        .alert-success { background: var(--brand-50); color: var(--brand-800); border-color: var(--brand-100); }
        .alert-danger  { background: #fdecec; color: #99181d; border-color: #f7d4d5; }
        .alert-info    { background: var(--c-blue-bg); color: #1c4fd0; border-color: #d3e2ff; }
        .alert-warning { background: #fdf6e3; color: #91560a; border-color: #f5e4bc; }
        .alert-link { font-weight: 700; }

        /* Floating flash container */
        .flash-stack { position: fixed; top: 78px; right: 22px; z-index: 1080; width: min(380px, calc(100vw - 36px)); display: flex; flex-direction: column; gap: .6rem; }
        .flash-stack .alert { box-shadow: var(--shadow-lg); }

        /* =========================================================
         |  MODALS
         |=========================================================*/
        .modal-content { border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--shadow-lg); }
        .modal-header { border-bottom: 1px solid var(--border); padding: 1.15rem 1.4rem; }
        .modal-title { font-weight: 700; font-size: 1.05rem; }
        .modal-body { padding: 1.25rem 1.4rem; color: var(--text-muted); }
        .modal-footer { border-top: 1px solid var(--border); padding: 1rem 1.4rem; }
        .modal.fade .modal-dialog { transform: scale(.94) translateY(12px); transition: transform var(--t) var(--ease); }
        .modal.show .modal-dialog { transform: scale(1) translateY(0); }
        .modal-icon { width: 48px; height: 48px; border-radius: 50%; display: grid; place-items: center; font-size: 1.2rem; flex: 0 0 auto; }

        /* =========================================================
         |  PAGINATION
         |=========================================================*/
        .pagination { gap: .3rem; }
        .page-link { border: 1px solid var(--border); border-radius: var(--r-sm) !important; color: var(--text-muted); font-weight: 600; font-size: .86rem; padding: .45rem .8rem; }
        .page-link:hover { background: var(--surface-2); color: var(--brand-700); border-color: #dadde2; }
        .page-item.active .page-link { background: var(--brand-600); border-color: var(--brand-600); color: #fff; box-shadow: var(--shadow-xs); }
        .page-item.disabled .page-link { color: var(--text-subtle); background: var(--surface); }

        /* =========================================================
         |  MICRO-INTERACTIONS / MOTION
         |=========================================================*/
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp .5s var(--ease) both; }
        .main-content > * { animation: fadeInUp .42s var(--ease) both; }
        .main-content > *:nth-child(2) { animation-delay: .04s; }
        .main-content > *:nth-child(3) { animation-delay: .08s; }

        @keyframes rowIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        .table tbody tr { animation: rowIn .4s var(--ease) both; }
        .table tbody tr:nth-child(1){animation-delay:.02s}.table tbody tr:nth-child(2){animation-delay:.05s}
        .table tbody tr:nth-child(3){animation-delay:.08s}.table tbody tr:nth-child(4){animation-delay:.11s}
        .table tbody tr:nth-child(5){animation-delay:.14s}.table tbody tr:nth-child(6){animation-delay:.17s}
        .table tbody tr:nth-child(7){animation-delay:.20s}.table tbody tr:nth-child(n+8){animation-delay:.23s}

        .link-underline-hover { position: relative; }
        .link-underline-hover::after { content: ''; position: absolute; left: 0; bottom: -2px; width: 0; height: 2px; background: var(--brand-600); transition: width var(--t) var(--ease); }
        .link-underline-hover:hover::after { width: 100%; }

        /* Empty state */
        .empty-state { text-align: center; padding: 3rem 1rem; }
        .empty-state .empty-icon { width: 68px; height: 68px; border-radius: 18px; background: var(--surface-2); border: 1px solid var(--border); display: grid; place-items: center; margin: 0 auto 1rem; font-size: 1.6rem; color: var(--text-subtle); animation: floaty 3.5s ease-in-out infinite; }
        .empty-state h6 { font-weight: 700; margin-bottom: .35rem; }
        .empty-state p { color: var(--text-muted); font-size: .88rem; margin-bottom: 1.1rem; }

        /* =========================================================
         |  AUTH SCREENS
         |=========================================================*/
        .auth-wrapper {
            min-height: 100vh;
            background:
                radial-gradient(1100px 560px at 8% -8%, rgba(21,108,57,.14), transparent 55%),
                radial-gradient(900px 500px at 108% 112%, rgba(50,182,103,.13), transparent 52%),
                linear-gradient(180deg, #f3f6f4, #eef2f0);
        }
        .auth-card { border-radius: 22px !important; box-shadow: var(--shadow-lg) !important; border: 1px solid rgba(255,255,255,.7) !important; background: rgba(255,255,255,.92); backdrop-filter: blur(6px); }
        .brand-badge {
            width: 64px; height: 64px; border-radius: 18px;
            background: linear-gradient(140deg, var(--brand-400), var(--brand-700));
            box-shadow: var(--shadow-md), inset 0 1px 0 rgba(255,255,255,.3);
            animation: floaty 3.6s ease-in-out infinite;
        }
        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-7px); } }
        .toggle-password { border: 1px solid var(--border) !important; border-left: 0 !important; color: var(--text-subtle) !important; background: var(--surface-2) !important; }
        .toggle-password:hover { color: var(--brand-600) !important; }

        @keyframes shake { 10%,90%{transform:translateX(-1px)} 20%,80%{transform:translateX(2px)} 30%,50%,70%{transform:translateX(-5px)} 40%,60%{transform:translateX(5px)} }
        .shake { animation: shake .5s cubic-bezier(.36,.07,.19,.97) both; }
        @keyframes successPop { 0%{transform:scale(1)} 40%{transform:scale(1.02); box-shadow: var(--shadow-lg)} 100%{transform:scale(1)} }
        .success-pop { animation: successPop .55s var(--ease) both; }

        /* Password strength meter */
        .strength-bar { height: 6px; border-radius: 99px; background: var(--border); overflow: hidden; }
        .strength-bar span { display: block; height: 100%; width: 0; border-radius: 99px; transition: width .35s var(--ease), background-color .35s var(--ease); }
        .strength-label, .match-hint { font-size: .78rem; font-weight: 600; display: inline-block; margin-top: .3rem; transition: color var(--t) var(--ease); }

        /* =========================================================
         |  PRELOADER
         |=========================================================*/
        #preloader {
            position: fixed; inset: 0; z-index: 2000;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg);
            transition: opacity .4s var(--ease), visibility .4s var(--ease);
        }
        #preloader.is-hidden { opacity: 0; visibility: hidden; }
        #preloader .preloader-spinner {
            width: 52px; height: 52px; border-radius: 50%;
            border: 4px solid var(--brand-100);
            border-top-color: var(--brand-600);
            animation: preloader-spin .8s linear infinite;
        }
        @keyframes preloader-spin { to { transform: rotate(360deg); } }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    </style>
</head>
<body>

    <!-- Spinner preloader (shows for 3 seconds on page load) -->
    <div id="preloader" aria-hidden="true">
        <div class="preloader-spinner" role="status"><span class="visually-hidden">Loading…</span></div>
    </div>

    @auth
    <!-- Top navbar -->
    <nav class="navbar fixed-top top-navbar px-3 px-lg-4">
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-dark d-lg-none me-2 p-1" id="sidebarToggle" type="button" aria-label="Toggle menu">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <a class="navbar-brand mb-0" href="{{ route('dashboard') }}">
                <span class="brand-mark"><i class="fas fa-truck-fast"></i></span>
                Magerwa <span class="d-none d-sm-inline">VTMS</span>
            </a>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="nav-user">
                <span class="nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                <span class="d-none d-sm-inline" style="line-height:1.1">
                    <span class="d-block fw-semibold" style="font-size:.84rem;color:var(--text)">{{ Auth::user()->name }}</span>
                    <span class="d-block" style="font-size:.72rem;color:var(--text-subtle)">Administrator</span>
                </span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0" data-no-spinner>
                @csrf
                <button type="submit" class="btn btn-light btn-sm" title="Sign out">
                    <i class="fas fa-arrow-right-from-bracket"></i><span class="d-none d-md-inline ms-1">Sign out</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="nav-section">Menu</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-grip"></i> Dashboard <i class="fas fa-chevron-right nav-chevron"></i>
            </a>
            <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                <i class="fas fa-users"></i> Clients <i class="fas fa-chevron-right nav-chevron"></i>
            </a>
            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                <i class="fas fa-car-side"></i> Vehicles <i class="fas fa-chevron-right nav-chevron"></i>
            </a>
            <a class="nav-link {{ request()->routeIs('linkages.*') ? 'active' : '' }}" href="{{ route('linkages.index') }}">
                <i class="fas fa-link"></i> Linkage <i class="fas fa-chevron-right nav-chevron"></i>
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="fw-semibold text-dark mb-1"><i class="fas fa-shield-halved text-brand me-1"></i> Secure session</div>
            Vehicle Tracking Management System
        </div>
    </aside>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    @endauth

    <main class="{{ auth()->check() ? 'main-content' : '' }}">
        @auth
            <div class="flash-stack">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                        <i class="fas fa-circle-check me-2"></i> <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i> <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if ($errors->any() && ! request()->routeIs('login', 'register'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i> <span>Please correct the highlighted fields below.</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        @endauth

        @yield('content')
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hide the spinner preloader after 3 seconds
        (function () {
            const preloader = document.getElementById('preloader');
            if (!preloader) return;
            setTimeout(function () { preloader.classList.add('is-hidden'); }, 3000);
        })();

        // Sidebar toggle (mobile / tablet)
        (function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (toggle) toggle.addEventListener('click', () => { sidebar.classList.toggle('show'); backdrop.classList.toggle('show'); });
            if (backdrop) backdrop.addEventListener('click', () => { sidebar.classList.remove('show'); backdrop.classList.remove('show'); });
        })();

        // Auto-dismiss flash messages
        setTimeout(function () {
            document.querySelectorAll('.auto-dismiss').forEach(function (el) {
                bootstrap.Alert.getOrCreateInstance(el).close();
            });
        }, 4500);

        // Material-style ripple on buttons
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn');
            if (!btn || btn.classList.contains('btn-link')) return;
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

        // Global submit spinner for standard (non-AJAX) forms
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.id === 'loginForm' || form.id === 'registerForm') return;
            if (form.matches('[data-no-spinner]')) return;
            const btn = form.querySelector('button[type="submit"]');
            if (!btn || btn.disabled) return;
            btn.style.minWidth = btn.offsetWidth + 'px';
            btn.dataset.originalHtml = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Please wait…';
            btn.disabled = true;
            window.addEventListener('pageshow', function () {
                if (btn.dataset.originalHtml) { btn.innerHTML = btn.dataset.originalHtml; btn.disabled = false; }
            });
        }, true);

        // Animated count-up for [data-count]
        (function () {
            const els = document.querySelectorAll('[data-count]');
            if (!els.length) return;
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            els.forEach(function (el) {
                const target = parseInt(el.getAttribute('data-count'), 10) || 0;
                if (reduce || target === 0) { el.textContent = target.toLocaleString(); return; }
                const duration = 1000, start = performance.now();
                function tick(now) {
                    const p = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - p, 3);
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
