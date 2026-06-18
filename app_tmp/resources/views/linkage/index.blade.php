@extends('layouts.app')

@section('title', 'Linkage')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-0"><i class="fas fa-link text-brand me-1"></i> Vehicle &mdash; Client Linkage</h3>
        <p class="text-muted mb-0">Linked records with auto-generated plate numbers</p>
    </div>
    <a href="{{ route('linkages.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> New Linkage
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Plate Number</th>
                        <th>Client Name</th>
                        <th>National ID</th>
                        <th>Vehicle Model</th>
                        <th>Chassis No.</th>
                        <th>Company</th>
                        <th>Year</th>
                        <th>Price (RWF)</th>
                        <th>Date Linked</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($linkages as $linkage)
                        <tr>
                            <td><span class="badge bg-brand fs-6">{{ $linkage->plate_number }}</span></td>
                            <td class="fw-semibold">{{ $linkage->client->name ?? '—' }}</td>
                            <td>{{ $linkage->client->national_id ?? '—' }}</td>
                            <td>{{ $linkage->vehicle->model_name ?? '—' }}</td>
                            <td>{{ $linkage->vehicle->chassis_number ?? '—' }}</td>
                            <td>{{ $linkage->vehicle->manufacture_company ?? '—' }}</td>
                            <td>{{ $linkage->vehicle->manufacture_year ?? '—' }}</td>
                            <td>{{ $linkage->vehicle ? number_format($linkage->vehicle->price, 2) : '—' }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($linkage->linked_at)->format('d M Y') }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('linkages.show', $linkage) }}" class="btn btn-sm btn-outline-success" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" title="Remove Linkage"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-action="{{ route('linkages.destroy', $linkage) }}"
                                        data-name="linkage {{ $linkage->plate_number }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                No linkages created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $linkages->links('pagination::bootstrap-5') }}
</div>

@include('partials.delete-modal')
@endsection
