@extends('layouts.app')

@section('title', 'User Roles | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')

@section('content')
<div class="container-fluid">
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0" data-lang="users-roles">Roles</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inspinia</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="users-management">Users Management</a></li>
                <li class="breadcrumb-item active" data-lang="users-roles">Roles</li>
            </ol>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div class="d-flex align-items-sm-center flex-sm-row flex-column mb-3">
                <div class="flex-grow-1">
                    <h4 class="fs-xl mb-1">Manage Roles</h4>
                    <p class="text-muted mb-0">Manage roles for smoother operations and secure access.</p>
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="ti ti-plus me-1"></i>
                        Add New Role
                    </button>
                </div>
            </div>

            <div class="row">
                @foreach($roles as $role)
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card h-100 mb-0">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-xl rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center">
                                                <i class="ti ti-shield-lock fs-24 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="mb-1 text-capitalize">{{ $role->name }}</h5>
                                            <p class="text-muted mb-0 fs-base">{{ $role->permissions_count }} Permissions</p>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="dropdown">
                                                <a href="#" class="text-muted fs-xl" data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.roles.show', $role->id) }}">
                                                            <i class="ti ti-eye me-2"></i>
                                                            View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}">
                                                            <i class="ti ti-edit me-2"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    @if($role->name !== 'admin')
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteRoleModal{{ $role->id }}">
                                                            <i class="ti ti-trash me-2"></i>
                                                            Remove
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="list-unstyled mb-3">
                                        @forelse($role->permissions->take(4) as $perm)
                                            <li class="d-flex align-items-center mb-2">
                                                <i class="ti ti-check fs-lg text-success me-2"></i>
                                                {{ $perm->name }}
                                            </li>
                                        @empty
                                            <li class="d-flex align-items-center mb-2 text-muted fs-xs">
                                                <i class="ti ti-minus me-2"></i> No permissions assigned
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div class="mt-auto pt-2">
                                    <p class="mb-2 text-muted">Total {{ $role->users_count }} users</p>
                                    <div class="avatar-group avatar-group-sm mb-3">
                                        @forelse($role->users->take(4) as $u)
                                            <div class="avatar">
                                                @if($u->avatar)
                                                    <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="rounded-circle object-fit-cover" style="width: 32px; height: 32px;" />
                                                @else
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary fw-semibold fs-xs" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @empty
                                            <span class="text-muted fs-xs">No users assigned</span>
                                        @endforelse
                                        @if($role->users_count > 4)
                                            <div class="avatar">
                                                <span class="avatar-title rounded-circle bg-secondary text-white fw-semibold fs-xs" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                                    +{{ $role->users_count - 4 }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-1">
                                        <span class="text-muted fs-xs">
                                            <i class="ti ti-clock me-1"></i>
                                            {{ $role->created_at ? $role->created_at->diffForHumans() : '-' }}
                                        </span>
                                        <a href="{{ route('admin.roles.show', $role->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Role Modal -->
                    <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ti ti-shield-edit me-1"></i> Edit Role: {{ ucfirst($role->name) }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Role Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Assign Permissions</label>
                                            <div class="row g-2">
                                                @foreach($permissions as $perm)
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form-check border rounded p-2 ps-4">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->name }}" id="perm_edit_{{ $role->id }}_{{ $perm->id }}" {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                                            <label class="form-check-label fs-xs fw-medium text-dark" for="perm_edit_{{ $role->id }}_{{ $perm->id }}">
                                                                {{ $perm->name }}
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

                    <!-- Delete Role Modal -->
                    @if($role->name !== 'admin')
                    <div class="modal fade" id="deleteRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body text-center p-4">
                                        <i class="ti ti-alert-triangle text-danger display-4 mb-2"></i>
                                        <h5>Remove Role?</h5>
                                        <p class="text-muted fs-sm mb-3">Are you sure you want to remove role <strong>{{ ucfirst($role->name) }}</strong>?</p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Remove</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-shield-plus me-1"></i> Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. manager, editor" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign Permissions</label>
                        <div class="row g-2">
                            @foreach($permissions as $perm)
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check border rounded p-2 ps-4">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->name }}" id="perm_add_{{ $perm->id }}">
                                        <label class="form-check-label fs-xs fw-medium text-dark" for="perm_add_{{ $perm->id }}">
                                            {{ $perm->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
