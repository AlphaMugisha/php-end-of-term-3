@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-0"><i class="fas fa-car text-brand me-1"></i> Vehicles</h3>
        <p class="text-muted mb-0">Registered vehicle records</p>
    </div>
    <a href="{{ route('vehicles.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Add New Vehicle
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Chassis Number</th>
                        <th>Company</th>
                        <th>Year</th>
                        <th>Model</th>
                        <th>Price (RWF)</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $loop->iteration + ($vehicles->firstItem() - 1) }}</td>
                            <td class="fw-semibold">{{ $vehicle->chassis_number }}</td>
                            <td>{{ $vehicle->manufacture_company }}</td>
                            <td>{{ $vehicle->manufacture_year }}</td>
                            <td>{{ $vehicle->model_name }}</td>
                            <td>{{ number_format($vehicle->price, 2) }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-outline-success" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-action="{{ route('vehicles.destroy', $vehicle) }}"
                                        data-name="{{ $vehicle->model_name }} ({{ $vehicle->chassis_number }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                No vehicles registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $vehicles->links('pagination::bootstrap-5') }}
</div>

@include('partials.delete-modal')
@endsection
