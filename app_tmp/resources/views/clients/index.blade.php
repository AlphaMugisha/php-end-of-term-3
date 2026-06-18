@extends('layouts.app')

@section('title', 'Clients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-0"><i class="fas fa-users text-brand me-1"></i> Clients</h3>
        <p class="text-muted mb-0">Registered client records</p>
    </div>
    <a href="{{ route('clients.create') }}" class="btn btn-success">
        <i class="fas fa-user-plus"></i> Add New Client
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>National ID</th>
                        <th>Telephone</th>
                        <th>Address</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)
                        <tr>
                            <td>{{ $loop->iteration + ($clients->firstItem() - 1) }}</td>
                            <td class="fw-semibold">{{ $client->name }}</td>
                            <td>{{ $client->national_id }}</td>
                            <td>{{ $client->telephone }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($client->address, 40) }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-outline-success" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        data-action="{{ route('clients.destroy', $client) }}"
                                        data-name="{{ $client->name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                No clients registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $clients->links('pagination::bootstrap-5') }}
</div>

@include('partials.delete-modal')
@endsection
