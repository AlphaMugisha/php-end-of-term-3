@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-wrapper d-flex align-items-center justify-content-center py-5" style="min-height: 100vh;">
    <div class="auth-card card shadow-lg border-0 fade-in-up" id="registerCard" style="width: 100%; max-width: 540px;">
        <div class="card-body p-4 p-sm-5">
            <div class="text-center mb-4">
                <div class="brand-badge d-inline-flex align-items-center justify-content-center mb-3">
                    <i class="fas fa-user-plus fa-2x text-white"></i>
                </div>
                <h4 class="fw-bold text-brand mb-0">Create Admin Account</h4>
                <p class="text-muted small mb-0">Magerwa Vehicle Tracking Management System</p>
            </div>

            <!-- AJAX status banner -->
            <div id="registerAlert" class="alert alert-danger d-none align-items-center" role="alert">
                <i class="fas fa-circle-exclamation me-2"></i>
                <span id="registerAlertMsg"></span>
            </div>

            <form id="registerForm" action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3 field-group">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group input-group-animated">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" id="name"
                               class="form-control" value="{{ old('name') }}"
                               placeholder="Jane Doe" autofocus autocomplete="name">
                    </div>
                    <div class="invalid-feedback d-block field-error" data-field="name"></div>
                </div>

                <div class="mb-3 field-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group input-group-animated">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email"
                               class="form-control" value="{{ old('email') }}"
                               placeholder="admin@magerwa.rw" autocomplete="email">
                    </div>
                    <div class="invalid-feedback d-block field-error" data-field="email"></div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3 field-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="input-group input-group-animated">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="phone" id="phone"
                                   class="form-control" value="{{ old('phone') }}"
                                   placeholder="+250..." autocomplete="tel">
                        </div>
                        <div class="invalid-feedback d-block field-error" data-field="phone"></div>
                    </div>
                    <div class="col-sm-6 mb-3 field-group">
                        <label for="national_id" class="form-label">National ID</label>
                        <div class="input-group input-group-animated">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="national_id" id="national_id"
                                   class="form-control" value="{{ old('national_id') }}">
                        </div>
                        <div class="invalid-feedback d-block field-error" data-field="national_id"></div>
                    </div>
                </div>

                <div class="mb-2 field-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group input-group-animated">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password"
                               class="form-control" placeholder="••••••••" autocomplete="new-password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" tabindex="-1"
                                data-target="password" aria-label="Show password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback d-block field-error" data-field="password"></div>

                    <!-- Live password strength meter -->
                    <div id="strengthWrap" class="strength-wrap mt-2 d-none">
                        <div class="strength-bar"><span id="strengthFill"></span></div>
                        <small id="strengthLabel" class="strength-label text-muted">Too short</small>
                    </div>
                </div>

                <div class="mb-4 field-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group input-group-animated">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" placeholder="••••••••" autocomplete="new-password">
                        <button class="btn btn-outline-secondary toggle-password" type="button" tabindex="-1"
                                data-target="password_confirmation" aria-label="Show password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <small id="matchHint" class="match-hint d-none"></small>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg btn-ripple" id="registerBtn">
                        <span class="btn-label"><i class="fas fa-user-plus me-1"></i> Create Account</span>
                        <span class="btn-spinner d-none">
                            <span class="spinner-border spinner-border-sm me-1"></span> Creating account…
                        </span>
                    </button>
                </div>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="text-brand fw-semibold text-decoration-none link-underline-hover">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const form     = document.getElementById('registerForm');
    const btn      = document.getElementById('registerBtn');
    const card     = document.getElementById('registerCard');
    const alertBox = document.getElementById('registerAlert');
    const alertMsg = document.getElementById('registerAlertMsg');
    const csrf     = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const pwd       = document.getElementById('password');
    const pwdConfirm= document.getElementById('password_confirmation');

    // Show / hide password (both fields)
    document.querySelectorAll('.toggle-password').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const input = document.getElementById(this.getAttribute('data-target'));
            const icon  = this.querySelector('i');
            const show  = input.type === 'password';
            input.type  = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
        });
    });

    // ---- Live password strength meter ----
    const strengthWrap  = document.getElementById('strengthWrap');
    const strengthFill  = document.getElementById('strengthFill');
    const strengthLabel = document.getElementById('strengthLabel');
    const levels = [
        { label: 'Too weak',  color: '#dc3545', width: '25%'  },
        { label: 'Fair',      color: '#fd7e14', width: '50%'  },
        { label: 'Good',      color: '#ffc107', width: '75%'  },
        { label: 'Strong',    color: '#1a6b3c', width: '100%' },
    ];

    function scorePassword(v) {
        let score = 0;
        if (v.length >= 8)        score++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) score++;
        if (/\d/.test(v))         score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        return Math.min(score, 4);
    }

    pwd.addEventListener('input', function () {
        const v = pwd.value;
        if (!v) { strengthWrap.classList.add('d-none'); return; }
        strengthWrap.classList.remove('d-none');

        if (v.length < 8) {
            strengthFill.style.width = '15%';
            strengthFill.style.background = '#dc3545';
            strengthLabel.textContent = 'Too short (min 8 characters)';
            strengthLabel.style.color = '#dc3545';
        } else {
            const lvl = levels[Math.max(scorePassword(v) - 1, 0)];
            strengthFill.style.width = lvl.width;
            strengthFill.style.background = lvl.color;
            strengthLabel.textContent = lvl.label;
            strengthLabel.style.color = lvl.color;
        }
        checkMatch();
    });

    // ---- Live confirm-password match indicator ----
    const matchHint = document.getElementById('matchHint');
    function checkMatch() {
        if (!pwdConfirm.value) { matchHint.classList.add('d-none'); return; }
        matchHint.classList.remove('d-none');
        const ok = pwd.value === pwdConfirm.value;
        matchHint.innerHTML = ok
            ? '<i class="fas fa-circle-check me-1"></i> Passwords match'
            : '<i class="fas fa-circle-xmark me-1"></i> Passwords do not match';
        matchHint.style.color = ok ? '#1a6b3c' : '#dc3545';
        pwdConfirm.classList.toggle('is-valid', ok);
        pwdConfirm.classList.toggle('is-invalid', !ok);
    }
    pwdConfirm.addEventListener('input', checkMatch);

    // ---- AJAX helpers ----
    function clearErrors() {
        alertBox.classList.add('d-none');
        alertBox.classList.remove('d-flex');
        document.querySelectorAll('.field-error').forEach(e => e.textContent = '');
        document.querySelectorAll('#registerForm .form-control').forEach(e => e.classList.remove('is-invalid'));
    }

    function showFieldErrors(errors) {
        Object.keys(errors).forEach(function (field) {
            const box   = document.querySelector('.field-error[data-field="' + field + '"]');
            const input = document.getElementById(field);
            if (box)   box.textContent = errors[field][0];
            if (input) input.classList.add('is-invalid');
        });
        // Focus first errored field
        const first = document.querySelector('#registerForm .is-invalid');
        if (first) first.focus();
    }

    function shake() {
        card.classList.remove('shake');
        void card.offsetWidth;            // force reflow to restart animation
        card.classList.add('shake');
    }

    function setLoading(state) {
        btn.disabled = state;
        btn.querySelector('.btn-label').classList.toggle('d-none', state);
        btn.querySelector('.btn-spinner').classList.toggle('d-none', !state);
    }

    function flagError(msg) {
        alertMsg.textContent = msg;
        alertBox.classList.remove('d-none');
        alertBox.classList.add('d-flex');
        shake();
        setLoading(false);
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearErrors();

        // Cheap client-side guard for the confirm field
        if (pwd.value !== pwdConfirm.value) {
            showFieldErrors({ password: ['Passwords do not match.'] });
            flagError('Please make sure both passwords match.');
            return;
        }

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
                setTimeout(() => window.location.href = json.redirect, 600);
                return;
            }

            if (res.status === 422) {
                const json = await res.json();
                showFieldErrors(json.errors || {});
                flagError(json.message || 'Please correct the highlighted fields.');
            } else {
                flagError('Something went wrong. Please try again.');
            }
        } catch (err) {
            flagError('Network error. Please check your connection.');
        }
    });
})();
</script>
@endpush
