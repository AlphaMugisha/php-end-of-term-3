@extends('layouts.app')

@section('title', 'Clients')

@section('content')
<div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
        <div class="breadcrumb-mini"><a href="{{ route('dashboard') }}">Home</a> <i class="fas fa-chevron-right" style="font-size:.6rem"></i> Clients</div>
        <h3>Clients</h3>
        <p class="sub mb-0">{{ $clients->total() }} registered client {{ Str::plural('record', $clients->total()) }}</p>
    </div>
    <a href="{{ route('clients.create') }}" class="btn btn-success">
        <i class="fas fa-user-plus me-1"></i> Add New Client
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if ($clients->isEmpty())
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-users"></i></div>
                <h6>No clients yet</h6>
                <p>Get started by registering your first client.</p>
                <a href="{{ route('clients.create') }}" class="btn btn-success"><i class="fas fa-user-plus me-1"></i> Add Client</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Client</th>
                            <th>National ID</th>
                            <th>Telephone</th>
                            <th>Address</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration + ($clients->firstItem() - 1) }}</td>
                                <td>
                                    <div class="cell-name">
                                        <span class="cell-avatar">{{ strtoupper(substr($client->name, 0, 1)) }}</span>
                                        <span>
                                            <span class="fw-semibold d-block">{{ $client->name }}</span>
                                            <span class="cell-sub">Client #{{ $client->id }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $client->national_id }}</td>
                                <td>{{ $client->telephone }}</td>
                                <td class="text-muted">{{ \Illuminate\Support\Str::limit($client->address, 36) }}</td>
                                <td class="text-end">
                                    <div class="table-actions">
                                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-outline-success" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-pen"></i></a>
                                        <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-action="{{ route('clients.destroy', $client) }}"
                                                data-name="{{ $client->name }}">
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

@if ($clients->hasPages())
    <div class="mt-3">{{ $clients->links('pagination::bootstrap-5') }}</div>
@endif

@include('partials.delete-modal')
@endsection
