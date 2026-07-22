@extends('layouts.auth')

@php
    $appProfile = \App\Models\Admin\System\AppProfile::get();
@endphp

@section('title', 'Sistem Dalam Pemeliharaan | ' . $appProfile->app_name)

@section('content')
    <div class="auth-box d-flex align-items-center min-vh-100 py-4">
        <div class="container-xxl">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="card mb-0 rounded-4 shadow-lg border-0">
                        <div class="card-body p-4 p-md-5 text-center">
                            <div class="auth-brand text-center mb-4">
                                <a href="{{ route('home') }}" class="logo-dark">
                                    <img src="{{ $appProfile->logo_dark_url }}" alt="{{ $appProfile->app_name }}"
                                        style="max-height: 48px;" />
                                </a>
                                <a href="{{ route('home') }}" class="logo-light">
                                    <img src="{{ $appProfile->logo_light_url }}" alt="{{ $appProfile->app_name }}"
                                        style="max-height: 48px;" />
                                </a>
                            </div>

                            <div class="mb-4">
                                <div class="w-md-50 mx-auto mb-3">
                                    <img src="{{ asset('assets/images/maintenance.svg') }}" alt="Maintenance Mode"
                                        class="img-fluid" style="max-height: 220px;" />
                                </div>

                                <h3 class="fw-bold text-uppercase text-danger mb-2">Sistem Sedang Dalam Pemeliharaan</h3>
                                <p class="text-muted fs-15 mb-4">
                                    Mohon maaf atas ketidaknyamanan ini. <br> Sistem sedang menjalani proses pemeliharaan &
                                    perbaikan berkala.
                                    <br />
                                    Pengguna biasa tidak dapat mengakses aplikasi untuk sementara waktu.
                                </p>

                                <div
                                    class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis rounded-3 text-start mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-1 fw-bold">
                                        <i class="ti ti-shield-lock fs-18"></i> Akses Khusus Administrator:
                                    </div>
                                    <div class="fs-13">
                                        Jika Anda adalah Administrator, Anda tetap diizinkan untuk masuk ke sistem.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('login') }}"
                                        class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                        <i class="ti ti-lock me-1"></i> Login Administrator
                                    </a>
                                </div>
                            </div>

                            <p class="text-center text-muted mt-4 mb-0 fs-13">
                                © {{ $appProfile->app_year }} <strong>{{ $appProfile->app_name }}</strong> — Developed by
                                <strong>{{ $appProfile->developer_name }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
