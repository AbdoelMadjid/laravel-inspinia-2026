@extends('layouts.app')

@section('title', 'Log Aktivitas Admin & Sistem')

@section('content')
<div class="container-fluid">

    <!-- Header & Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h4 class="fw-bold mb-1"><i class="ti ti-history text-primary me-2"></i> Audit Trail & Log Aktivitas Sistem</h4>
                    <p class="text-muted mb-0 fs-13">Memantau rekam jejak aktivitas administrasi, perubahan data, dan event penting sistem.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-2">
                <!-- Search Input -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari aksi, deskripsi, IP, nama user..." value="{{ request('search') }}">
                </div>

                <!-- Action Select -->
                <div class="col-md-3">
                    <select name="action" class="form-select">
                        <option value="">-- Semua Jenis Aksi --</option>
                        @foreach($actions as $act)
                            <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                                {{ $act }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- User Select -->
                <div class="col-md-3">
                    <select name="user_id" class="form-select">
                        <option value="">-- Semua Admin / User --</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} ({{ $u->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-filter me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'action', 'user_id']))
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-soft-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Log Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 170px;">Waktu & Tanggal</th>
                            <th>Pelaku (User / Admin)</th>
                            <th style="width: 160px;">Jenis Aksi</th>
                            <th>Deskripsi Aktivitas</th>
                            <th style="width: 140px;">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="ps-3 font-monospace fs-12 text-muted">
                                    {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}
                                    <div class="fs-xs text-secondary">{{ $log->created_at ? $log->created_at->diffForHumans() : '' }}</div>
                                </td>
                                <td>
                                    @if($log->user)
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $log->user->avatar_url }}" alt="avatar" class="rounded-circle avatar-xs object-fit-cover" />
                                            <div>
                                                <div class="fw-bold text-dark fs-13">{{ $log->user->name }}</div>
                                                <div class="fs-xs text-muted">{{ $log->user->email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border">Sistem Otomatis</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match(true) {
                                            str_contains($log->action, 'DELETE') => 'bg-danger-subtle text-danger border-danger-subtle',
                                            str_contains($log->action, 'APPROVE') => 'bg-success-subtle text-success border-success-subtle',
                                            str_contains($log->action, 'IMPORT') || str_contains($log->action, 'EXPORT') => 'bg-info-subtle text-info border-info-subtle',
                                            str_contains($log->action, 'UPDATE') => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                            default => 'bg-primary-subtle text-primary border-primary-subtle'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} font-monospace fs-xs">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="fw-medium text-dark">
                                    {{ $log->description }}
                                </td>
                                <td class="font-monospace fs-12 text-muted">
                                    <i class="ti ti-network me-1"></i> {{ $log->ip_address ?? '127.0.0.1' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="ti ti-history-off fs-36 d-block mb-2 text-secondary"></i>
                                    Belum ada log aktivitas yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-0 py-3">
            {{ $logs->links() }}
        </div>
    </div>

</div>
@endsection
