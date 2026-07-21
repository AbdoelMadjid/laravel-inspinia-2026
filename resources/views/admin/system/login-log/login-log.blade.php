@extends('layouts.app')

@section('title', 'Data Login | INSPINIA')
@section('title_lang', 'title-apps-login-logs')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0" data-lang="apps-login-logs">Data Login</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="apps-management">Apps Management</a></li>
                <li class="breadcrumb-item active" data-lang="apps-login-logs">Data Login</li>
            </ol>
        </div>
    </div>

    <!-- Quick Stats Widgets -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-md bg-primary-subtle text-primary rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-login-2 fs-24"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-12 mb-1">Total Login</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['total_logins']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-md bg-warning-subtle text-warning rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-star fs-24"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-12 mb-1">Poin Diberikan</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['total_points_awarded']) }} <span class="fs-14 fw-normal text-muted">Pts</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-md bg-success-subtle text-success rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-calendar-event fs-24"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-12 mb-1">Login Hari Ini</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['logins_today']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar-md bg-info-subtle text-info rounded me-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-users fs-24"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-12 mb-1">User Aktif Hari Ini</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($stats['unique_users_today']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions & Filter Card -->
    <div class="card shadow-sm border-0">
        <!-- Card Header: Title & Status Badge -->
        <div class="card-header bg-transparent border-bottom py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h5 class="card-title mb-0 d-flex align-items-center gap-2">
                <i class="ti ti-history text-primary fs-20"></i>
                <span>Riwayat Aktivitas Login</span>
            </h5>
            <div>
                <span class="badge bg-light text-muted border px-2.5 py-1.5 fs-12 d-inline-flex align-items-center gap-1">
                    <i class="ti ti-lock fs-14"></i> Audit Log Permanen
                </span>
            </div>
        </div>

        <!-- Filter Bar: Separated below header title, aligned right, and formatted inline -->
        <div class="p-3 bg-light-subtle border-bottom">
            <form method="GET" action="{{ route('admin.login-logs.index') }}" class="m-0">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    <!-- Search Input -->
                    <div class="input-group input-group-sm flex-grow-1 flex-md-grow-0" style="min-width: 200px; max-width: 260px;">
                        <span class="input-group-text bg-white border-end-0"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control form-control-sm border-start-0" placeholder="Cari nama, email, IP..." value="{{ request('search') }}">
                    </div>

                    <!-- Date Filter -->
                    <div class="input-group input-group-sm" style="width: 175px;">
                        <span class="input-group-text bg-white border-end-0" title="Filter Tanggal"><i class="ti ti-calendar text-muted"></i></span>
                        <input type="date" name="date" class="form-control form-control-sm border-start-0" value="{{ request('date', now()->toDateString()) }}" title="Filter Tanggal Login">
                    </div>

                    <!-- Role Dropdown -->
                    <div style="width: 150px;">
                        <select name="role" class="form-select form-select-sm bg-white">
                            <option value="">-- Semua Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                                    Role: {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Points Dropdown -->
                    <div style="width: 150px;">
                        <select name="points" class="form-select form-select-sm bg-white">
                            <option value="">-- Semua Poin --</option>
                            <option value="1" {{ request('points') === '1' ? 'selected' : '' }}>+1 Poin Harian</option>
                            <option value="0" {{ request('points') === '0' ? 'selected' : '' }}>0 Poin (Login Ulang)</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center gap-1">
                        <button type="submit" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                            <i class="ti ti-filter fs-14"></i> Filter
                        </button>
                        <a href="{{ route('admin.login-logs.index', ['date' => '']) }}" class="btn btn-outline-secondary btn-sm" title="Tampilkan Semua Tanggal">
                            Semua Tanggal
                        </a>
                        @if(request()->hasAny(['search', 'role', 'points']) || request('date') !== now()->toDateString())
                            <a href="{{ route('admin.login-logs.index') }}" class="btn btn-light btn-sm" title="Reset Ke Hari Ini">
                                <i class="ti ti-refresh fs-14"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;" class="ps-3">#</th>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>IP Address</th>
                            <th>User Agent / Perangkat</th>
                            <th class="text-center">Poin Login Harian</th>
                            <th class="pe-3">Waktu Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                            <tr>
                                <td class="ps-3 text-muted fs-13">
                                    {{ $logs->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ optional($log->user)->avatar_url ?? asset('assets/images/users/user-1.jpg') }}" alt="Avatar" class="avatar-sm rounded-circle me-2 object-fit-cover" style="width: 36px; height: 36px;">
                                        <div>
                                            <h6 class="mb-0 fs-14 fw-semibold text-dark">
                                                {{ optional($log->user)->name ?? 'User Terhapus' }}
                                            </h6>
                                            <small class="text-muted fs-12 d-block">
                                                {{ optional($log->user)->email ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1 align-items-center" style="max-width: 220px;">
                                        @if(optional($log->user)->roles && $log->user->roles->count() > 0)
                                            @foreach($log->user->roles as $role)
                                                <span class="badge bg-info-subtle text-info border border-info-subtle fs-11 px-2 py-0.5 rounded-pill">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary fs-11 px-2 py-0.5 rounded-pill">User</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">
                                        <i class="ti ti-network me-1 text-secondary"></i> {{ $log->ip_address ?? '127.0.0.1' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block text-muted fs-12" style="max-width: 280px;" title="{{ $log->user_agent }}">
                                        {{ $log->user_agent ?? 'Unknown' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($log->points_awarded > 0)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12 rounded-pill d-inline-flex align-items-center gap-1">
                                            <i class="ti ti-star-filled fs-12"></i> +{{ $log->points_awarded }} Poin
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 fs-12 rounded-pill">
                                            0 Poin (Login Ulang)
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-3">
                                    <div class="fs-13 fw-medium text-dark">
                                        {{ $log->login_at ? $log->login_at->translatedFormat('d M Y, H:i:s') : '-' }}
                                    </div>
                                    <small class="text-muted fs-12">
                                        {{ $log->login_at ? $log->login_at->diffForHumans() : '-' }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-history-off fs-48 mb-2 d-block text-secondary opacity-50"></i>
                                        <h6 class="fw-semibold mb-1">Belum ada riwayat data login</h6>
                                        <p class="fs-13 mb-0">Tidak ditemukan catatan riwayat login untuk filter yang dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($logs->hasPages())
            <div class="card-footer bg-transparent border-top py-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="text-muted fs-13">
                        Menampilkan {{ $logs->firstItem() ?? 0 }} sampai {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} total log
                    </div>
                    <div>
                        {{ $logs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
