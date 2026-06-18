@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-wrapper d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="auth-card card shadow-lg border-0 fade-in-up" id="loginCard" style="width: 100%; max-width: 430px;">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="brand-badge d-inline-flex align-items-center justify-content-center mb-3">
                    <i class="fas fa-truck-moving fa-2x text-white"></i>
                </div>
                <h4 class="fw-bold text-brand mb-0">Magerwa VTMS</h4>
                <p class="text-muted small mb-0">Sign in to your admin account</p>
            </div>

            <!-- AJAX status banner -->
            <div id="loginAlert" class="alert alert-danger d-none align-items-center" role="alert">
                <i class="fas fa-circle-exclamation me-2"></i>
                <span id="loginAlertMsg"></span>
            </div>

            <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3 field-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group input-group-animated">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email"
                               class="form-control" value="{{ old('email') }}"
                               placeholder="admin@magerwa.rw" autofocus autocomplete="email">
                    </div>
                    <div class="invalid-feedback d-block field-error" data-field="email"></div>
                </div>

                <div class="mb-3 field-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group input-group-animated">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password"
                               class="form-control" placeholder="••••••••" autocomplete="current-password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" tabindex="-1"
                                aria-label="Show password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback d-block field-error" data-field="password"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check m-0">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Remember me</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg btn-ripple" id="loginBtn">
                        <span class="btn-label"><i class="fas fa-right-to-bracket me-1"></i> Login</span>
                        <span class="btn-spinner d-none">
                            <span class="spinner-border spinner-border-sm me-1"></span> Signing in…
                        </span>
                    </button>
                </div>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-brand fw-semibold text-decoration-none link-underline-hover">Register</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const form     = document.getElementById('loginForm');
    const btn      = document.getElementById('loginBtn');
    const card     = document.getElementById('loginCard');
    const alertBox = document.getElementById('loginAlert');
    const alertMsg = document.getElementById('loginAlertMsg');
    const csrf     = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Show / hide password
    document.querySelector('.toggle-password').addEventListener('click', function () {
        const input = document.getElementById('password');
        const icon  = this.querySelector('i');
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !show);
        icon.classList.toggle('fa-eye-slash', show);
    });

    function clearErrors() {
        alertBox.classList.add('d-none');
        alertBox.classList.remove('d-flex');
        document.querySelectorAll('.field-error').forEach(e => e.textContent = '');
        document.querySelectorAll('#loginForm .form-control').forEach(e => e.classList.remove('is-invalid'));
    }

    function showFieldErrors(errors) {
        Object.keys(errors).forEach(function (field) {
            const box   = document.querySelector('.field-error[data-field="' + field + '"]');
            const input = document.getElementById(field);
            if (box)   box.textContent = errors[field][0];
            if (input) input.classList.add('is-invalid');
        });
    }

    function shake() {
        card.classList.remove('shake');
        void card.offsetWidth;           // force reflow to restart animation
        card.classList.add('shake');
    }

    function setLoading(state) {
        btn.disabled = state;
        btn.querySelector('.btn-label').classList.toggle('d-none', state);
        btn.querySelector('.btn-spinner').classList.toggle('d-none', !state);
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearErrors();
        setLoading(true);

        const data = new FormData(form);

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: data,
            });

            if (res.ok) {
                const json = await res.json();
                btn.querySelector('.btn-spinner').innerHTML =
                    '<i class="fas fa-circle-check me-1"></i> Success! Redirecting…';
                card.classList.add('success-pop');
                setTimeout(() => window.location.href = json.redirect, 550);
                return;
            }

            if (res.status === 422) {
                const json = await res.json();
                showFieldErrors(json.errors || {});
                alertMsg.textContent = json.message || 'Please check your credentials.';
                alertBox.classList.remove('d-none');
                alertBox.classList.add('d-flex');
            } else {
                alertMsg.textContent = 'Something went wrong. Please try again.';
                alertBox.classList.remove('d-none');
                alertBox.classList.add('d-flex');
            }
            shake();
            setLoading(false);
        } catch (err) {
            alertMsg.textContent = 'Network error. Please check your connection.';
            alertBox.classList.remove('d-none');
            alertBox.classList.add('d-flex');
            shake();
            setLoading(false);
        }
    });
})();
</script>
@endpush
