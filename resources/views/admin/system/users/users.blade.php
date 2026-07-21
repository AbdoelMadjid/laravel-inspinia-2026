@extends('layouts.app')

@section('title', 'Users Management | INSPINIA')
@section('title_lang', 'title-users-management')

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
                <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="users-management">Users Management</a></li>
                <li class="breadcrumb-item active" data-lang="users-contacts">Users</li>
            </ol>
        </div>
    </div>

    <!-- Search & Action Bar -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="bg-light-subtle rounded border p-3">
                <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-center">
                    @if($status)<input type="hidden" name="status" value="{{ $status }}">@endif
                    <div class="col-lg-3">
                        <div class="app-search">
                            <input type="text" name="search" class="form-control" placeholder="Search user name or email..." value="{{ request('search') }}" />
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="app-search">
                            <select name="role" class="form-select form-control">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="ti ti-user-check app-search-icon text-muted"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-secondary">
                            <i class="ti ti-filter me-1"></i> Filter
                        </button>
                        @if(request('search') || request('role') || request('status'))
                            <a href="{{ route('admin.users.index') }}" class="btn btn-soft-secondary">Reset</a>
                        @endif
                    </div>
                    <div class="col text-end d-flex align-items-center justify-content-end gap-2">
                        <!-- Bulk Assign Role Button -->
                        <button type="button" class="btn btn-outline-primary d-none" id="bulkAssignRoleBtn" data-bs-toggle="modal" data-bs-target="#bulkAssignRoleModal">
                            <i class="ti ti-user-shield me-1"></i> Bulk Assign Role (<span id="selectedUserCount">0</span>)
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="ti ti-plus me-1"></i> Add New User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Status Tabs Filter -->
    <div class="d-flex align-items-center gap-1 mb-3">
        <a href="{{ route('admin.users.index', array_merge(request()->except('status'), [])) }}" class="btn btn-sm {{ empty($status) ? 'btn-primary' : 'btn-outline-secondary' }}">
            <i class="ti ti-users me-1"></i> Semua Pengguna
        </a>
        <a href="{{ route('admin.users.index', array_merge(request()->except('status'), ['status' => 'approved'])) }}" class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-outline-success' }}">
            <i class="ti ti-circle-check me-1"></i> Disetujui / Aktif
        </a>
        <a href="{{ route('admin.users.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
            <i class="ti ti-clock me-1"></i> Menunggu Persetujuan
        </a>
    </div>

    <!-- Select All Bar -->
    @if($users->count() > 0)
    <div class="d-flex align-items-center justify-content-between mb-3 bg-light p-2 rounded border">
        <div class="form-check m-0 ms-2">
            <input class="form-check-input" type="checkbox" id="selectAllUsers">
            <label class="form-check-label fw-semibold text-dark user-select-none cursor-pointer" for="selectAllUsers">
                Select / Deselect All Users on Page
            </label>
        </div>
        <span class="badge bg-primary-subtle text-primary fs-12 fw-medium me-2" id="selectedUserBadge">0 selected</span>
    </div>
    @endif

    <!-- Users Card Grid -->
    <div class="row">
        @forelse($users as $user)
            <div class="col-md-6 col-xxl-3 mb-3">
                <div class="card card-h-100 mb-0 position-relative border {{ !$user->is_approved ? 'border-warning shadow-sm' : '' }}">
                    <!-- Checkbox Selection -->
                    <div class="position-absolute top-0 end-0 p-2 z-1">
                        <input class="form-check-input user-checkbox" type="checkbox" value="{{ $user->id }}" data-user-name="{{ $user->name }}">
                    </div>

                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 position-relative">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="avatar-md rounded-circle object-fit-cover" style="width: 56px; height: 56px;" />
                                @else
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20 fw-bold d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-grow-1 overflow-hidden pe-4">
                                <h5 class="mb-1 text-truncate">
                                    <a href="javascript: void(0);" class="link-reset">{{ $user->name }}</a>
                                </h5>
                                <p class="text-muted fs-xs mb-1 text-truncate">{{ $user->email }}</p>
                                <div class="d-flex flex-wrap gap-1 align-items-center">
                                    @if($user->is_approved)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-11 rounded-pill" title="Akun Disetujui / Aktif">
                                            <i class="ti ti-circle-check me-1"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11 rounded-pill" title="Menunggu Persetujuan Admin">
                                            <i class="ti ti-clock me-1"></i> Pending Approval
                                        </span>
                                    @endif

                                    @forelse($user->roles as $userRole)
                                        <span class="badge bg-primary-subtle text-primary badge-label">{{ ucfirst($userRole->name) }}</span>
                                    @empty
                                        <span class="badge bg-secondary-subtle text-secondary badge-label">No Role</span>
                                    @endforelse
                                </div>
                            </div>
                            <div class="ms-auto">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-icon btn-ghost-light text-muted" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical fs-xl"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if($user->id !== auth()->id())
                                        <li>
                                            <form method="POST" action="{{ route('admin.users.impersonate', $user->id) }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-primary fw-semibold">
                                                    <i class="ti ti-arrows-exchange me-2"></i> Switch Akun
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                <i class="ti ti-edit me-2"></i> Edit
                                            </a>
                                        </li>

                                        @if($user->id !== auth()->id())
                                            @if($user->is_approved)
                                                <li>
                                                    <form method="POST" action="{{ route('admin.users.toggle-approval', $user->id) }}" id="deactivate-user-form-{{ $user->id }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="button" class="dropdown-item text-warning"
                                                            data-swal-confirm="true"
                                                            data-swal-title="Nonaktifkan Akun?"
                                                            data-swal-text="Akun {{ $user->name }} tidak akan bisa login sampai disetujui kembali oleh Admin."
                                                            data-swal-icon="warning"
                                                            data-swal-confirm-text="Ya, Nonaktifkan!"
                                                            data-form-id="deactivate-user-form-{{ $user->id }}">
                                                            <i class="ti ti-ban me-2"></i> Nonaktifkan Akun
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" id="delete-user-form-{{ $user->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger"
                                                        data-swal-confirm="true"
                                                        data-swal-title="Hapus User?"
                                                        data-swal-text="Apakah Anda yakin ingin menghapus user '{{ $user->name }}'?"
                                                        data-swal-confirm-text="Ya, Hapus!"
                                                        data-form-id="delete-user-form-{{ $user->id }}">
                                                        <i class="ti ti-trash me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if(!$user->is_approved)
                            <div class="my-2 p-2 bg-warning-subtle rounded border border-warning-subtle">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fs-xs fw-semibold text-warning"><i class="ti ti-alert-triangle me-1"></i> Menunggu Persetujuan</span>
                                    <form method="POST" action="{{ route('admin.users.toggle-approval', $user->id) }}" id="approve-user-form-{{ $user->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-sm btn-success fw-semibold py-1 px-2 fs-12"
                                            data-swal-confirm="true"
                                            data-swal-title="Setujui Akun Pengguna?"
                                            data-swal-text="Akun {{ $user->name }} akan disetujui dan diizinkan untuk login ke sistem."
                                            data-swal-icon="info"
                                            data-swal-confirm-text="Ya, Setujui Akun!"
                                            data-form-id="approve-user-form-{{ $user->id }}">
                                            <i class="ti ti-check me-1"></i> Setujui
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <ul class="list-unstyled text-muted mb-0">
                            <li class="mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-xs">
                                        <span class="avatar-title bg-light text-muted fs-sm rounded-circle">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                    </div>
                                    <span class="fs-xs fw-medium">Joined: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ti ti-user-edit me-1"></i> Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Avatar Image</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $user->avatar_url }}" class="rounded-circle avatar-md object-fit-cover" style="width: 48px; height: 48px;" alt="{{ $user->name }}">
                                        <input type="file" name="avatar" class="form-control" accept="image/*" />
                                    </div>
                                    <small class="text-muted">Allowed: JPG, PNG, WEBP, GIF (Max 2MB)</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                                    <input type="password" name="password" class="form-control" placeholder="New password..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Roles <small class="text-muted">(Dapat memilih lebih dari 1)</small></label>
                                    <div class="row g-2 bg-light p-2 rounded border">
                                        @foreach($roles as $r)
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $r->name }}" id="edit_role_{{ $user->id }}_{{ $r->id }}" {{ $user->hasRole($r->name) ? 'checked' : '' }}>
                                                    <label class="form-check-label cursor-pointer" for="edit_role_{{ $user->id }}_{{ $r->id }}">
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
        @empty
            <div class="col-12 text-center py-5">
                <i class="ti ti-users-minus text-muted display-4"></i>
                <h5 class="mt-2">No users found</h5>
                <p class="text-muted">Try adjusting your search filter or add a new user.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-end mt-3">
        {{ $users->links() }}
    </div>
