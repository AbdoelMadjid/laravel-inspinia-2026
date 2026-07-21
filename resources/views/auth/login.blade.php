@extends('layouts.auth')

@section('title', 'Masuk Akun | ' . (\App\Models\Admin\System\AppProfile::get()->app_name ?? 'INSPINIA'))

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
                    <h4 class="fw-bold mt-3">Selamat Datang Kembali</h4>
                    <p class="text-muted w-lg-75 mx-auto">Silakan masuk dengan Email atau Username dan Kata Sandi Anda untuk melanjutkan.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-3 fs-sm" role="alert">
                        <i class="ti ti-check-circle me-1"></i> {{ session('status') }}
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show mb-3 d-flex align-items-center fs-sm" role="alert">
                        <i class="ti ti-alert-triangle fs-18 me-2"></i>
                        <div>{{ session('warning') }}</div>
                        <button type="button" class="btn-close ms-auto py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3 d-flex align-items-center fs-sm" role="alert">
                        <i class="ti ti-alert-circle fs-18 me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show mb-3 d-flex align-items-center fs-sm" role="alert">
                        <i class="ti ti-info-circle fs-18 me-2"></i>
                        <div>{{ session('info') }}</div>
                        <button type="button" class="btn-close ms-auto py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card p-4 shadow-sm">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email / Username Field -->
                        <div class="mb-3">
                            <label for="login" class="form-label fw-semibold">Email atau Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">
                                    <i class="ti ti-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('login') is-invalid @enderror @error('email') is-invalid @enderror" 
                                       id="login" 
                                       name="login" 
                                       value="{{ old('login', old('email')) }}" 
                                       required 
                                       autofocus 
                                       autocomplete="username" 
                                       placeholder="you@example.com atau username" />
                            </div>
                            @error('login')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field with Show/Hide Toggle -->
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
                                       autocomplete="current-password" 
                                       placeholder="••••••••" />
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="Lihat Kata Sandi">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember" />
                                <label class="form-check-label fs-sm" for="remember_me">Ingat saya di perangkat ini</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-underline link-offset-3 text-muted fs-sm">Lupa Kata Sandi?</a>
                            @endif
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">
                                <i class="ti ti-login me-1"></i> Masuk Akun
                            </button>
                        </div>
                    </form>

                    @if (Route::has('register'))
                        <p class="text-muted text-center mt-4 mb-0 fs-sm">
                            Belum memiliki akun?
                            <a href="{{ route('register') }}" class="text-decoration-underline link-offset-3 fw-semibold">Buat Akun Baru</a>
                        </p>
                    @endif
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
    function togglePasswordVisibility() {
        const input = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
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
</script>
@endsection
