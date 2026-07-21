@extends('layouts.auth')

@section('title', 'Lupa Password | ' . (\App\Models\Admin\System\AppProfile::get()->app_name ?? 'INSPINIA'))

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
                    <h4 class="fw-bold mt-3">Lupa Kata Sandi?</h4>
                    <p class="text-muted w-lg-75 mx-auto">Masukkan Email atau Username Anda. Permintaan reset password akan dikirimkan ke Administrator untuk diproses.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-3 fs-sm" role="alert">
                        <i class="ti ti-check-circle me-1"></i> {{ session('status') }}
                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card p-4 shadow-sm">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="username_or_email" class="form-label fw-semibold">
                                Email atau Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">
                                    <i class="ti ti-user-check"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('username_or_email') is-invalid @enderror" 
                                       id="username_or_email" 
                                       name="username_or_email" 
                                       value="{{ old('username_or_email') }}" 
                                       required 
                                       autofocus 
                                       placeholder="you@example.com atau username" />
                            </div>
                            @error('username_or_email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">
                                <i class="ti ti-send me-1"></i> Kirim Permintaan Reset Password
                            </button>
                        </div>
                    </form>

                    <p class="text-muted text-center mt-4 mb-0 fs-sm">
                        Ingat kata sandi Anda?
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
@endsection
