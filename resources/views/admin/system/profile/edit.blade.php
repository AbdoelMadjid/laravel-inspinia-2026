@extends('layouts.app')

@section('title', 'Edit Profile | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between py-3">
                <h4 class="mb-sm-0 fw-bold">Edit Profile</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('page', 'profile-page') }}">Profile</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 1: Basic Info & Password (2 Columns Side-by-Side) -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fw-bold text-primary d-flex align-items-center gap-2">
                        <i class="ti ti-user-edit fs-20"></i> Informasi Akun
                    </h5>
                    <a href="{{ route('page', 'profile-page') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="ti ti-arrow-left me-1"></i> Kembali ke Profil
                    </a>
                </div>
                <div class="card-body">
                    @include('admin.system.profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100 mb-0">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="ti ti-lock-check fs-20 text-warning"></i> Perbarui Password
                    </h5>
                </div>
                <div class="card-body">
                    @include('admin.system.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Identitas KTP & Profil Profesional (2 Columns Side-by-Side) -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border h-100 mb-0">
                <div class="card-header bg-light-subtle border-bottom py-3">
                    <h5 class="card-title text-dark mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="ti ti-id fs-20 text-primary"></i> Identitas KTP & Alamat Lengkap
                    </h5>
                </div>
                <div class="card-body">
                    @include('admin.system.profile.partials.update-user-identity-form')
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border h-100 mb-0">
                <div class="card-header bg-light-subtle border-bottom py-3">
                    <h5 class="card-title text-dark mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="ti ti-briefcase fs-20 text-success"></i> Profil Profesional & Tautan Sosial Media
                    </h5>
                </div>
                <div class="card-body">
                    @include('admin.system.profile.partials.update-professional-profile-form')
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Tampilan Header Profil & Hapus Akun (2 Columns Side-by-Side) -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border h-100 mb-0">
                <div class="card-header bg-light-subtle border-bottom py-3">
                    <h5 class="card-title text-dark mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="ti ti-photo-edit fs-20 text-info"></i> Tampilan Header & Banner Profil
                    </h5>
                </div>
                <div class="card-body">
                    @include('admin.system.profile.partials.update-profile-header-form')
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border border-danger-subtle h-100 mb-0">
                <div class="card-header bg-danger-subtle border-bottom border-danger-subtle py-3">
                    <h5 class="card-title text-danger mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="ti ti-alert-triangle fs-20"></i> Hapus Akun (Danger Zone)
                    </h5>
                </div>
                <div class="card-body">
                    @include('admin.system.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
