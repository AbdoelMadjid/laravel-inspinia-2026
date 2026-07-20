@extends('layouts.app')

@section('title', 'User Permissions | INSPINIA - Responsive Bootstrap 5 Admin Dashboard Template')
@section('title_lang', 'title-users-permissions')

@section('content')
<div class="container-fluid">
    <div class="page-title-head d-flex align-items-center">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0" data-lang="users-permissions">Permissions</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inspinia</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);" data-lang="users-management">Users Management</a></li>
                <li class="breadcrumb-item active" data-lang="users-permissions">Permissions</li>
            </ol>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-xxl-10">
            <div data-table data-table-rows-per-page="8" class="card">
                <div class="card-header border-light justify-content-between flex-wrap gap-2">
                    <form method="GET" action="{{ route('admin.permissions.index') }}" class="d-flex gap-2 align-items-center">
                        <div class="app-search">
                            <input data-table-search type="search" name="search" class="form-control" placeholder="Search permissions..." value="{{ request('search') }}" />
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>
                        <button type="submit" class="btn btn-secondary">Search</button>
                        @if(request('search'))
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-soft-secondary">Reset</a>
                        @endif
                    </form>

                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                            <i class="ti ti-plus me-1"></i> Add New Permission
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom table-centered table-select table-hover w-100 mb-0">
                        <thead class="bg-light align-middle bg-opacity-25 thead-sm">
                            <tr class="text-uppercase fs-xxs">
                                <th data-table-sort>Name</th>
                                <th>Assign To</th>
                                <th data-table-sort>Created Date</th>
                                <th data-table-sort>Users</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                                @php
                                    $userCount = $permission->roles->flatMap->users->unique('id')->count();
                                @endphp
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $permission->name }}</td>
                                    <td>
                                        @forelse($permission->roles as $role)
                                            <span class="badge bg-primary-subtle text-primary badge-label fs-xxs fw-semibold me-1">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @empty
                                            <span class="badge bg-secondary-subtle text-secondary badge-label fs-xxs fw-semibold">Unassigned</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        {{ $permission->created_at ? $permission->created_at->format('d M Y') : '-' }},
                                        <span class="text-muted">{{ $permission->created_at ? $permission->created_at->format('h:i a') : '' }}</span>
                                    </td>
                                    <td>{{ $userCount }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-light btn-icon btn-sm rounded-circle me-1" data-bs-toggle="modal" data-bs-target="#editPermissionModal{{ $permission->id }}">
                                            <i class="ti ti-edit fs-lg"></i>
                                        </a>
                                        <a href="#" class="btn btn-light btn-icon btn-sm rounded-circle text-danger" data-bs-toggle="modal" data-bs-target="#deletePermissionModal{{ $permission->id }}">
                                            <i class="ti ti-trash fs-lg"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Edit Permission Modal -->
                                <div class="modal fade" id="editPermissionModal{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><i class="ti ti-key me-1"></i> Edit Permission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" required />
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

                                <!-- Delete Permission Modal -->
                                <div class="modal fade" id="deletePermissionModal{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.permissions.destroy', $permission->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body text-center p-4">
                                                    <i class="ti ti-alert-triangle text-danger display-4 mb-2"></i>
                                                    <h5>Delete Permission?</h5>
                                                    <p class="text-muted fs-sm mb-3">Are you sure you want to delete permission <strong>{{ $permission->name }}</strong>?</p>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No permissions found.
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

<!-- Add Permission Modal -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-key me-1"></i> Add New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. create-users, edit-posts" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
