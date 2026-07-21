<tr data-id="{{ $menu->id }}" data-parent-id="{{ $menu->parent_id ?? '' }}" data-level="{{ $level }}">
    <td class="text-center align-middle" style="width: 75px;">
        <span class="d-inline-flex align-items-center justify-content-center gap-1">
            <i class="ti ti-grip-vertical drag-handle text-secondary fs-16" style="cursor: grab;" title="Geser untuk mengurutkan"></i>
            @if ($menu->icon)
                <i class="{{ $menu->icon }} fs-18"></i>
            @else
                <span class="text-muted">-</span>
            @endif
        </span>
    </td>
    <td>
        <div style="padding-left: {{ $level * 25 }}px;">
            @if ($level > 0)
                <span class="text-muted me-1">└─</span>
            @endif
            <strong class="{{ $menu->type === 'header' ? 'text-primary text-uppercase fs-12' : '' }}">
                {{ $menu->name }}
            </strong>
            @if ($menu->badge_text)
                <span class="{{ $menu->badge_class ?? 'badge bg-secondary ms-1' }}">{{ $menu->badge_text }}</span>
            @endif
        </div>
    </td>
    <td>
        @if ($menu->type === 'header')
            <span class="badge bg-secondary">Header</span>
        @elseif($menu->type === 'divider')
            <span class="badge bg-dark">Divider</span>
        @else
            <span class="badge bg-primary">Item</span>
        @endif
    </td>
    <td>
        @if ($menu->route_name)
            <div class="fw-semibold text-dark fs-12 mb-1">{{ parse_url($menu->url_link, PHP_URL_PATH) ?: $menu->url_link }}</div>
            <span class="badge bg-light text-secondary border font-monospace fs-11" title="Nama Rute Laravel"><i class="ti ti-route me-1"></i>{{ $menu->route_name }}</span>
        @elseif($menu->url)
            <code class="fs-12">{{ $menu->url }}</code>
        @else
            <span class="text-muted fs-12">#</span>
        @endif
    </td>
    <td>
        @forelse($menu->roles as $role)
            <span class="badge bg-info text-dark me-1">{{ $role->name }}</span>
        @empty
            <span class="text-muted fs-12">All Users</span>
        @endforelse
    </td>
    <td>
        @if ($menu->permission_name)
            <span class="badge bg-warning text-dark"><i class="ti ti-lock me-1"></i>{{ $menu->permission_name }}</span>
        @else
            <span class="text-muted fs-12">-</span>
        @endif
    </td>
    <td>{{ $menu->sort_order }}</td>
    <td>
        <form action="{{ route('admin.menus.toggle-status', $menu) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm {{ $menu->is_active ? 'btn-soft-success' : 'btn-soft-danger' }}">
                {{ $menu->is_active ? 'Active' : 'Inactive' }}
            </button>
        </form>
    </td>
    <td class="text-end">
        <button class="btn btn-sm btn-soft-primary me-1" data-bs-toggle="modal" data-bs-target="#editMenuModal_{{ $menu->id }}">
            <i class="ti ti-pencil"></i> Edit
        </button>

        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline" id="delete-menu-form-{{ $menu->id }}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-sm btn-soft-danger" 
                data-swal-confirm="true"
                data-swal-title="Hapus Menu?"
                data-swal-text="Apakah Anda yakin ingin menghapus menu '{{ $menu->name }}'?"
                data-swal-confirm-text="Ya, Hapus!"
                data-form-id="delete-menu-form-{{ $menu->id }}">
                <i class="ti ti-trash"></i>
            </button>
        </form>
    </td>
</tr>

@foreach ($menu->children as $child)
    @include('admin.system.menus.partials.menu-row', ['menu' => $child, 'level' => $level + 1])
@endforeach
