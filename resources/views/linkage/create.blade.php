@extends('layouts.app')

@section('title', 'New Linkage')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h3 class="fw-bold mb-0"><i class="fas fa-link text-brand me-1"></i> Link Vehicle to Client</h3>
    <a href="{{ route('linkages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <div class="alert alert-info">
                    <i class="fas fa-circle-info me-1"></i>
                    A unique plate number (format <strong>RAB 123 A</strong>) will be generated automatically
                    once the linkage is saved.
                </div>

                @if ($vehicles->isEmpty())
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-triangle-exclamation me-1"></i>
                        There are no unlinked vehicles available. Please
                        <a href="{{ route('vehicles.create') }}" class="alert-link">register a vehicle</a> first.
                    </div>
                @else
                    <form action="{{ route('linkages.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="client_id" class="form-label">Select Client <span class="text-danger">*</span></label>
                            <select name="client_id" id="client_id"
                                    class="form-select @error('client_id') is-invalid @enderror">
                                <option value="">-- Choose a client --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>
                                        {{ $client->name }} ({{ $client->national_id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="vehicle_id" class="form-label">Select Vehicle (unlinked only) <span class="text-danger">*</span></label>
                            <select name="vehicle_id" id="vehicle_id"
                                    class="form-select @error('vehicle_id') is-invalid @enderror">
                                <option value="">-- Choose a vehicle --</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" @selected(old('vehicle_id') == $vehicle->id)>
                                        {{ $vehicle->model_name }} — {{ $vehicle->manufacture_company }}
                                        ({{ $vehicle->chassis_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-link"></i> Create Linkage &amp; Generate Plate
                            </button>
                            <a href="{{ route('linkages.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
