@extends('layouts.app')

@section('title', 'Linkage Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="fw-bold mb-0"><i class="fas fa-link text-brand me-1"></i> Linkage Details</h3>
    <a href="{{ route('linkages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="text-center mb-4">
    <span class="badge bg-brand fs-4 px-4 py-2">{{ $linkage->plate_number }}</span>
    <div class="text-muted small mt-2">
        Linked on {{ \Illuminate\Support\Carbon::parse($linkage->linked_at)->format('d M Y, H:i') }}
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold"><i class="fas fa-user text-brand me-1"></i> Client</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Name</dt>
                    <dd class="col-7">{{ $linkage->client->name ?? '—' }}</dd>
                    <dt class="col-5 text-muted">National ID</dt>
                    <dd class="col-7">{{ $linkage->client->national_id ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Telephone</dt>
                    <dd class="col-7">{{ $linkage->client->telephone ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Address</dt>
                    <dd class="col-7">{{ $linkage->client->address ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold"><i class="fas fa-car text-brand me-1"></i> Vehicle</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Model</dt>
                    <dd class="col-7">{{ $linkage->vehicle->model_name ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Chassis No.</dt>
                    <dd class="col-7">{{ $linkage->vehicle->chassis_number ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Company</dt>
                    <dd class="col-7">{{ $linkage->vehicle->manufacture_company ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Year</dt>
                    <dd class="col-7">{{ $linkage->vehicle->manufacture_year ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Price</dt>
                    <dd class="col-7">{{ $linkage->vehicle ? number_format($linkage->vehicle->price, 2) . ' RWF' : '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="button" class="btn btn-danger"
            data-bs-toggle="modal" data-bs-target="#deleteModal"
            data-action="{{ route('linkages.destroy', $linkage) }}"
            data-name="linkage {{ $linkage->plate_number }}">
        <i class="fas fa-trash"></i> Remove Linkage
    </button>
</div>

@include('partials.delete-modal')
@endsection
