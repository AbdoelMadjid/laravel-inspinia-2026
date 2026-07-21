@extends('layouts.auth')

@section('title', 'Forgot Password | INSPINIA')

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
                    <h4 class="fw-bold mt-3">Forgot Password?</h4>
                    <p class="text-muted w-lg-75 mx-auto">Enter your email address and we'll send you a password reset link.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card p-4 shadow-sm">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">Email Password Reset Link</button>
                        </div>
                    </form>

                    <p class="text-muted text-center mt-4 mb-0">
                        Remember your password?
                        <a href="{{ route('login') }}" class="text-decoration-underline link-offset-3 fw-semibold">Sign In</a>
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
