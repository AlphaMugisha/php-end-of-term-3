@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Dashboard</h3>
        <p class="text-muted mb-0">Overview of Magerwa vehicle &amp; client records</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="fas fa-user-shield"></i></div>
                <div>
                    <div class="text-muted small text-uppercase">Total Admins</div>
                    <div class="h3 fw-bold mb-0 stat-number" data-count="{{ $totalAdmins }}">0</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="fas fa-users"></i></div>
                <div>
                    <div class="text-muted small text-uppercase">Total Clients</div>
                    <div class="h3 fw-bold mb-0 stat-number" data-count="{{ $totalClients }}">0</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="fas fa-car"></i></div>
                <div>
                    <div class="text-muted small text-uppercase">Total Vehicles</div>
                    <div class="h3 fw-bold mb-0 stat-number" data-count="{{ $totalVehicles }}">0</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="fas fa-link"></i></div>
                <div>
                    <div class="text-muted small text-uppercase">Total Linkages</div>
                    <div class="h3 fw-bold mb-0 stat-number" data-count="{{ $totalLinkages }}">0</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-12 col-lg-6">
        <div class="card h-100 hoverable">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-bolt text-brand me-1"></i> Quick Actions</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('clients.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> New Client
                    </a>
                    <a href="{{ route('vehicles.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> New Vehicle
                    </a>
                    <a href="{{ route('linkages.create') }}" class="btn btn-success">
                        <i class="fas fa-link"></i> New Linkage
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card h-100 hoverable">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-circle-info text-brand me-1"></i> About</h6>
                <p class="text-muted mb-0">
                    Welcome to the Magerwa Vehicle Tracking Management System. Use the sidebar to
                    register clients, register vehicles, and link vehicles to clients with
                    automatically generated unique plate numbers.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
