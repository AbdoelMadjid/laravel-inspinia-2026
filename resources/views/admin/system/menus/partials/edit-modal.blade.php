<!-- Edit Modal for Menu {{ $menu->id }} -->
<div class="modal fade text-start" id="editMenuModal_{{ $menu->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.menus.update', $menu) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title"><i class="ti ti-pencil me-1"></i> Edit Menu: {{ $menu->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Menu Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $menu->name }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Parent Menu</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Top Level / Root --</option>
                            @foreach ($allMenus as $parent)
                                @if ($parent->id !== $menu->id)
                                    <option value="{{ $parent->id }}" {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }} ({{ $parent->type }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Menu Type</label>
                        <select name="type" class="form-select" required>
                            <option value="item" {{ $menu->type === 'item' ? 'selected' : '' }}>Item / Link</option>
                            <option value="header" {{ $menu->type === 'header' ? 'selected' : '' }}>Section Header</option>
                            <option value="divider" {{ $menu->type === 'divider' ? 'selected' : '' }}>Divider</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Icon</label>
                        <input type="text" name="icon" class="form-control" value="{{ $menu->icon }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ $menu->sort_order }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Route Name</label>
                        <input type="text" name="route_name" class="form-control" value="{{ $menu->route_name }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Custom URL</label>
                        <input type="text" name="url" class="form-control" value="{{ $menu->url }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Badge Text</label>
                        <input type="text" name="badge_text" class="form-control" value="{{ $menu->badge_text }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Badge CSS Class</label>
                        <input type="text" name="badge_class" class="form-control" value="{{ $menu->badge_class }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Spatie Permission Requirement</label>
                        <select name="permission_name" class="form-select">
                            <option value="">-- No Permission Required --</option>
                            @foreach ($permissions as $perm)
                                <option value="{{ $perm->name }}" {{ $menu->permission_name === $perm->name ? 'selected' : '' }}>{{ $perm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data Lang</label>
                        <input type="text" name="data_lang" class="form-control" value="{{ $menu->data_lang }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Assign Spatie Roles Access</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_edit_{{ $menu->id }}_{{ $role->id }}" {{ $menu->roles->contains($role->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_edit_{{ $menu->id }}_{{ $role->id }}">
                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active_edit_{{ $menu->id }}" {{ $menu->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active_edit_{{ $menu->id }}">Active Menu</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Changes</button>
            </div>
        </form>
    </div>
</div>
