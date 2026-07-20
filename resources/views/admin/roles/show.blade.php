@extends('layouts.app')

@section('title', 'Role Details | INSPINIA')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0">Role Details: {{ ucfirst($role->name) }}</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inspinia</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active">Details</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <!-- Role Info & Permissions Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar-xl rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="ti ti-shield-check fs-32 text-primary"></i>
                    </div>
                    <h4 class="mb-1 text-capitalize">{{ $role->name }}</h4>
                    <p class="text-muted fs-sm">Guard: {{ $role->guard_name }}</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-primary-subtle text-primary fs-xs">{{ $role->permissions->count() }} Permissions</span>
                        <span class="badge bg-info-subtle text-info fs-xs">{{ $role->users->count() }} Users</span>
                    </div>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="ti ti-arrow-left me-1"></i> Back to Roles List
                    </a>
                </div>
            </div>

            <!-- Assigned Permissions -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0"><i class="ti ti-key me-1"></i> Assigned Permissions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @forelse($role->permissions as $perm)
                            <span class="badge bg-success-subtle text-success p-2 fs-xs">
                                <i class="ti ti-check me-1"></i> {{ $perm->name }}
                            </span>
                        @empty
                            <p class="text-muted fs-sm mb-0">No permissions assigned to this role yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Users assigned to this role -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="ti ti-users me-1"></i> Users with {{ ucfirst($role->name) }} Role</h5>
                    <span class="badge bg-light text-dark fs-xs">{{ $role->users->count() }} Members</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($role->users as $u)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-xs">
                                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                                </span>
                                                <span class="fw-medium text-dark">{{ $u->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted fs-xs">{{ $u->email }}</td>
                                        <td class="text-muted fs-xs">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.users.index', ['search' => $u->email]) }}" class="btn btn-xs btn-soft-primary">
                                                <i class="ti ti-user me-1"></i> View User
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            No users currently assigned to this role.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
