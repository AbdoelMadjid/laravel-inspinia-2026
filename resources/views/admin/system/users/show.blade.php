@extends('layouts.app')

@section('title', 'Profil User: ' . $user->name . ' | INSPINIA')

@push('styles')
<style>
    .profile-cover-banner {
        height: 220px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .profile-cover-overlay {
        background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.65) 100%);
    }
    .profile-avatar-wrapper {
        margin-top: -55px;
    }
    .profile-avatar-img {
        width: 110px;
        height: 110px;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header & Breadcrumb -->
    <div class="page-title-head d-flex align-items-center mb-3">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0">Profil Lengkap Pengguna</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users Management</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </div>
    </div>

    <!-- Quick Action Bar -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Users
        </a>
        <div class="d-flex align-items-center gap-2">
            @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.impersonate', $user->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-soft-primary btn-sm fw-semibold">
                        <i class="ti ti-arrows-exchange me-1"></i> Switch Akun
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.users.toggle-approval', $user->id) }}" class="d-inline" id="toggle-approval-form">
                    @csrf
                    @method('PATCH')
                    @if($user->is_approved)
                        <button type="button" class="btn btn-soft-warning btn-sm fw-semibold"
                            data-swal-confirm="true"
                            data-swal-title="Nonaktifkan Akun?"
                            data-swal-text="Akun {{ $user->name }} tidak akan bisa login sampai disetujui kembali."
                            data-swal-icon="warning"
                            data-swal-confirm-text="Ya, Nonaktifkan!"
                            data-form-id="toggle-approval-form">
                            <i class="ti ti-ban me-1"></i> Nonaktifkan Akun
                        </button>
                    @else
                        <button type="button" class="btn btn-success btn-sm fw-semibold"
                            data-swal-confirm="true"
                            data-swal-title="Setujui Akun Pengguna?"
                            data-swal-text="Akun {{ $user->name }} akan disetujui dan diizinkan untuk login."
                            data-swal-icon="info"
                            data-swal-confirm-text="Ya, Setujui Akun!"
                            data-form-id="toggle-approval-form">
                            <i class="ti ti-check me-1"></i> Setujui Akun
                        </button>
                    @endif
                </form>
            @endif

            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal">
                <i class="ti ti-edit me-1"></i> Edit Data User
            </button>
        </div>
    </div>

    <!-- Header Card Banner -->
    <div class="row">
        <div class="col-12">
            <div class="card overflow-hidden border shadow-sm mb-4">
                <div class="profile-cover-banner" style="background-image: url('{{ $profile->cover_image_url }}');">
                    <div class="p-4 profile-cover-overlay h-100 d-flex align-items-end justify-content-center">
                        <h4 class="text-white mb-2 fst-italic text-center text-shadow">
                            "{{ $profile->motto ?: 'Designing the future, one template at a time' }}"
                        </h4>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row align-items-end">
                        <div class="col-md-auto text-center text-md-start">
                            <div class="profile-avatar-wrapper position-relative d-inline-block">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle profile-avatar-img object-fit-cover" />
                                @if($user->isOnline())
                                    <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-3 border-white rounded-circle shadow-sm" title="Online Sekarang" data-bs-toggle="tooltip"></span>
                                @else
                                    <span class="position-absolute bottom-0 end-0 p-2 bg-secondary border border-3 border-white rounded-circle shadow-sm" title="{{ $user->last_seen_text }}" data-bs-toggle="tooltip"></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md mt-3 mt-md-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div>
                                    <h3 class="fw-bold text-dark mb-1">{{ $user->name }}</h3>
                                    <p class="text-muted fs-14 mb-2 d-flex align-items-center gap-2 flex-wrap">
                                        <span><i class="ti ti-mail me-1"></i>{{ $user->email }}</span>
                                        <span>•</span>
                                        <span><i class="ti ti-briefcase me-1"></i>{{ $profile->job_title ?: 'User System' }}</span>
                                        <span>•</span>
                                        <span><i class="ti ti-map-pin me-1"></i>{{ $profile->location ?: 'Indonesia' }}</span>
                                    </p>
                                </div>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <!-- Roles -->
                                    @if($user->roles->isNotEmpty())
                                        @foreach($user->roles as $r)
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-12 rounded-pill">
                                                <i class="ti ti-user-shield me-1"></i>{{ ucfirst($r->name) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 fs-12 rounded-pill">No Role</span>
                                    @endif

                                    <!-- Status Persetujuan -->
                                    @if($user->hasRequestedDeletion())
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-12 rounded-pill">
                                            <i class="ti ti-alert-triangle me-1"></i> Permohonan Hapus
                                        </span>
                                    @elseif($user->is_approved)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-12 rounded-pill">
                                            <i class="ti ti-circle-check me-1"></i> Disetujui / Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 fs-12 rounded-pill">
                                            <i class="ti ti-clock me-1"></i> Menunggu Persetujuan
                                        </span>
                                    @endif

                                    <!-- Points -->
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 fs-12 rounded-pill" title="Total Poin Login Harian">
                                        <i class="ti ti-star-filled me-1"></i> {{ $user->points ?? 0 }} Poin
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs nav-tabs-custom nav-justified bg-light-subtle rounded border p-1 mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold" id="tab-overview-tab" data-bs-toggle="tab" data-bs-target="#tab-overview" type="button" role="tab">
                        <i class="ti ti-user me-1 fs-18"></i> Ringkasan & Akun System
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="tab-ktp-tab" data-bs-toggle="tab" data-bs-target="#tab-ktp" type="button" role="tab">
                        <i class="ti ti-id me-1 fs-18"></i> Data KTP & Alamat Lengkap
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="tab-professional-tab" data-bs-toggle="tab" data-bs-target="#tab-professional" type="button" role="tab">
                        <i class="ti ti-briefcase me-1 fs-18"></i> Profil Profesional & Kontak
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold" id="tab-roles-tab" data-bs-toggle="tab" data-bs-target="#tab-roles" type="button" role="tab">
                        <i class="ti ti-shield-lock me-1 fs-18"></i> Peran & Hak Akses
                    </button>
                </li>
            </ul>

            <div class="tab-content mb-4">
                <!-- TAB 1: Ringkasan & Akun System -->
                <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                    <div class="row g-4 mb-4">
                        <div class="col-lg-4">
                            <!-- Quick Info Cards -->
                            <div class="card border shadow-sm mb-4">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-14 fw-bold"><i class="ti ti-info-circle me-1 text-primary"></i> Status Sistem</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush fs-13">
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                            <span class="text-muted"><i class="ti ti-hash me-1"></i> ID User:</span>
                                            <span class="fw-bold text-dark">#{{ $user->id }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                            <span class="text-muted"><i class="ti ti-activity me-1"></i> Status Keaktifan:</span>
                                            @if($user->isOnline())
                                                <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="ti ti-circle-filled me-1 fs-10"></i> Online Sekarang</span>
                                            @else
                                                <span class="text-muted fs-12">{{ $user->last_seen_text }}</span>
                                            @endif
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                            <span class="text-muted"><i class="ti ti-star me-1"></i> Poin Harian:</span>
                                            <span class="fw-bold text-warning">{{ $user->points ?? 0 }} Poin</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                            <span class="text-muted"><i class="ti ti-calendar me-1"></i> Bergabung Pada:</span>
                                            <span class="fw-semibold text-dark">{{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                            <span class="text-muted"><i class="ti ti-clock me-1"></i> Terakhir Diperbarui:</span>
                                            <span class="fw-semibold text-dark">{{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : '-' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if($user->hasRequestedDeletion())
                                <div class="card border border-danger shadow-sm mb-4">
                                    <div class="card-header bg-danger text-white py-2">
                                        <h5 class="card-title mb-0 fs-14 text-white fw-bold"><i class="ti ti-alert-triangle me-1"></i> Permohonan Penghapusan Akun</h5>
                                    </div>
                                    <div class="card-body bg-danger-subtle text-danger">
                                        <p class="fs-13 mb-2">User ini mengajukan permohonan penghapusan akun pada <strong>{{ $user->deletion_requested_at->format('d M Y H:i') }}</strong>.</p>
                                        @if($user->deletion_reason)
                                            <p class="fs-13 bg-white p-2 rounded border border-danger-subtle mb-3">
                                                <strong>Alasan:</strong> "{{ $user->deletion_reason }}"
                                            </p>
                                        @endif
                                        <form method="POST" action="{{ route('admin.users.cancel-deletion-request', $user->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-semibold">
                                                <i class="ti ti-rotate-clockwise me-1"></i> Batalkan Permohonan Hapus Akun
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-8">
                            <div class="card border shadow-sm mb-4">
                                <div class="card-header bg-light py-2 d-flex align-items-center justify-content-between">
                                    <h5 class="card-title mb-0 fs-14 fw-bold"><i class="ti ti-user-check me-1 text-primary"></i> Rincian Akun Pengguna</h5>
                                    <button type="button" class="btn btn-xs btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal">
                                        <i class="ti ti-edit me-1"></i> Edit Akun
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle mb-0">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 30%;" class="bg-light-subtle text-muted">Nama Lengkap</th>
                                                    <td class="fw-bold text-dark fs-15">{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light-subtle text-muted">Alamat Email</th>
                                                    <td>
                                                        <span class="fw-semibold text-dark me-2">{{ $user->email }}</span>
                                                        @if($user->email_verified_at)
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle fs-11"><i class="ti ti-check me-1"></i> Terverifikasi ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                                                        @else
                                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-11"><i class="ti ti-alert-circle me-1"></i> Belum Verifikasi</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light-subtle text-muted">Peran / Role System</th>
                                                    <td>
                                                        @if($user->roles->isNotEmpty())
                                                            @foreach($user->roles as $r)
                                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle me-1 px-2 py-1 fs-12">{{ ucfirst($r->name) }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">Belum ada role</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light-subtle text-muted">Motto Profil</th>
                                                    <td class="fst-italic text-dark">"{{ $profile->motto ?: '-' }}"</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light-subtle text-muted">Biografi / About Me</th>
                                                    <td class="text-dark">{{ $profile->about_me ?: 'Belum diisi oleh pengguna.' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Data KTP & Alamat Lengkap -->
                <div class="tab-pane fade" id="tab-ktp" role="tabpanel">
                    <div class="row g-4 mb-4">
                        <div class="col-lg-6">
                            <div class="card border shadow-sm h-100 mb-0">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-14 fw-bold text-primary"><i class="ti ti-id-badge-2 me-1"></i> Data Identitas KTP / NIK</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width: 40%;" class="text-muted fs-13">NIK KTP</th>
                                                <td class="fw-bold text-dark fs-14"><code>{{ $profile->nik ?: 'Belum diisi' }}</code></td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Tempat Lahir</th>
                                                <td class="fw-semibold text-dark">{{ $profile->birth_place ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Tanggal Lahir</th>
                                                <td class="fw-semibold text-dark">
                                                    @if($profile->birth_date)
                                                        {{ $profile->birth_date->format('d F Y') }}
                                                        <small class="text-muted">({{ $profile->birth_date->age }} tahun)</small>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Jenis Kelamin</th>
                                                <td class="fw-semibold text-dark">{{ $profile->gender ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Agama</th>
                                                <td class="fw-semibold text-dark">{{ $profile->religion ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Status Perkawinan</th>
                                                <td class="fw-semibold text-dark">{{ $profile->marital_status ?: '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card border shadow-sm h-100 mb-0">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-14 fw-bold text-success"><i class="ti ti-map-pins me-1"></i> Alamat Lengkap Sesuai KTP</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 p-3 bg-light-subtle rounded border">
                                        <small class="text-muted d-block fw-semibold mb-1">Alamat Terformat Lengkap:</small>
                                        <p class="mb-0 fw-bold text-dark fs-14">{{ $profile->full_address ?: 'Belum mengisi rincian alamat lengkap.' }}</p>
                                    </div>
                                    <table class="table table-sm align-middle mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width: 40%;" class="text-muted fs-13">Jalan / No. Rumah</th>
                                                <td class="fw-semibold text-dark">{{ $profile->address ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">RT / RW</th>
                                                <td class="fw-semibold text-dark">RT {{ $profile->rt ?: '-' }} / RW {{ $profile->rw ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Kelurahan / Desa</th>
                                                <td class="fw-semibold text-dark">{{ $profile->village ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Kecamatan</th>
                                                <td class="fw-semibold text-dark">{{ $profile->district ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Kota / Kabupaten</th>
                                                <td class="fw-semibold text-dark">{{ $profile->city_regency ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Provinsi</th>
                                                <td class="fw-semibold text-dark">{{ $profile->province ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fs-13">Kode Pos</th>
                                                <td class="fw-semibold text-dark">{{ $profile->postal_code ?: '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: Profil Profesional & Kontak -->
                <div class="tab-pane fade" id="tab-professional" role="tabpanel">
                    <div class="row g-4 mb-4">
                        <div class="col-lg-6">
                            <div class="card border shadow-sm h-100 mb-0">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-14 fw-bold text-info"><i class="ti ti-briefcase me-1"></i> Rincian Karir & Keahlian</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="text-muted fs-13 d-block">Pekerjaan / Jabatan:</label>
                                        <span class="fw-bold text-dark fs-15">{{ $profile->job_title ?: '-' }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted fs-13 d-block">Pendidikan Terakhir:</label>
                                        <span class="fw-semibold text-dark fs-14">{{ $profile->education ?: '-' }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted fs-13 d-block">Bahasa yang Dikuasai:</label>
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            @forelse($profile->languages_list as $lang)
                                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 fs-12">{{ $lang }}</span>
                                            @empty
                                                <span class="text-muted fs-13">-</span>
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted fs-13 d-block">Keahlian & Skills:</label>
                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                            @forelse($profile->skills_list as $skill)
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-12 rounded-pill">{{ $skill }}</span>
                                            @empty
                                                <span class="text-muted fs-13">-</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card border shadow-sm h-100 mb-0">
                                <div class="card-header bg-light py-2">
                                    <h5 class="card-title mb-0 fs-14 fw-bold text-warning"><i class="ti ti-phone me-1"></i> Kontak & Tautan Sosial Media</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless align-middle mb-3">
                                        <tbody>
                                            <tr>
                                                <td style="width: 40px;" class="text-center"><i class="ti ti-phone fs-20 text-success"></i></td>
                                                <td class="text-muted fs-13">Nomor Telepon:</td>
                                                <td class="fw-bold text-dark">{{ $profile->phone ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="ti ti-world fs-20 text-primary"></i></td>
                                                <td class="text-muted fs-13">Situs Web:</td>
                                                <td>
                                                    @if($profile->website)
                                                        <a href="{{ str_starts_with($profile->website, 'http') ? $profile->website : 'https://' . $profile->website }}" target="_blank" class="fw-semibold text-primary">
                                                            {{ $profile->website }} <i class="ti ti-external-link fs-12 ms-1"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><i class="ti ti-map-pin fs-20 text-danger"></i></td>
                                                <td class="text-muted fs-13">Lokasi / Kota:</td>
                                                <td class="fw-semibold text-dark">{{ $profile->location ?: '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h6 class="fw-bold text-dark fs-13 mb-2 border-top pt-3">Sosial Media & Portfolio:</h6>
                                    @php
                                        $socials = $profile->social_links ?? [];
                                    @endphp
                                    <div class="row g-2">
                                        @foreach(['facebook' => ['brand-facebook', 'Facebook', 'text-primary'], 'twitter' => ['brand-x', 'Twitter / X', 'text-dark'], 'instagram' => ['brand-instagram', 'Instagram', 'text-danger'], 'linkedin' => ['brand-linkedin', 'LinkedIn', 'text-info'], 'github' => ['brand-github', 'GitHub', 'text-dark'], 'youtube' => ['brand-youtube', 'YouTube', 'text-danger']] as $key => $iconData)
                                            @if(!empty($socials[$key]))
                                                <div class="col-6">
                                                    <a href="{{ $socials[$key] }}" target="_blank" class="btn btn-light btn-sm w-100 text-start d-flex align-items-center gap-2 border">
                                                        <i class="ti ti-{{ $iconData[0] }} fs-18 {{ $iconData[2] }}"></i>
                                                        <span class="fs-12 text-truncate">{{ $iconData[1] }}</span>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if(empty(array_filter($socials)))
                                            <p class="text-muted fs-13 mb-0">Belum ada tautan media sosial yang ditambahkan.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: Peran & Hak Akses -->
                <div class="tab-pane fade" id="tab-roles" role="tabpanel">
                    <div class="card border shadow-sm mb-4">
                        <div class="card-header bg-light py-2">
                            <h5 class="card-title mb-0 fs-14 fw-bold text-primary"><i class="ti ti-shield-check me-1"></i> Peran (Roles) & Hak Akses (Permissions)</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark fs-14 mb-2">Peran yang Dimiliki (Assigned Roles):</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @forelse($user->roles as $r)
                                        <div class="p-3 bg-light-subtle rounded border d-flex align-items-center gap-2">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                                {{ strtoupper(substr($r->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold text-dark">{{ ucfirst($r->name) }}</h6>
                                                <small class="text-muted fs-11">Guard: {{ $r->guard_name }}</small>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted fs-13">Pengguna belum memiliki peran (role) dalam sistem.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <h6 class="fw-bold text-dark fs-14 mb-2">Daftar Hak Akses (Permissions):</h6>
                                @php
                                    $permissions = $user->getAllPermissions();
                                @endphp
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($permissions as $perm)
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 fs-12">
                                            <i class="ti ti-key me-1"></i>{{ $perm->name }}
                                        </span>
                                    @empty
                                        <p class="text-muted fs-13 mb-0">Tidak ada hak akses khusus yang ditetapkan untuk pengguna ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reusable Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-user-edit me-1"></i> Edit Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Avatar</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="{{ $user->avatar_url }}" class="rounded-circle avatar-md object-fit-cover" style="width: 48px; height: 48px;" alt="Avatar Preview">
                            <input type="file" name="avatar" class="form-control" accept="image/*" />
                        </div>
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto avatar.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter..." />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Roles / Peran System</label>
                        <div class="row g-2 bg-light p-2 rounded border">
                            @foreach ($roles as $r)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $r->name }}" id="show_edit_role_{{ $r->id }}" {{ $user->hasRole($r->name) ? 'checked' : '' }}>
                                        <label class="form-check-label cursor-pointer" for="show_edit_role_{{ $r->id }}">
                                            {{ ucfirst($r->name) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
