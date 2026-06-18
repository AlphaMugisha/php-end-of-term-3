@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
        <div class="breadcrumb-mini"><a href="{{ route('dashboard') }}">Home</a> <i class="fas fa-chevron-right" style="font-size:.6rem"></i> Vehicles</div>
        <h3>Vehicles</h3>
        <p class="sub mb-0">{{ $vehicles->total() }} vehicle {{ Str::plural('record', $vehicles->total()) }} in the fleet</p>
    </div>
    <a href="{{ route('vehicles.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> Add New Vehicle
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if ($vehicles->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-car-side"></i></div>
                <h6>No vehicles yet</h6>
                <p>Register your first vehicle to start building the fleet.</p>
                <a href="{{ route('vehicles.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i> Add Vehicle</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Chassis Number</th>
                            <th>Company</th>
                            <th>Year</th>
                            <th class="text-end">Price (RWF)</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $vehicle)
                            <tr>
                                <td>
                                    <div class="cell-name">
                                        <span class="cell-avatar"><i class="fas fa-car-side"></i></span>
                                        <span>
                                            <span class="fw-semibold d-block">{{ $vehicle->model_name }}</span>
                                            <span class="cell-sub">{{ $vehicle->manufacture_company }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td><span class="text-muted" style="font-variant-numeric:tabular-nums">{{ $vehicle->chassis_number }}</span></td>
                                <td>{{ $vehicle->manufacture_company }}</td>
                                <td>{{ $vehicle->manufacture_year }}</td>
                                <td class="text-end fw-semibold" style="font-variant-numeric:tabular-nums">{{ number_format($vehicle->price, 2) }}</td>
                                <td class="text-end">
                                    <div class="table-actions">
                                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-outline-success" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-action="{{ route('vehicles.destroy', $vehicle) }}"
                                                data-name="{{ $vehicle->model_name }} ({{ $vehicle->chassis_number }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@if ($vehicles->hasPages())
    <div class="mt-3">{{ $vehicles->links('pagination::bootstrap-5') }}</div>
@endif

@include('partials.delete-modal')
@endsection
