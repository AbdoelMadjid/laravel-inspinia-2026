<tr>
    <td class="text-center" style="width: 50px;">
        @if ($menu->icon)
            <i class="{{ $menu->icon }} fs-18"></i>
        @else
            <span class="text-muted">-</span>
        @endif
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
        <code class="fs-12">{{ $menu->route_name ?: ($menu->url ?: '#') }}</code>
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

        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this menu?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-soft-danger">
                <i class="ti ti-trash"></i>
            </button>
        </form>
    </td>
</tr>

@foreach ($menu->children as $child)
    @include('admin.menus.partials.menu-row', ['menu' => $child, 'level' => $level + 1])
@endforeach
