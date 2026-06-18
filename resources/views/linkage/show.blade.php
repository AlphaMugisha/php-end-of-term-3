@extends('layouts.app')

@section('title', 'Linkage Details')

@section('content')
<div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
        <div class="breadcrumb-mini"><a href="{{ route('linkages.index') }}">Linkage</a> <i class="fas fa-chevron-right" style="font-size:.6rem"></i> Details</div>
        <h3>Linkage Details</h3>
        <p class="sub mb-0">Connection between a client and a vehicle</p>
    </div>
    <a href="{{ route('linkages.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card mb-4 hoverable">
    <div class="card-body text-center py-4">
        <div class="text-muted mb-2" style="font-size:.78rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase">Issued Plate Number</div>
        <span class="badge bg-brand badge-plate" style="font-size:1.6rem;padding:.5rem 1.4rem">{{ $linkage->plate_number }}</span>
        <div class="text-muted small mt-3">
            <i class="fas fa-calendar-day me-1"></i> Linked on {{ \Illuminate\Support\Carbon::parse($linkage->linked_at)->format('d M Y, H:i') }}
        </div>
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
