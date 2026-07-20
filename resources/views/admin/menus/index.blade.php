@extends('layouts.app')

@section('title', 'Menu Management')

@section('content')
<div class="container-fluid">
    <div class="page-title-head d-flex align-items-center justify-content-between my-2">
        <div class="flex-grow-1">
            <h4 class="page-main-title m-0">Menu Management</h4>
        </div>

        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-smart-home me-1"></i>Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0);">System Management</a></li>
                <li class="breadcrumb-item active">Menu Management</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <i class="ti ti-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex align-items-center justify-content-between py-2">
                    <h5 class="card-title mb-0"><i class="ti ti-sitemap me-2"></i>Database Menus &amp; Spatie Role Access</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createMenuModal">
                        <i class="ti ti-plus me-1"></i> Add New Menu
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Icon</th>
                                    <th>Menu Name</th>
                                    <th>Type</th>
                                    <th>Route / URL</th>
                                    <th>Spatie Roles</th>
                                    <th>Permission</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    @include('admin.menus.partials.menu-row', ['menu' => $menu, 'level' => 0])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Menu -->
<div class="modal fade" id="createMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.menus.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-plus me-1"></i> Add New Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Menu Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Dashboard">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Parent Menu (Optional)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Top Level / Root --</option>
                            @foreach ($allMenus as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }} ({{ $parent->type }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Menu Type</label>
                        <select name="type" class="form-select" required>
                            <option value="item" selected>Item / Link</option>
                            <option value="header">Section Header</option>
                            <option value="divider">Divider</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Icon (Tabler Icon class)</label>
                        <input type="text" name="icon" class="form-control" placeholder="ti ti-dashboard">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Route Name</label>
                        <input type="text" name="route_name" class="form-control" placeholder="e.g. dashboard or page">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Custom URL</label>
                        <input type="text" name="url" class="form-control" placeholder="e.g. /custom-url or #">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Badge Text</label>
                        <input type="text" name="badge_text" class="form-control" placeholder="e.g. New or Hot">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Badge CSS Class</label>
                        <input type="text" name="badge_class" class="form-control" placeholder="badge bg-danger text-white float-end">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Spatie Permission Requirement</label>
                        <select name="permission_name" class="form-select">
                            <option value="">-- No Permission Required --</option>
                            @foreach ($permissions as $perm)
                                <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data Lang (Multi-language Key)</label>
                        <input type="text" name="data_lang" class="form-control" placeholder="e.g. dashboard">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Assign Spatie Roles Access</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" checked>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active_new" checked>
                            <label class="form-check-label fw-bold" for="is_active_new">Active Menu</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Menu Item</button>
            </div>
        </form>
    </div>
</div>
@endsection
