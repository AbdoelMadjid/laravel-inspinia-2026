@extends('layouts.app')

@section('title', 'Apps Profile & Brand Identity | INSPINIA')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center justify-content-between py-3">
        <div>
            <h4 class="page-main-title m-0 fw-bold">
                <i class="ti ti-id me-2 text-primary"></i>
                <span data-lang="app-profile-title">Profil Aplikasi &amp; Identitas Logo</span>
            </h4>
            <p class="text-muted mb-0 fs-13" data-lang="app-profile-desc">Kelola nama aplikasi, deskripsi, informasi pengembang, dan logo brand yang tampil di seluruh sistem.</p>
        </div>
        <div>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" data-lang="dashboards">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="apps-management">Apps Management</a></li>
                <li class="breadcrumb-item active" data-lang="apps-profile">Apps Profile</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="ti ti-circle-check fs-20"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="ti ti-alert-circle me-1"></i> Terdapat kesalahan pada input Anda:</div>
            <ul class="mb-0 ps-3 fs-13">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.app-profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Card Identitas & Informasi Aplikasi -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100 mb-0">
                    <div class="card-header bg-light py-3 border-bottom">
                        <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ti ti-info-square-rounded fs-20 text-primary"></i>
                            <span data-lang="app-identity-info">Informasi Identitas Aplikasi</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold"><span data-lang="app-name">Nama Aplikasi</span> <span class="text-danger">*</span></label>
                            <input type="text" name="app_name" class="form-control @error('app_name') is-invalid @enderror" 
                                value="{{ old('app_name', $profile->app_name) }}" required placeholder="Contoh: INSPINIA Laravel 2026">
                            <small class="text-muted">Nama ini akan tampil di title bar, topbar, dan header email.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" data-lang="app-description">Deskripsi Aplikasi</label>
                            <textarea name="app_description" class="form-control @error('app_description') is-invalid @enderror" 
                                rows="3" placeholder="Deskripsi singkat mengenai aplikasi ini...">{{ old('app_description', $profile->app_description) }}</textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><span data-lang="app-year">Tahun Aplikasi</span> <span class="text-danger">*</span></label>
                                <input type="text" name="app_year" class="form-control @error('app_year') is-invalid @enderror" 
                                    value="{{ old('app_year', $profile->app_year) }}" required placeholder="Contoh: 2026">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold"><span data-lang="developer-name">Nama Pengembang / Team</span> <span class="text-danger">*</span></label>
                                <input type="text" name="developer_name" class="form-control @error('developer_name') is-invalid @enderror" 
                                    value="{{ old('developer_name', $profile->developer_name) }}" required placeholder="Contoh: Abdoel Madjid / RPL Team">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" data-lang="developer-url">Link Pengembang (URL Website/GitHub)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-link"></i></span>
                                <input type="url" name="developer_url" class="form-control @error('developer_url') is-invalid @enderror" 
                                    value="{{ old('developer_url', $profile->developer_url) }}" placeholder="https://github.com/AbdoelMadjid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Upload Logo & Brand Identity -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100 mb-0">
                    <div class="card-header bg-light py-3 border-bottom">
                        <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ti ti-photo-edit fs-20 text-success"></i>
                            <span data-lang="upload-logo-title">Upload Logo &amp; Brand Identity</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Logo Light -->
                        <div class="mb-4 p-3 border rounded bg-dark-subtle">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-bold text-dark mb-0"><i class="ti ti-sun me-1 text-warning"></i> <span data-lang="logo-light-label">Logo Light (Background Gelap)</span></label>
                                <span class="badge bg-dark">Navibar Dark</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-dark p-2 rounded text-center" style="min-width: 140px; min-height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ $profile->logo_light_url }}" id="preview_logo_light" alt="Logo Light" style="max-height: 38px; max-width: 130px;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo_light" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'preview_logo_light')">
                                    <small class="text-muted fs-11">Format: PNG, SVG, WEBP, JPG (Max 2MB). Rekomendasi: Teks putih / terang.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Logo Dark -->
                        <div class="mb-4 p-3 border rounded bg-light">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-bold text-dark mb-0"><i class="ti ti-moon me-1 text-primary"></i> <span data-lang="logo-dark-label">Logo Dark (Background Terang)</span></label>
                                <span class="badge bg-secondary">Navibar Light</span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-white p-2 rounded border text-center" style="min-width: 140px; min-height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ $profile->logo_dark_url }}" id="preview_logo_dark" alt="Logo Dark" style="max-height: 38px; max-width: 130px;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo_dark" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'preview_logo_dark')">
                                    <small class="text-muted fs-11">Format: PNG, SVG, WEBP, JPG (Max 2MB). Rekomendasi: Teks gelap / hitam.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Logo Small Icon & Favicon Row -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <label class="form-label fw-bold text-dark mb-2"><i class="ti ti-layout-sidebar-left-collapse me-1 text-info"></i> <span data-lang="logo-sm-label">Logo Small (Icon)</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-dark p-2 rounded text-center">
                                            <img src="{{ $profile->logo_sm_url }}" id="preview_logo_sm" alt="Logo Small" style="height: 28px; width: 28px; object-fit: contain;">
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="logo_sm" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this, 'preview_logo_sm')">
                                        </div>
                                    </div>
                                    <small class="text-muted fs-11">Untuk sidebar mode minimised (28x28 px).</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <label class="form-label fw-bold text-dark mb-2"><i class="ti ti-world me-1 text-success"></i> <span data-lang="favicon-label">Favicon Tab Browser</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="bg-white p-2 border rounded text-center">
                                            <img src="{{ $profile->favicon_url }}" id="preview_favicon" alt="Favicon" style="height: 28px; width: 28px; object-fit: contain;">
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="favicon" class="form-control form-control-sm" accept=".ico,image/*" onchange="previewImage(this, 'preview_favicon')">
                                        </div>
                                    </div>
                                    <small class="text-muted fs-11">Ikon tab browser (.ico, .png, .svg).</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Kebijakan Pendaftaran Akun -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light py-3 border-bottom">
                        <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                            <i class="ti ti-user-plus fs-20 text-info"></i>
                            <span data-lang="registration-policy-title">Kebijakan Pendaftaran Akun</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 bg-light rounded border h-100">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" name="allow_registration" value="1" id="allow_registration" {{ old('allow_registration', $profile->allow_registration) ? 'checked' : '' }}>
                                    <label class="form-check-label cursor-pointer fw-bold" for="allow_registration">
                                        Izinkan Pendaftaran Akun Baru
                                        <small class="text-muted d-block font-normal">Jika dimatikan, halaman registrasi publik `/register` akan ditutup.</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch p-3 bg-light rounded border h-100">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" name="auto_approve_registration" value="1" id="auto_approve_registration" {{ old('auto_approve_registration', $profile->auto_approve_registration) ? 'checked' : '' }}>
                                    <label class="form-check-label cursor-pointer fw-bold" for="auto_approve_registration">
                                        Otomatis Setujui Registrasi Baru
                                        <small class="text-muted d-block font-normal">Jika diaktifkan, pendaftar baru bisa langsung login tanpa menunggu approval admin.</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="default_registration_role" class="form-label fw-bold">Role Default Pendaftar Baru <span class="text-danger">*</span></label>
                                <select name="default_registration_role" id="default_registration_role" class="form-select @error('default_registration_role') is-invalid @enderror" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('default_registration_role', $profile->default_registration_role) === $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text fs-xs text-muted">Role yang diberikan secara otomatis kepada akun yang baru mendaftar.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button Row -->
        <div class="row mt-4 mb-4">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4">
                    <i class="ti ti-device-floppy me-1"></i> <span data-lang="save-profile-btn">Simpan Perubahan Profil &amp; Kebijakan</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