</div>

<!-- Bulk Assign Role Modal -->
<div class="modal fade" id="bulkAssignRoleModal" tabindex="-1" aria-labelledby="bulkAssignRoleModalLabel" aria-hidden="true">
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
                        <i class="ti ti-info-circle me-1"></i> You are assigning a role to <strong id="modalSelectedCount">0</strong> selected users.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Target Role(s) <span class="text-danger">*</span></label>
                        <div class="row g-2 bg-light p-2 rounded border mb-3">
                            @foreach($roles as $r)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $r->name }}" id="bulk_role_{{ $r->id }}">
                                        <label class="form-check-label cursor-pointer" for="bulk_role_{{ $r->id }}">
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
                            <input class="form-check-input" type="radio" name="action_mode" id="actionModeSync" value="sync" checked>
                            <label class="form-check-label cursor-pointer" for="actionModeSync">
                                <strong>Replace Current Roles</strong> <small class="text-muted d-block">Replaces all existing roles of selected users with the target role.</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action_mode" id="actionModeAdd" value="add">
                            <label class="form-check-label cursor-pointer" for="actionModeAdd">
                                <strong>Add Role</strong> <small class="text-muted d-block">Appends the target role without removing current roles.</small>
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
                        <input type="text" name="name" class="form-control" placeholder="Enter full name" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email address" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Avatar Image</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*" />
                        <small class="text-muted">Allowed: JPG, PNG, WEBP, GIF (Max 2MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password (min 8 chars)" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign Roles <small class="text-muted">(Dapat memilih lebih dari 1)</small></label>
                        <div class="row g-2 bg-light p-2 rounded border">
                            @foreach($roles as $r)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $r->name }}" id="create_role_{{ $r->id }}">
                                        <label class="form-check-label cursor-pointer" for="create_role_{{ $r->id }}">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAllUsers');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const selectedUserCountSpan = document.getElementById('selectedUserCount');
        const selectedUserBadge = document.getElementById('selectedUserBadge');
        const modalSelectedCount = document.getElementById('modalSelectedCount');
        const bulkAssignRoleBtn = document.getElementById('bulkAssignRoleBtn');
        const bulkUserInputsContainer = document.getElementById('bulkUserInputsContainer');

        function updateSelectionState() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            const count = checkedBoxes.length;

            if (selectedUserCountSpan) selectedUserCountSpan.textContent = count;
            if (selectedUserBadge) selectedUserBadge.textContent = count + ' users selected';
            if (modalSelectedCount) modalSelectedCount.textContent = count;

            if (count > 0) {
                if (bulkAssignRoleBtn) bulkAssignRoleBtn.classList.remove('d-none');
            } else {
                if (bulkAssignRoleBtn) bulkAssignRoleBtn.classList.add('d-none');
            }

            if (selectAllCheckbox && userCheckboxes.length > 0) {
                selectAllCheckbox.checked = count > 0 && count === userCheckboxes.length;
                selectAllCheckbox.indeterminate = count > 0 && count < userCheckboxes.length;
            }

            // Sync hidden inputs for modal form
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

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                userCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
                updateSelectionState();
            });
        }

        userCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateSelectionState);
        });

        updateSelectionState();
    });
</script>
@endpush
@endsection
