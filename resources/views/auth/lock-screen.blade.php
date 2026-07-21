@extends('layouts.auth')

@section('title', 'Lock Screen | ' . (\App\Models\Admin\System\AppProfile::get()->app_name ?? 'INSPINIA'))

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
                    <h4 class="fw-bold mt-3">Layar Terkunci</h4>
                    <p class="text-muted w-lg-75 mx-auto">Sesi Anda dikunci untuk keamanan. Masukkan kata sandi Anda untuk melanjutkan.</p>
                </div>

                <div class="card p-4 shadow-sm">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block mb-2">
                            <img src="{{ Auth::user()->avatar_url }}" 
                                 class="rounded-circle img-thumbnail avatar-xxl object-fit-cover shadow-sm" 
                                 alt="{{ Auth::user()->name }}" 
                                 style="width: 90px; height: 90px;" />
                            <span class="position-absolute bottom-0 end-0 bg-warning p-1 rounded-circle border border-white" title="Layar Terkunci">
                                <i class="ti ti-lock-filled text-white fs-12"></i>
                            </span>
                        </div>
                        <h5 class="fs-md fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted fs-xs mb-0">{{ Auth::user()->email }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show py-2 px-3 fs-sm" role="alert">
                            <i class="ti ti-alert-circle me-1"></i> {{ $errors->first() }}
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('lock-screen.unlock') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Kata Sandi <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••" 
                                       required 
                                       autofocus />
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">
                                <i class="ti ti-lock-open me-1"></i> Buka Layar
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted fs-sm mb-0">
                            Bukan Anda? 
                            <a href="#" class="text-danger fw-semibold text-decoration-none" onclick="event.preventDefault(); document.getElementById('lockscreen-logout-form').submit();">
                                Keluar Akun <i class="ti ti-logout ms-1"></i>
                            </a>
                        </p>
                        <form id="lockscreen-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
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
