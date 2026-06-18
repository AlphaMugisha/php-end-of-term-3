@extends('layouts.app')

@section('title', 'Linkage')

@section('content')
<div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
        <div class="breadcrumb-mini"><a href="{{ route('dashboard') }}">Home</a> <i class="fas fa-chevron-right" style="font-size:.6rem"></i> Linkage</div>
        <h3>Vehicle &mdash; Client Linkage</h3>
        <p class="sub mb-0">{{ $linkages->total() }} linked {{ Str::plural('record', $linkages->total()) }} with auto-generated plates</p>
    </div>
    <a href="{{ route('linkages.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> New Linkage
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if ($linkages->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-link"></i></div>
                <h6>No linkages yet</h6>
                <p>Link a vehicle to a client to automatically issue a plate number.</p>
                <a href="{{ route('linkages.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i> Create Linkage</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Plate</th>
                            <th>Client</th>
                            <th>National ID</th>
                            <th>Vehicle</th>
                            <th>Chassis No.</th>
                            <th>Year</th>
                            <th class="text-end">Price (RWF)</th>
                            <th>Linked</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($linkages as $linkage)
                            <tr>
                                <td><span class="badge bg-brand badge-plate">{{ $linkage->plate_number }}</span></td>
                                <td class="fw-semibold">{{ $linkage->client->name ?? '—' }}</td>
                                <td class="text-muted">{{ $linkage->client->national_id ?? '—' }}</td>
                                <td>
                                    <span class="fw-semibold d-block">{{ $linkage->vehicle->model_name ?? '—' }}</span>
                                    <span class="cell-sub">{{ $linkage->vehicle->manufacture_company ?? '' }}</span>
                                </td>
                                <td class="text-muted">{{ $linkage->vehicle->chassis_number ?? '—' }}</td>
                                <td>{{ $linkage->vehicle->manufacture_year ?? '—' }}</td>
                                <td class="text-end" style="font-variant-numeric:tabular-nums">{{ $linkage->vehicle ? number_format($linkage->vehicle->price, 2) : '—' }}</td>
                                <td class="text-muted">{{ \Illuminate\Support\Carbon::parse($linkage->linked_at)->format('d M Y') }}</td>
                                <td class="text-end">
                                    <div class="table-actions">
                                        <a href="{{ route('linkages.show', $linkage) }}" class="btn btn-sm btn-outline-success" title="View"><i class="fas fa-eye"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger" title="Remove Linkage"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-action="{{ route('linkages.destroy', $linkage) }}"
                                                data-name="linkage {{ $linkage->plate_number }}">
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

@if ($linkages->hasPages())
    <div class="mt-3">{{ $linkages->links('pagination::bootstrap-5') }}</div>
@endif

@include('partials.delete-modal')
@endsection
