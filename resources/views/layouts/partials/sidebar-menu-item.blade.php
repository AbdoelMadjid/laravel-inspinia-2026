@php
    $user = Auth::user();
    if (!$menu->isVisibleForUser($user)) {
        return;
    }
@endphp

@if ($menu->type === 'header')
    <li class="side-nav-title mt-2" @if(!empty($menu->data_lang)) data-lang="{{ $menu->data_lang }}" @endif>
        {{ $menu->name }}
    </li>
@elseif ($menu->type === 'divider')
    <li class="side-nav-divider"></li>
@else
    @php
        $visibleChildren = $menu->activeChildren->filter(fn($child) => $child->isVisibleForUser($user));
        $hasChildren = $visibleChildren->isNotEmpty();
        $isActive = $menu->isActiveRoute();
        $collapseId = 'menu-collapse-' . $menu->id;
        $linkClass = $menu->link_class ? ' ' . $menu->link_class : '';
    @endphp

    @if ($hasChildren)
        <li class="side-nav-item {{ $isActive ? 'active' : '' }}">
            <a data-bs-toggle="collapse" href="#{{ $collapseId }}" aria-expanded="{{ $isActive ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}" class="side-nav-link{{ $linkClass }} {{ $isActive ? 'active' : '' }}">
                @if(!empty($menu->icon))
                    <span class="menu-icon"><i class="{{ $menu->icon }}"></i></span>
                @else
                    <span class="menu-icon d-inline-flex align-items-center justify-content-center"><i class="{{ $isActive ? 'ti ti-circle-filled text-primary' : 'ti ti-circle' }}" style="font-size: 7px; vertical-align: middle;"></i></span>
                @endif
                <span class="menu-text" @if(!empty($menu->data_lang)) data-lang="{{ $menu->data_lang }}" @endif>{{ $menu->name }}</span>
                @if(!empty($menu->badge_text))
                    <span class="{{ $menu->badge_class ?? 'badge bg-primary float-end' }}">{{ $menu->badge_text }}</span>
                @endif
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse {{ $isActive ? 'show' : '' }}" id="{{ $collapseId }}">
                <ul class="sub-menu">
                    @foreach($visibleChildren as $child)
                        @include('layouts.partials.sidebar-menu-item', ['menu' => $child])
                    @endforeach
                </ul>
            </div>
        </li>
    @else
        <li class="side-nav-item {{ $isActive ? 'active' : '' }}">
            <a href="{{ $menu->resolved_url }}" target="{{ $menu->target ?? '_self' }}" class="side-nav-link{{ $linkClass }} {{ $isActive ? 'active' : '' }}">
                @if(!empty($menu->icon))
                    <span class="menu-icon"><i class="{{ $menu->icon }}"></i></span>
                @else
                    <span class="menu-icon d-inline-flex align-items-center justify-content-center"><i class="{{ $isActive ? 'ti ti-circle-filled text-primary' : 'ti ti-circle' }}" style="font-size: 7px; vertical-align: middle;"></i></span>
                @endif
                <span class="menu-text" @if(!empty($menu->data_lang)) data-lang="{{ $menu->data_lang }}" @endif>{{ $menu->name }}</span>
                @if(!empty($menu->badge_text))
                    <span class="{{ $menu->badge_class ?? 'badge bg-primary float-end' }}">{{ $menu->badge_text }}</span>
                @endif
            </a>
        </li>
    @endif
@endif
