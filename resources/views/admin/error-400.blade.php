@extends('layouts.auth')

@section('title', '400 Error | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="auth-box overflow-hidden align-items-center d-flex">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-md-6 col-sm-8">
                        <div class="auth-brand text-center mb-3">
                            <a href="{{ route('home') }}/" class="logo-dark">
                                <img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" />
                            </a>
                            <a href="{{ route('home') }}/" class="logo-light">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" />
                            </a>
                        </div>

                        <div class="p-2 text-center">
                            <div class="error-glitch" data-text="400">400</div>
                            <h3 class="fw-bold text-uppercase">Bad Request</h3>
                            <p class="text-muted">Something's not right in the request you made.</p>

                            <button class="btn btn-primary mt-3 rounded-pill" onclick="window.location.href = 'index.html'">Go Home</button>
                        </div>

                        <p class="text-center text-muted mt-5 mb-0">
                            ©
                            <span data-current-year></span>
                            Inspinia — by
                            <span class="fw-bold">WebAppLayers</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- end auth-fluid-->
@endsection
