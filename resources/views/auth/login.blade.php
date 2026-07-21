@extends('layouts.auth')

@section('title', 'Sign In | INSPINIA')

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
                    <h4 class="fw-bold mt-3">Welcome Back</h4>
                    <p class="text-muted w-lg-75 mx-auto">Let’s get you signed in. Enter your email and password to continue.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <i class="ti ti-check me-1"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show mb-3 d-flex align-items-center" role="alert">
                        <i class="ti ti-alert-triangle fs-18 me-2"></i>
                        <div>{{ session('warning') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-3 d-flex align-items-center" role="alert">
                        <i class="ti ti-alert-circle fs-18 me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show mb-3 d-flex align-items-center" role="alert">
                        <i class="ti ti-info-circle fs-18 me-2"></i>
                        <div>{{ session('info') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card p-4 shadow-sm">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember" />
                                <label class="form-check-label" for="remember_me">Keep me signed in</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-underline link-offset-3 text-muted">Forgot Password?</a>
                            @endif
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">Sign In</button>
                        </div>
                    </form>

                    @if (Route::has('register'))
                        <p class="text-muted text-center mt-4 mb-0">
                            New here?
                            <a href="{{ route('register') }}" class="text-decoration-underline link-offset-3 fw-semibold">Create an account</a>
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
@endsection
