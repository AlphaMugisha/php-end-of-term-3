@extends('layouts.app')

@section('title', 'Client Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="fw-bold mb-0"><i class="fas fa-user text-brand me-1"></i> Client Details</h3>
    <div class="d-flex gap-2">
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">
            <i class="fas fa-pen"></i> Edit
        </a>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-4">
        <dl class="row mb-0">
            <dt class="col-sm-3 text-muted">Full Name</dt>
            <dd class="col-sm-9 fw-semibold">{{ $client->name }}</dd>

            <dt class="col-sm-3 text-muted">National ID</dt>
            <dd class="col-sm-9">{{ $client->national_id }}</dd>

            <dt class="col-sm-3 text-muted">Telephone</dt>
            <dd class="col-sm-9">{{ $client->telephone }}</dd>

            <dt class="col-sm-3 text-muted">Address</dt>
            <dd class="col-sm-9">{{ $client->address }}</dd>

            <dt class="col-sm-3 text-muted">Registered On</dt>
            <dd class="col-sm-9">{{ $client->created_at->format('d M Y, H:i') }}</dd>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="fas fa-car text-brand me-1"></i> Linked Vehicles
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Plate Number</th>
                        <th>Model</th>
                        <th>Chassis No.</th>
                        <th>Company</th>
                        <th>Year</th>
                        <th>Date Linked</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($client->linkages as $linkage)
                        <tr>
                            <td><span class="badge bg-brand">{{ $linkage->plate_number }}</span></td>
                            <td>{{ $linkage->vehicle->model_name }}</td>
                            <td>{{ $linkage->vehicle->chassis_number }}</td>
                            <td>{{ $linkage->vehicle->manufacture_company }}</td>
                            <td>{{ $linkage->vehicle->manufacture_year }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($linkage->linked_at)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No vehicles linked to this client.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
