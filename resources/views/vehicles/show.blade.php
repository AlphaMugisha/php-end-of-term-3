@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')
<div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
        <span class="cell-avatar" style="width:52px;height:52px;border-radius:14px;font-size:1.2rem"><i class="fas fa-car-side"></i></span>
        <div>
            <div class="breadcrumb-mini"><a href="{{ route('vehicles.index') }}">Vehicles</a> <i class="fas fa-chevron-right" style="font-size:.6rem"></i> Details</div>
            <h3 class="mb-0">{{ $vehicle->model_name }}</h3>
            <p class="sub mb-0">{{ $vehicle->manufacture_company }} · {{ $vehicle->manufacture_year }}</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning"><i class="fas fa-pen me-1"></i> Edit</a>
        <a href="{{ route('vehicles.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Chassis Number</dt>
            <dd class="col-sm-9 fw-semibold">{{ $vehicle->chassis_number }}</dd>

            <dt class="col-sm-3 text-muted">Manufacture Company</dt>
            <dd class="col-sm-9">{{ $vehicle->manufacture_company }}</dd>

            <dt class="col-sm-3 text-muted">Model Name</dt>
            <dd class="col-sm-9">{{ $vehicle->model_name }}</dd>

            <dt class="col-sm-3 text-muted">Manufacture Year</dt>
            <dd class="col-sm-9">{{ $vehicle->manufacture_year }}</dd>

            <dt class="col-sm-3 text-muted">Price</dt>
            <dd class="col-sm-9 fw-semibold">{{ number_format($vehicle->price, 2) }} RWF</dd>

            <dt class="col-sm-3 text-muted">Registered On</dt>
            <dd class="col-sm-9">{{ $vehicle->created_at->format('d M Y, H:i') }}</dd>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-users text-brand me-1"></i> Linked Client(s)
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Plate Number</th>
                        <th>Client Name</th>
                        <th>National ID</th>
                        <th>Telephone</th>
                        <th>Date Linked</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehicle->linkages as $linkage)
                        <tr>
                            <td><span class="badge bg-brand">{{ $linkage->plate_number }}</span></td>
                            <td>{{ $linkage->client->name }}</td>
                            <td>{{ $linkage->client->national_id }}</td>
                            <td>{{ $linkage->client->telephone }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($linkage->linked_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">This vehicle is not linked to any client.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
