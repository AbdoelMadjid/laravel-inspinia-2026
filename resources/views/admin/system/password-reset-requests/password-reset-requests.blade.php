@extends('layouts.app')

@section('title', 'Permintaan Reset Password | ' . (\App\Models\Admin\System\AppProfile::get()->app_name ?? 'INSPINIA'))

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between py-2">
                <h4 class="mb-sm-0 fw-bold">Permintaan Reset Password</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Users Setting</li>
                        <li class="breadcrumb-item active">Reset Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Status -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-3 shadow-sm" role="alert">
            <i class="ti ti-check-circle me-1 fs-16"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3 shadow-sm" role="alert">
            <i class="ti ti-alert-circle me-1 fs-16"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
                    <div class="d-flex align-items-center gap-2">
                        <h4 class="card-title mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="ti ti-key text-primary fs-20"></i>
                            <span>Daftar Permintaan Reset Password</span>
                        </h4>
                    </div>

                    <!-- Status Filter Tabs / Search -->
                    <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('admin.password-reset-requests.index') }}" class="btn btn-outline-secondary {{ empty($status) ? 'active' : '' }}">Semua</a>
                            <a href="{{ route('admin.password-reset-requests.index', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ $status === 'pending' ? 'active' : '' }}">Pending</a>
                            <a href="{{ route('admin.password-reset-requests.index', ['status' => 'approved']) }}" class="btn btn-outline-success {{ $status === 'approved' ? 'active' : '' }}">Disetujui</a>
                            <a href="{{ route('admin.password-reset-requests.index', ['status' => 'rejected']) }}" class="btn btn-outline-danger {{ $status === 'rejected' ? 'active' : '' }}">Ditolak</a>
                        </div>

                        <form method="GET" action="{{ route('admin.password-reset-requests.index') }}" class="d-flex gap-1">
                            @if($status)<input type="hidden" name="status" value="{{ $status }}">@endif
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari email/username..." value="{{ request('search') }}" style="width: 200px;">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"></i></button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-uppercase fs-xxs">
                                <tr>
                                    <th class="ps-3" style="width: 50px;">#</th>
                                    <th>Pengguna Ditemukan</th>
                                    <th>Input Email / Username</th>
                                    <th>Waktu Permintaan</th>
                                    <th>IP Address & Device</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-3">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $index => $item)
                                    <tr>
                                        <td class="ps-3 text-muted fs-13">{{ $requests->firstItem() + $index }}</td>
                                        <td>
                                            @if($item->user)
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ $item->user->avatar_url }}" alt="avatar" class="rounded-circle avatar-sm object-fit-cover" style="width: 36px; height: 36px;" />
                                                    <div>
                                                        <h6 class="mb-0 fs-13 fw-bold text-dark">{{ $item->user->name }}</h6>
                                                        <span class="fs-12 text-muted">{{ $item->user->email }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12">
                                                    <i class="ti ti-user-x me-1"></i> Akun Tidak Ditemukan
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-monospace fs-13 fw-semibold text-dark">{{ $item->username_or_email }}</span>
                                        </td>
                                        <td>
                                            <div class="fs-13 fw-semibold text-dark">{{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i:s') : '-' }}</div>
                                            <small class="text-muted fs-12">{{ $item->created_at ? $item->created_at->diffForHumans() : '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="fs-12">
                                                <span class="badge bg-light text-dark border font-monospace">
                                                    <i class="ti ti-network me-1 text-secondary"></i> {{ $item->ip_address ?? '127.0.0.1' }}
                                                </span>
                                            </div>
                                            <small class="text-muted fs-11 text-truncate d-inline-block" style="max-width: 180px;" title="{{ $item->user_agent }}">
                                                {{ $item->user_agent ?? '-' }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            @if($item->status === 'pending')
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-12 rounded-pill">
                                                    <i class="ti ti-clock me-1"></i> Pending
                                                </span>
                                            @elseif($item->status === 'approved')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12 rounded-pill" title="{{ $item->notes }}">
                                                    <i class="ti ti-circle-check me-1"></i> Reset / Disetujui
                                                </span>
                                                @if($item->processor)
                                                    <div class="fs-10 text-muted mt-1">oleh {{ $item->processor->name }}</div>
                                                @endif
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12 rounded-pill">
                                                    <i class="ti ti-circle-x me-1"></i> Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="d-flex align-items-center justify-content-end gap-1">
                                                @if($item->status === 'pending' && $item->user)
                                                    <!-- Form Reset Password Default -->
                                                    <form id="reset-form-{{ $item->id }}" method="POST" action="{{ route('admin.password-reset-requests.reset', $item) }}">
                                                        @csrf
                                                        <input type="hidden" name="default_password" value="password123">
                                                        <button type="button" class="btn btn-sm btn-success fw-semibold" onclick="confirmResetPassword('reset-form-{{ $item->id }}', '{{ addslashes($item->user->name) }}')" title="Reset ke Password Default (password123)">
                                                            <i class="ti ti-key me-1"></i> Reset Password Default
                                                        </button>
                                                    </form>

                                                    <!-- Form Reject -->
                                                    <form id="reject-form-{{ $item->id }}" method="POST" action="{{ route('admin.password-reset-requests.reject', $item) }}">
                                                        @csrf
                                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="confirmReject('reject-form-{{ $item->id }}', '{{ addslashes($item->username_or_email) }}')" title="Tolak Permintaan">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </form>
                                                @elseif($item->status === 'pending' && !$item->user)
                                                    <span class="badge bg-secondary text-white fs-11">User Tidak Ditemukan</span>
                                                @endif

                                                <!-- Form Delete Record -->
                                                <form id="delete-form-{{ $item->id }}" method="POST" action="{{ route('admin.password-reset-requests.destroy', $item) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete('delete-form-{{ $item->id }}')" title="Hapus Riwayat">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted fs-13">
                                            <i class="ti ti-key-off fs-24 mb-1 d-block opacity-50"></i>
                                            Belum ada permintaan reset password.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($requests->hasPages())
                    <div class="card-footer bg-transparent border-top py-3">
                        {{ $requests->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmResetPassword(formId, userName) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Reset Password Default?',
                html: 'Apakah Anda yakin ingin mereset kata sandi akun <strong>' + userName + '</strong> menjadi password default (<code>password123</code>)?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ti ti-key me-1"></i> Ya, Reset Password!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        } else {
            if (confirm('Reset password akun ' + userName + ' menjadi password default (password123)?')) {
                document.getElementById(formId).submit();
            }
        }
    }

    function confirmReject(formId, userName) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Tolak Permintaan?',
                text: 'Apakah Anda yakin ingin menolak permintaan reset password untuk ' + userName + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        } else {
            if (confirm('Tolak permintaan reset password ini?')) {
                document.getElementById(formId).submit();
            }
        }
    }

    function confirmDelete(formId) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Riwayat?',
                text: 'Apakah Anda yakin ingin menghapus riwayat permintaan ini?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        } else {
            if (confirm('Hapus riwayat permintaan ini?')) {
                document.getElementById(formId).submit();
            }
        }
    }
</script>
@endpush
