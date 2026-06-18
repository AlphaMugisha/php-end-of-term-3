@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
        <div class="breadcrumb-mini"><i class="fas fa-grip"></i> Overview</div>
        <h3>Welcome back, {{ explode(' ', Auth::user()->name)[0] }} 👋</h3>
        <p class="sub mb-0">Here's what's happening across Magerwa vehicle &amp; client records.</p>
    </div>
    <a href="{{ route('linkages.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> New Linkage
    </a>
</div>

<div class="row g-3 g-lg-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100 position-relative">
            <span class="accent" style="background:var(--brand-500)"></span>
            <div class="card-body">
                <div class="icon-box tile-green"><i class="fas fa-user-shield"></i></div>
                <div>
                    <div class="stat-label">Total Admins</div>
                    <div class="stat-number" data-count="{{ $totalAdmins }}">0</div>
                    <div class="stat-trend text-brand"><i class="fas fa-user-check"></i> System accounts</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100 position-relative">
            <span class="accent" style="background:var(--c-blue)"></span>
            <div class="card-body">
                <div class="icon-box tile-blue"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-label">Total Clients</div>
                    <div class="stat-number" data-count="{{ $totalClients }}">0</div>
                    <div class="stat-trend" style="color:var(--c-blue)"><i class="fas fa-id-card"></i> Registered owners</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100 position-relative">
            <span class="accent" style="background:var(--c-violet)"></span>
            <div class="card-body">
                <div class="icon-box tile-violet"><i class="fas fa-car-side"></i></div>
                <div>
                    <div class="stat-label">Total Vehicles</div>
                    <div class="stat-number" data-count="{{ $totalVehicles }}">0</div>
                    <div class="stat-trend" style="color:var(--c-violet)"><i class="fas fa-warehouse"></i> In the fleet</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100 position-relative">
            <span class="accent" style="background:var(--c-amber)"></span>
            <div class="card-body">
                <div class="icon-box tile-amber"><i class="fas fa-link"></i></div>
                <div>
                    <div class="stat-label">Total Linkages</div>
                    <div class="stat-number" data-count="{{ $totalLinkages }}">0</div>
                    <div class="stat-trend" style="color:var(--c-amber)"><i class="fas fa-id-badge"></i> Plates issued</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 g-lg-4 mt-0">
    <div class="col-12 col-lg-7">
        <div class="card h-100 hoverable">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-bolt text-brand me-2"></i> Quick Actions</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-sm-4">
                        <a href="{{ route('clients.create') }}" class="quick-action">
                            <span class="qa-icon tile-blue"><i class="fas fa-user-plus"></i></span>
                            <span class="qa-title">New Client</span>
                            <span class="qa-sub">Register an owner</span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-4">
                        <a href="{{ route('vehicles.create') }}" class="quick-action">
                            <span class="qa-icon tile-violet"><i class="fas fa-car-side"></i></span>
                            <span class="qa-title">New Vehicle</span>
                            <span class="qa-sub">Add to the fleet</span>
                        </a>
                    </div>
                    <div class="col-12 col-sm-4">
                        <a href="{{ route('linkages.create') }}" class="quick-action">
                            <span class="qa-icon tile-amber"><i class="fas fa-link"></i></span>
                            <span class="qa-title">New Linkage</span>
                            <span class="qa-sub">Generate a plate</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card h-100 hoverable">
            <div class="card-header"><i class="fas fa-circle-info text-brand me-2"></i> About this system</div>
            <div class="card-body">
                <p class="text-muted mb-3" style="font-size:.9rem;line-height:1.6">
                    The Magerwa Vehicle Tracking Management System lets you register clients and vehicles,
                    then link them together — automatically issuing a unique plate number in the
                    <strong class="text-dark">RAB 123 A</strong> format.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-brand"><i class="fas fa-check me-1"></i> Auto plate generation</span>
                    <span class="badge bg-brand"><i class="fas fa-check me-1"></i> Secure auth</span>
                    <span class="badge bg-brand"><i class="fas fa-check me-1"></i> REST API</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .quick-action {
        display: flex; flex-direction: column; gap: .1rem; height: 100%;
        padding: 1.1rem; border: 1px solid var(--border); border-radius: var(--r);
        background: var(--surface); color: var(--text); text-decoration: none;
        transition: transform var(--t) var(--ease), box-shadow var(--t) var(--ease), border-color var(--t) var(--ease);
    }
    .quick-action:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--brand-200); color: var(--text); }
    .qa-icon { width: 40px; height: 40px; border-radius: 11px; display: grid; place-items: center; font-size: 1rem; margin-bottom: .65rem; transition: transform var(--t) var(--ease); }
    .quick-action:hover .qa-icon { transform: scale(1.1) rotate(-5deg); }
    .qa-title { font-weight: 700; font-size: .94rem; }
    .qa-sub { font-size: .78rem; color: var(--text-subtle); }
</style>
@endpush
@endsection
