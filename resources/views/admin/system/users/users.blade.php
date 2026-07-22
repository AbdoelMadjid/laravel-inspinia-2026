@extends('layouts.app')

@section('title', 'Users Management | INSPINIA')
@section('title_lang', 'title-users-management')

@push('styles')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dt-processing,
        #usersTable_processing {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(227, 230, 240, 0.8);
            border-radius: 50%;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            width: 56px !important;
            height: 56px !important;
            padding: 0 !important;
            z-index: 1050 !important;
            margin: 0 !important;
        }

        .dt-processing .spinner-border,
        #usersTable_processing .spinner-border {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -0.875rem;
            margin-left: -0.875rem;
        }

        .dt-processing>div:not(.spinner-border) {
            display: none !important;
        }

        table.dataTable tbody td {
            vertical-align: middle;
        }

        .dt-search,
        .dataTables_filter {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="page-main-title m-0" data-lang="users-management">Users Management</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="users-management">Users
                            Management</a></li>
                    <li class="breadcrumb-item active" data-lang="users-contacts">Users</li>
                </ol>
            </div>
        </div>

        <!-- Search & Action Bar -->
        <div class="row mt-3 mb-3">
            <div class="col-lg-12">
                <div class="bg-light-subtle rounded border p-3">
                    <form id="filterForm" class="row g-2 align-items-center" onsubmit="return false;">
                        <div class="col-lg-2">
                            <div class="app-search">
                                <input type="text" id="customSearchInput" class="form-control"
                                    placeholder="Search user name or email..." value="{{ request('search') }}" />
                                <i class="ti ti-search app-search-icon text-muted"></i>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="app-search">
                                <select id="customRoleSelect" class="form-select form-control">
                                    <option value="">All Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="ti ti-user-check app-search-icon text-muted"></i>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" id="resetFilterBtn" class="btn btn-soft-secondary btn-sm py-2">
                                <i class="ti ti-refresh me-1"></i> Reset Filter
                            </button>
                        </div>
                        <div class="col text-end d-flex align-items-center justify-content-end gap-2">
                            <!-- Bulk Action Buttons -->
                            <button type="button" class="btn btn-outline-primary btn-sm d-none" id="bulkAssignRoleBtn"
                                data-bs-toggle="modal" data-bs-target="#bulkAssignRoleModal">
                                <i class="ti ti-user-shield me-1"></i> Role (<span class="selectedUserCount">0</span>)
                            </button>

                            <button type="button" class="btn btn-outline-success btn-sm d-none" id="bulkApproveBtn"
                                onclick="submitBulkApprove()">
                                <i class="ti ti-check me-1"></i> Setujui (<span class="selectedUserCount">0</span>)
                            </button>

                            <button type="button" class="btn btn-outline-danger btn-sm d-none" id="bulkDeleteBtn"
                                onclick="submitBulkDelete()">
                                <i class="ti ti-trash me-1"></i> Hapus (<span class="selectedUserCount">0</span>)
                            </button>

                            <!-- Import Massal Button -->
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#importUsersModal">
                                <i class="ti ti-file-upload me-1"></i> Import Massal
                            </button>

                            <!-- Export Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-download me-1"></i> Export Data
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.users.export-excel', request()->query()) }}">
                                            <i class="ti ti-file-spreadsheet text-success me-2 fs-16"></i> Export Excel
                                            (.xlsx)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.users.export-pdf', request()->query()) }}"
                                            target="_blank">
                                            <i class="ti ti-printer text-danger me-2 fs-16"></i> Cetak / Export PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addUserModal">
                                <i class="ti ti-plus me-1"></i> Add New User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Status Tabs Filter -->
        <div class="d-flex align-items-center flex-wrap gap-1 mb-3">
            <a href="{{ route('admin.users.index') }}"
                class="btn btn-sm {{ empty($status) ? 'btn-primary' : 'btn-outline-secondary' }}">
                <i class="ti ti-users me-1"></i> Semua Pengguna
            </a>
            <a href="{{ route('admin.users.index', ['status' => 'approved']) }}"
                class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                <i class="ti ti-circle-check me-1"></i> Disetujui / Aktif
            </a>
            <a href="{{ route('admin.users.index', ['status' => 'pending']) }}"
                class="btn btn-sm {{ $status === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                <i class="ti ti-clock me-1"></i> Menunggu Persetujuan
            </a>
            <a href="{{ route('admin.users.index', ['status' => 'deletion_requested']) }}"
                class="btn btn-sm {{ $status === 'deletion_requested' ? 'btn-danger' : 'btn-outline-danger' }}">
                <i class="ti ti-user-x me-1"></i> Permohonan Hapus Akun
                @php
                    $deletionReqCount = \App\Models\Admin\System\User::whereNotNull('deletion_requested_at')->count();
                @endphp
                @if($deletionReqCount > 0)
                    <span class="badge bg-danger text-white rounded-pill ms-1">{{ $deletionReqCount }}</span>
                @endif
            </a>
        </div>

        <!-- DataTables Card (Matching Menus Style Pattern) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light d-flex align-items-center justify-content-between py-2">
                        <h5 class="card-title mb-0"><i class="ti ti-users me-2"></i>Daftar Pengguna System</h5>
                    </div>
                    <div class="card-body position-relative">
                        <div class="table-responsive">
                            <table id="usersTable" class="table table-hover align-middle w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 35px;" class="text-center">
                                            <input class="form-check-input border-secondary" type="checkbox"
                                                id="selectAllUsersHeader"
                                                style="border-color: #495057; border-width: 1.5px;">
                                        </th>
                                        <th style="width: 55px;" class="text-center">Avatar</th>
                                        <th>Pengguna</th>
                                        <th>Role</th>
                                        <th>Poin</th>
                                        <th>Status</th>
                                        <th>Tanggal Bergabung</th>
                                        <th class="text-end" style="min-width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
                <form method="POST" id="editUserForm" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="ti ti-user-edit me-1"></i> Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_user_name" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="edit_user_email" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Avatar Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="" id="edit_user_avatar_img"
                                    class="rounded-circle avatar-md object-fit-cover" style="width: 48px; height: 48px;"
                                    alt="Avatar Preview">
                                <input type="file" name="avatar" class="form-control" accept="image/*" />
                            </div>
                            <small class="text-muted">Allowed: JPG, PNG, WEBP, GIF (Max 2MB)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <small class="text-muted">(Leave blank to keep current
                                    password)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="New password..." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Roles <small class="text-muted">(Dapat memilih lebih
                                    dari 1)</small></label>
                            <div class="row g-2 bg-light p-2 rounded border">
                                @foreach ($roles as $r)
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input edit-role-checkbox" type="checkbox"
                                                name="roles[]" value="{{ $r->name }}"
                                                id="edit_role_{{ $r->id }}">
                                            <label class="form-check-label cursor-pointer"
                                                for="edit_role_{{ $r->id }}">
                                                {{ ucfirst($r->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Assign Role Modal -->
    <div class="modal fade" id="bulkAssignRoleModal" tabindex="-1" aria-labelledby="bulkAssignRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.users.bulk-assign-role') }}" id="bulkAssignRoleForm">
                    @csrf
                    <div id="bulkUserInputsContainer"></div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="bulkAssignRoleModalLabel">
                            <i class="ti ti-user-shield me-1 text-primary"></i> Mass Assign Role to Users
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info py-2 fs-13 mb-3">
                            <i class="ti ti-info-circle me-1"></i> You are assigning a role to <strong
                                id="modalSelectedCount">0</strong> selected users.
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Target Role(s) <span
                                    class="text-danger">*</span></label>
                            <div class="row g-2 bg-light p-2 rounded border mb-3">
                                @foreach ($roles as $r)
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]"
                                                value="{{ $r->name }}" id="bulk_role_{{ $r->id }}">
                                            <label class="form-check-label cursor-pointer"
                                                for="bulk_role_{{ $r->id }}">
                                                {{ ucfirst($r->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assignment Mode</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="action_mode" id="actionModeSync"
                                    value="sync" checked>
                                <label class="form-check-label cursor-pointer" for="actionModeSync">
                                    <strong>Replace Current Roles</strong> <small class="text-muted d-block">Replaces all
                                        existing roles of selected users with the target role.</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="action_mode" id="actionModeAdd"
                                    value="add">
                                <label class="form-check-label cursor-pointer" for="actionModeAdd">
                                    <strong>Add Role</strong> <small class="text-muted d-block">Appends the target role
                                        without removing current roles.</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                            <i class="ti ti-check fs-18"></i>
                            <span>Apply Mass Role</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import Users Massal -->
    <div class="modal fade" id="importUsersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="ti ti-file-upload text-success me-1"></i> Import Pengguna
                        Massal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Step 1: Download Template -->
                    <div class="p-3 mb-3 bg-light rounded border">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1 fw-bold text-dark"><i
                                        class="ti ti-file-spreadsheet text-success me-1"></i> Unduh Template Excel (.xlsx)
                                </h6>
                                <p class="mb-0 fs-xs text-muted">Gunakan berkas Excel standar per kolom ini untuk mengisi
                                    data pengguna dengan mudah.</p>
                            </div>
                            <a href="{{ route('admin.users.export-template') }}"
                                class="btn btn-sm btn-success fw-semibold flex-shrink-0">
                                <i class="ti ti-download me-1"></i> Download Excel (.xlsx)
                            </a>
                        </div>
                    </div>

                    <!-- Step 2: Choose File -->
                    <div class="mb-3">
                        <label for="import_file" class="form-label fw-bold">Unggah Berkas Excel (.xlsx / .xls) <span
                                class="text-danger">*</span></label>
                        <input type="file" name="file" id="import_file" class="form-control"
                            accept=".xlsx,.xls,.csv" required>
                        <div class="form-text fs-xs text-muted">Format didukung: <code>.xlsx</code>, <code>.xls</code>,
                            <code>.csv</code>. Ukuran maks 5MB.
                        </div>
                    </div>

                    <!-- Step 3: Default Role & Approval -->
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="default_role" class="form-label fw-bold">Role Default</label>
                            <select name="default_role" id="default_role" class="form-select">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ $role->name === 'user' ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text fs-xs text-muted">Jika kolom Role di berkas kosong.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="default_approval" class="form-label fw-bold">Status Persetujuan</label>
                            <select name="default_approval" id="default_approval" class="form-select">
                                <option value="1" selected>Disetujui / Langsung Aktif</option>
                                <option value="0">Menunggu Persetujuan Admin</option>
                            </select>
                            <div class="form-text fs-xs text-muted">Jika kolom Approved di berkas kosong.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-semibold"><i class="ti ti-cloud-upload me-1"></i>
                        Upload & Impor Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="ti ti-user-plus me-1"></i> Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter full name"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email address"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Avatar Image</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*" />
                            <small class="text-muted">Allowed: JPG, PNG, WEBP, GIF (Max 2MB)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Enter password (min 8 chars)" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assign Roles <small class="text-muted">(Dapat memilih
                                    lebih dari 1)</small></label>
                            <div class="row g-2 bg-light p-2 rounded border">
                                @foreach ($roles as $r)
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]"
                                                value="{{ $r->name }}" id="create_role_{{ $r->id }}">
                                            <label class="form-check-label cursor-pointer"
                                                for="create_role_{{ $r->id }}">
                                                {{ ucfirst($r->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for Bulk Actions -->
    <form id="bulkApproveForm" action="{{ route('admin.users.bulk-approve') }}" method="POST" class="d-none">
        @csrf
        <div id="bulkApproveInputsContainer"></div>
    </form>

    <form id="bulkDeleteForm" action="{{ route('admin.users.bulk-delete') }}" method="POST" class="d-none">
        @csrf
        <div id="bulkDeleteInputsContainer"></div>
    </form>

    @push('scripts')
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap5.min.js') }}"></script>

        <script>
            function submitBulkApprove() {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                if (checkedBoxes.length === 0) return;

                Swal.fire({
                    title: 'Setujui Pengguna Massal?',
                    text: `Apakah Anda yakin ingin menyetujui ${checkedBoxes.length} akun pengguna yang dipilih?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Setujui Semua',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const container = document.getElementById('bulkApproveInputsContainer');
                        container.innerHTML = '';
                        checkedBoxes.forEach(box => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'user_ids[]';
                            input.value = box.value;
                            container.appendChild(input);
                        });
                        document.getElementById('bulkApproveForm').submit();
                    }
                });
            }

            function submitBulkDelete() {
                const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                if (checkedBoxes.length === 0) return;

                Swal.fire({
                    title: 'Hapus Pengguna Massal?',
                    text: `Tindakan ini akan menghapus ${checkedBoxes.length} pengguna yang dipilih secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus Sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const container = document.getElementById('bulkDeleteInputsContainer');
                        container.innerHTML = '';
                        checkedBoxes.forEach(box => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'user_ids[]';
                            input.value = box.value;
                            container.appendChild(input);
                        });
                        document.getElementById('bulkDeleteForm').submit();
                    }
                });
            }

            $(document).ready(function() {
                var statusFilter = '{{ $status }}';

                if (window.DataTable && window.DataTable.ext) {
                    window.DataTable.ext.errMode = 'none';
                }

                if (!$.fn.DataTable.isDataTable('#usersTable')) {
                    var usersTable = $('#usersTable').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        autoWidth: false,
                        ajax: {
                            url: "{{ route('admin.users.index') }}",
                            type: "GET",
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            data: function(d) {
                                return {
                                    draw: d.draw,
                                    start: d.start,
                                    length: d.length,
                                    search_text: $('#customSearchInput').val() || '',
                                    role: $('#customRoleSelect').val() || '',
                                    status: statusFilter || '',
                                    order_col: (d.order && d.order.length) ? d.order[0].column : 5,
                                    order_dir: (d.order && d.order.length) ? d.order[0].dir : 'desc'
                                };
                            }
                        },
                        columns: [{
                                data: 'checkbox',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'avatar',
                                orderable: false,
                                searchable: false,
                                className: 'text-center'
                            },
                            {
                                data: 'user',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'roles',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'points',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'status',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'created_at',
                                orderable: true,
                                searchable: false
                            },
                            {
                                data: 'actions',
                                orderable: false,
                                searchable: false,
                                className: 'text-end'
                            }
                        ],
                        order: [
                            [6, 'asc']
                        ],
                        pageLength: 10,
                        lengthMenu: [
                            [10, 25, 50, 100],
                            [10, 25, 50, 100]
                        ],
                        language: {
                            processing: '<div class="spinner-border text-primary" style="width: 1.75rem; height: 1.75rem; border-width: 0.22em;" role="status"></div>',
                            search: "Cari:",
                            lengthMenu: "Tampilkan _MENU_ baris",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pengguna",
                            infoEmpty: "Menampilkan 0 sampai 0 dari 0 pengguna",
                            infoFiltered: "(disaring dari _MAX_ total pengguna)",
                            zeroRecords: "Tidak ada data pengguna yang sesuai",
                            emptyTable: "Belum ada data pengguna",
                            paginate: {
                                first: '<i class="ti ti-chevrons-left"></i>',
                                last: '<i class="ti ti-chevrons-right"></i>',
                                next: '<i class="ti ti-chevron-right"></i>',
                                previous: '<i class="ti ti-chevron-left"></i>'
                            }
                        }
                    });

                    usersTable.on('draw', function() {
                        if (typeof $.fn.tooltip === 'function') {
                            $('[data-bs-toggle="tooltip"]').tooltip();
                        }
                        updateSelectionState();
                    });

                    $('.dt-search, .dataTables_filter').hide();

                    let searchTimeout;
                    $('#customSearchInput').on('keyup change input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(function() {
                            usersTable.draw();
                        }, 300);
                    });

                    $('#customRoleSelect').on('change', function() {
                        usersTable.draw();
                    });

                    $('#resetFilterBtn').on('click', function() {
                        $('#customSearchInput').val('');
                        $('#customRoleSelect').val('');
                        usersTable.draw();
                    });

                    // Edit button handler to populate single reusable edit modal
                    $(document).on('click', '.edit-user-btn', function() {
                        var userId = $(this).data('user-id');
                        var userName = $(this).data('user-name');
                        var userEmail = $(this).data('user-email');
                        var userAvatar = $(this).data('user-avatar');
                        var userRoles = $(this).data('user-roles') || [];
                        var updateUrl = $(this).data('update-url');

                        var modal = $('#editUserModal');
                        modal.find('#editUserForm').attr('action', updateUrl);
                        modal.find('#edit_user_name').val(userName);
                        modal.find('#edit_user_email').val(userEmail);
                        modal.find('#edit_user_avatar_img').attr('src', userAvatar);

                        // Uncheck all role checkboxes
                        modal.find('.edit-role-checkbox').prop('checked', false);
                        userRoles.forEach(function(roleName) {
                            modal.find('.edit-role-checkbox[value="' + roleName + '"]').prop('checked',
                                true);
                        });

                        modal.modal('show');
                    });

                    // Select All Checkbox Handler
                    const selectAllHeader = document.getElementById('selectAllUsersHeader');
                    const selectedUserCountSpans = document.querySelectorAll('.selectedUserCount');
                    const modalSelectedCount = document.getElementById('modalSelectedCount');
                    const bulkAssignRoleBtn = document.getElementById('bulkAssignRoleBtn');
                    const bulkApproveBtn = document.getElementById('bulkApproveBtn');
                    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                    const bulkUserInputsContainer = document.getElementById('bulkUserInputsContainer');

                    function updateSelectionState() {
                        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
                        const allBoxes = document.querySelectorAll('.user-checkbox');
                        const count = checkedBoxes.length;

                        selectedUserCountSpans.forEach(span => span.textContent = count);
                        if (modalSelectedCount) modalSelectedCount.textContent = count;

                        if (count > 0) {
                            if (bulkAssignRoleBtn) bulkAssignRoleBtn.classList.remove('d-none');
                            if (bulkApproveBtn) bulkApproveBtn.classList.remove('d-none');
                            if (bulkDeleteBtn) bulkDeleteBtn.classList.remove('d-none');
                        } else {
                            if (bulkAssignRoleBtn) bulkAssignRoleBtn.classList.add('d-none');
                            if (bulkApproveBtn) bulkApproveBtn.classList.add('d-none');
                            if (bulkDeleteBtn) bulkDeleteBtn.classList.add('d-none');
                        }

                        if (selectAllHeader && allBoxes.length > 0) {
                            selectAllHeader.checked = count > 0 && count === allBoxes.length;
                            selectAllHeader.indeterminate = count > 0 && count < allBoxes.length;
                        }

                        if (bulkUserInputsContainer) {
                            bulkUserInputsContainer.innerHTML = '';
                            checkedBoxes.forEach(box => {
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = 'user_ids[]';
                                hiddenInput.value = box.value;
                                bulkUserInputsContainer.appendChild(hiddenInput);
                            });
                        }
                    }

                    if (selectAllHeader) {
                        selectAllHeader.addEventListener('change', function() {
                            const userCheckboxes = document.querySelectorAll('.user-checkbox');
                            userCheckboxes.forEach(cb => cb.checked = selectAllHeader.checked);
                            updateSelectionState();
                        });
                    }

                    $(document).on('change', '.user-checkbox', function() {
                        updateSelectionState();
                    });
                }
            });
        </script>
    @endpush
@endsection
