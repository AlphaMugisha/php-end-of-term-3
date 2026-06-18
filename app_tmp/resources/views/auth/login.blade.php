@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center mb-2"
                     style="width:64px;height:64px;border-radius:50%;background:var(--magerwa-green);">
                    <i class="fas fa-truck-moving fa-2x text-white"></i>
                </div>
                <h4 class="fw-bold text-brand mb-0">Magerwa VTMS</h4>
                <p class="text-muted small mb-0">Sign in to your admin account</p>
            </div>

            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember me</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-right-to-bracket"></i> Login
                    </button>
                </div>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-brand fw-semibold text-decoration-none">Register</a>
            </p>
        </div>
    </div>
</div>
@endsection
