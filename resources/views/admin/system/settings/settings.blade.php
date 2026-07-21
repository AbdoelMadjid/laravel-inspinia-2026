@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="container-fluid">

    <!-- Header & Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="ti ti-settings text-primary me-2"></i> Pengaturan Global Aplikasi</h4>
                    <p class="text-muted mb-0 fs-13">Atur konfigurasi identitas aplikasi, pendaftaran pengguna, dan preferensi sistem.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-3" role="alert">
            <i class="ti ti-check-circle fs-20 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <!-- Left Column: Identitas Aplikasi -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title fw-bold m-0"><i class="ti ti-building-store text-primary me-1"></i> Identitas & Branding Aplikasi</h5>
                    </div>
                    <div class="card-body">
                        <!-- App Name -->
                        <div class="mb-3">
                            <label for="app_name" class="form-label fw-bold">Nama Aplikasi / Website <span class="text-danger">*</span></label>
                            <input type="text" name="app_name" id="app_name" class="form-control @error('app_name') is-invalid @enderror" value="{{ old('app_name', $settings['app_name']) }}" required>
                            @error('app_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- App Description -->
                        <div class="mb-3">
                            <label for="app_description" class="form-label fw-bold">Deskripsi Singkat Aplikasi</label>
                            <textarea name="app_description" id="app_description" rows="3" class="form-control @error('app_description') is-invalid @enderror">{{ old('app_description', $settings['app_description']) }}</textarea>
                            @error('app_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Footer Text -->
                        <div class="mb-3">
                            <label for="footer_text" class="form-label fw-bold">Teks Hak Cipta Footer</label>
                            <input type="text" name="footer_text" id="footer_text" class="form-control @error('footer_text') is-invalid @enderror" value="{{ old('footer_text', $settings['footer_text']) }}">
                            @error('footer_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- App Logo Upload -->
                        <div class="mb-3">
                            <label for="app_logo" class="form-label fw-bold">Logo Aplikasi</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset($settings['app_logo']) }}" alt="Logo App" class="img-thumbnail rounded bg-light p-2" style="max-height: 50px;">
                                <div class="flex-grow-1">
                                    <input type="file" name="app_logo" id="app_logo" class="form-control @error('app_logo') is-invalid @enderror" accept="image/png,image/jpeg,image/svg+xml">
                                    <div class="form-text fs-xs">Format: PNG, JPG, SVG. Ukuran maks 2MB.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Pendaftaran & Role Default -->
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title fw-bold m-0"><i class="ti ti-user-plus text-primary me-1"></i> Kebijakan Pendaftaran Akun</h5>
                    </div>
                    <div class="card-body">
                        <!-- Allow Registration Toggle -->
                        <div class="form-check form-switch p-3 bg-light rounded border mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" name="allow_registration" value="1" id="allow_registration" {{ $settings['allow_registration'] ? 'checked' : '' }}>
                            <label class="form-check-label cursor-pointer ms-2 fw-bold" for="allow_registration">
                                Izinkan Pendaftaran Akun Baru
                                <small class="text-muted d-block font-normal">Jika dimatikan, halaman registrasi publik `/register` akan ditutup.</small>
                            </label>
                        </div>

                        <!-- Auto Approve Toggle -->
                        <div class="form-check form-switch p-3 bg-light rounded border mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" name="auto_approve_registration" value="1" id="auto_approve_registration" {{ $settings['auto_approve_registration'] ? 'checked' : '' }}>
                            <label class="form-check-label cursor-pointer ms-2 fw-bold" for="auto_approve_registration">
                                Otomatis Setujui Registrasi Baru
                                <small class="text-muted d-block font-normal">Jika diaktifkan, pendaftar baru bisa langsung login tanpa menunggu approval admin.</small>
                            </label>
                        </div>

                        <!-- Default Role Select -->
                        <div class="mb-3">
                            <label for="default_registration_role" class="form-label fw-bold">Role Default Pendaftar Baru <span class="text-danger">*</span></label>
                            <select name="default_registration_role" id="default_registration_role" class="form-select @error('default_registration_role') is-invalid @enderror" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $settings['default_registration_role'] === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text fs-xs text-muted">Role yang diberikan secara otomatis kepada akun yang baru mendaftar.</div>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                        <i class="ti ti-device-floppy me-1"></i> Simpan Pengaturan Sistem
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
