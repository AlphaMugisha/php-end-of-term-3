@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="d-flex align-items-center justify-content-center py-5" style="min-height: 100vh;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 520px;">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:64px;height:64px;border-radius:50%;background:var(--magerwa-green);">
                    <i class="fas fa-user-plus fa-2x text-white"></i>
                </div>
                <h4 class="fw-bold text-brand mb-0">Create Admin Account</h4>
                <p class="text-muted small mb-0">Magerwa Vehicle Tracking Management System</p>
            </div>

            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" autofocus>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" name="phone" id="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}" placeholder="+250...">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="national_id" class="form-label">National ID</label>
                        <input type="text" name="national_id" id="national_id"
                               class="form-control @error('national_id') is-invalid @enderror"
                               value="{{ old('national_id') }}">
                        @error('national_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control">
                    </div>
                </div>

                <div class="d-grid mt-2">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </div>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="text-brand fw-semibold text-decoration-none">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
