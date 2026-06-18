@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')
<div class="page-header d-flex justify-content-between align-items-end flex-wrap gap-3">
    <div>
        <div class="breadcrumb-mini"><a href="{{ route('clients.index') }}">Clients</a> <i class="fas fa-chevron-right" style="font-size:.6rem"></i> Edit</div>
        <h3>Edit Client</h3>
        <p class="sub mb-0">Update {{ $client->name }}'s details</p>
    </div>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card" style="max-width:780px">
    <div class="card-body p-4">
        <div class="form-section-title"><i class="fas fa-user text-brand"></i> Client Information</div>
        <form action="{{ route('clients.update', $client) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $client->name) }}" autofocus>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="national_id" class="form-label">National ID <span class="text-danger">*</span></label>
                    <input type="text" name="national_id" id="national_id"
                           class="form-control @error('national_id') is-invalid @enderror"
                           value="{{ old('national_id', $client->national_id) }}">
                    @error('national_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Telephone <span class="text-danger">*</span></label>
                    <input type="text" name="telephone" id="telephone"
                           class="form-control @error('telephone') is-invalid @enderror"
                           value="{{ old('telephone', $client->telephone) }}">
                    @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea name="address" id="address" rows="3"
                              class="form-control @error('address') is-invalid @enderror">{{ old('address', $client->address) }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-floppy-disk"></i> Update Client
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
