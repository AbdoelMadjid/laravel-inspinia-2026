@extends('layouts.auth')

@section('title', 'Buat Akun Baru | ' . (\App\Models\Admin\System\AppProfile::get()->app_name ?? 'INSPINIA'))

@section('content')
@php $appProfile = \App\Models\Admin\System\AppProfile::get(); @endphp
<div class="auth-box overflow-hidden align-items-center d-flex min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-md-6 col-sm-8">
                <div class="auth-brand text-center mb-4">
                    <a href="{{ route('home') }}" class="logo-dark">
                        <img src="{{ $appProfile->logo_dark_url }}" alt="{{ $appProfile->app_name }}" height="26" />
                    </a>
                    <a href="{{ route('home') }}" class="logo-light">
                        <img src="{{ $appProfile->logo_light_url }}" alt="{{ $appProfile->app_name }}" height="26" />
                    </a>
                    <h4 class="fw-bold mt-3">Buat Akun Baru</h4>
                    <p class="text-muted w-lg-75 mx-auto">Silakan lengkapi formulir di bawah ini untuk mendaftar akun baru.</p>
                </div>

                <div class="card p-4 shadow-sm">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">
                                    <i class="ti ti-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="name" 
                                       placeholder="Nama Lengkap Anda" />
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">
                                    <i class="ti ti-mail"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="username" 
                                       placeholder="you@example.com" />
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Kata Sandi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">
                                    <i class="ti ti-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password" 
                                       placeholder="••••••••" />
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')" title="Lihat Kata Sandi">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">
                                    <i class="ti ti-lock-check"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password" 
                                       placeholder="••••••••" />
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirmation', 'toggleConfirmPasswordIcon')" title="Lihat Konfirmasi Kata Sandi">
                                    <i class="ti ti-eye" id="toggleConfirmPasswordIcon"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Real-time Password Requirements Checklist -->
                        <div class="card bg-light border-0 p-3 mb-3 rounded-3 fs-xs">
                            <div class="fw-semibold text-dark mb-2 d-flex align-items-center">
                                <i class="ti ti-shield-check text-primary me-1 fs-16"></i> Syarat Keamanan Kata Sandi:
                            </div>
                            <div class="row g-2">
                                <div class="col-6 text-muted" id="rule-length">
                                    <i class="ti ti-circle-x me-1 fs-14" id="icon-length"></i> Minimal 8 Karakter
                                </div>
                                <div class="col-6 text-muted" id="rule-uppercase">
                                    <i class="ti ti-circle-x me-1 fs-14" id="icon-uppercase"></i> Huruf Besar (A-Z)
                                </div>
                                <div class="col-6 text-muted" id="rule-lowercase">
                                    <i class="ti ti-circle-x me-1 fs-14" id="icon-lowercase"></i> Huruf Kecil (a-z)
                                </div>
                                <div class="col-6 text-muted" id="rule-number">
                                    <i class="ti ti-circle-x me-1 fs-14" id="icon-number"></i> Angka (0-9)
                                </div>
                                <div class="col-12 text-muted" id="rule-match">
                                    <i class="ti ti-circle-x me-1 fs-14" id="icon-match"></i> Konfirmasi Kata Sandi Cocok
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">
                                <i class="ti ti-user-plus me-1"></i> Buat Akun Sekarang
                            </button>
                        </div>
                    </form>

                    <p class="text-muted text-center mt-4 mb-0 fs-sm">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="text-decoration-underline link-offset-3 fw-semibold">Masuk Akun</a>
                    </p>
                </div>

                <p class="text-center text-muted mt-4 mb-0">
                    © {{ $appProfile->app_year }} <span class="fw-bold">{{ $appProfile->app_name }}</span> — by
                    @if($appProfile->developer_url)
                        <a href="{{ $appProfile->developer_url }}" target="_blank" class="fw-bold text-decoration-none text-muted">{{ $appProfile->developer_name }}</a>
                    @else
                        <span class="fw-bold">{{ $appProfile->developer_name }}</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');

        function checkPasswordRequirements() {
            const pass = passwordInput.value;
            const confirmPass = confirmInput.value;

            // 1. Length >= 8
            updateRuleStatus('length', pass.length >= 8);

            // 2. Uppercase
            updateRuleStatus('uppercase', /[A-Z]/.test(pass));

            // 3. Lowercase
            updateRuleStatus('lowercase', /[a-z]/.test(pass));

            // 4. Number
            updateRuleStatus('number', /[0-9]/.test(pass));

            // 5. Match
            updateRuleStatus('match', pass.length > 0 && pass === confirmPass);
        }

        function updateRuleStatus(ruleId, isMet) {
            const icon = document.getElementById('icon-' + ruleId);
            const container = document.getElementById('rule-' + ruleId);

            if (!icon || !container) return;

            if (isMet) {
                icon.className = 'ti ti-circle-check text-success me-1 fs-14';
                container.className = container.className.replace('text-muted', '').trim() + ' text-success fw-semibold';
            } else {
                icon.className = 'ti ti-circle-x text-muted me-1 fs-14';
                container.classList.remove('text-success', 'fw-semibold');
                if (!container.classList.contains('text-muted')) {
                    container.classList.add('text-muted');
                }
            }
        }

        if (passwordInput && confirmInput) {
            passwordInput.addEventListener('input', checkPasswordRequirements);
            confirmInput.addEventListener('input', checkPasswordRequirements);
            checkPasswordRequirements();
        }
    });
</script>
@endsection
