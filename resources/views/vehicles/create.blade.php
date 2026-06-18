@extends('layouts.app')

@section('title', 'Add Vehicle')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="fw-bold mb-0"><i class="fas fa-car text-brand me-1"></i> Register New Vehicle</h3>
    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('vehicles.store') }}" method="POST" novalidate>
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="chassis_number" class="form-label">Chassis Number (VIN) <span class="text-danger">*</span></label>
                    <input type="text" name="chassis_number" id="chassis_number"
                           class="form-control @error('chassis_number') is-invalid @enderror"
                           value="{{ old('chassis_number') }}" autofocus>
                    @error('chassis_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="manufacture_company" class="form-label">Manufacture Company <span class="text-danger">*</span></label>
                    <input type="text" name="manufacture_company" id="manufacture_company"
                           class="form-control @error('manufacture_company') is-invalid @enderror"
                           value="{{ old('manufacture_company') }}" placeholder="e.g. Toyota">
                    @error('manufacture_company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="model_name" class="form-label">Model Name <span class="text-danger">*</span></label>
                    <input type="text" name="model_name" id="model_name"
                           class="form-control @error('model_name') is-invalid @enderror"
                           value="{{ old('model_name') }}" placeholder="e.g. Land Cruiser">
                    @error('model_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="manufacture_year" class="form-label">Manufacture Year <span class="text-danger">*</span></label>
                    <input type="number" name="manufacture_year" id="manufacture_year"
                           class="form-control @error('manufacture_year') is-invalid @enderror"
                           value="{{ old('manufacture_year') }}" min="1900" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                    @error('manufacture_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price (RWF) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" id="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price') }}">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-floppy-disk"></i> Save Vehicle
                </button>
                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
