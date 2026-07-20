@extends('layouts.auth')

@section('title', 'Reset Password | INSPINIA')

@section('content')
<div class="auth-box overflow-hidden align-items-center d-flex min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-md-6 col-sm-8">
                <div class="auth-brand text-center mb-4">
                    <a href="{{ route('home') }}" class="logo-dark">
                        <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                    </a>
                    <a href="{{ route('home') }}" class="logo-light">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                    </a>
                    <h4 class="fw-bold mt-3">Reset Password</h4>
                    <p class="text-muted w-lg-75 mx-auto">Please enter your new password below.</p>
                </div>

                <div class="card p-4 shadow-sm">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="you@example.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">Reset Password</button>
                        </div>
                    </form>
                </div>

                <p class="text-center text-muted mt-4 mb-0">
                    © {{ date('Y') }} Inspinia — by <span class="fw-bold">WebAppLayers</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
