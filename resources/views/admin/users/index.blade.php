@extends('layouts.app')

@section('title', 'Users Management | INSPINIA')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0">Users Management</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inspinia</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);">Users Management</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ti ti-circle-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search & Action Bar -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="bg-light-subtle rounded border p-3">
                <form method="GET" action="{{ route('admin.users.index') }}" class="row gap-3">
                    <div class="col-lg-4">
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
                        @if(request('search') || request('role'))
                            <a href="{{ route('admin.users.index') }}" class="btn btn-soft-secondary">Reset</a>
                        @endif
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="ti ti-plus me-1"></i> Add New User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Users Card Grid -->
    <div class="row">
        @forelse($users as $user)
            <div class="col-md-6 col-xxl-3 mb-3">
                <div class="card card-h-100 mb-0">
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
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="mb-1 text-truncate">
                                    <a href="javascript: void(0);" class="link-reset">{{ $user->name }}</a>
                                </h5>
                                <p class="text-muted fs-xs mb-1 text-truncate">{{ $user->email }}</p>
                                <div>
                                    @forelse($user->roles as $userRole)
                                        <span class="badge bg-primary-subtle text-primary badge-label me-1">{{ ucfirst($userRole->name) }}</span>
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
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                                <i class="ti ti-edit me-2"></i> Edit
                                            </a>
                                        </li>
                                        @if($user->id !== auth()->id())
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                                <i class="ti ti-trash me-2"></i> Delete
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

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
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select">
                                        <option value="">-- Select Role --</option>
                                        @foreach($roles as $r)
                                            <option value="{{ $r->name }}" {{ $user->hasRole($r->name) ? 'selected' : '' }}>
                                                {{ ucfirst($r->name) }}
                                            </option>
                                        @endforeach
                                    </select>
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

            <!-- Delete User Modal -->
            @if($user->id !== auth()->id())
            <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body text-center p-4">
                                <i class="ti ti-alert-triangle text-danger display-4 mb-2"></i>
                                <h5>Delete User?</h5>
                                <p class="text-muted fs-sm mb-3">Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone.</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
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
                        <label class="form-label">Assign Role</label>
                        <select name="role" class="form-select">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                            @endforeach
                        </select>
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
@endsection
