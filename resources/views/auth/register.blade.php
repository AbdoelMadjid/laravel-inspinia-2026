@extends('layouts.auth')

@section('title', 'Create New Account | INSPINIA')

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
                    <h4 class="fw-bold mt-3">Create New Account</h4>
                    <p class="text-muted w-lg-75 mx-auto">Let’s get you started. Create your account by entering your details below.</p>
                </div>

                <div class="card p-4 shadow-sm">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">Create Account</button>
                        </div>
                    </form>

                    <p class="text-muted text-center mt-4 mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-decoration-underline link-offset-3 fw-semibold">Sign In</a>
                    </p>
                </div>

                <p class="text-center text-muted mt-4 mb-0">
                    © {{ date('Y') }} Inspinia — by <span class="fw-bold">WebAppLayers</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
