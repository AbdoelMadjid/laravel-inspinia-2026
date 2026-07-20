<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $user = Auth::user();

        // Fetch root menus with eager-loaded children and roles
        $rootMenus = Menu::with(['activeChildren.activeChildren.roles', 'roles'])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Filter menus based on user visibility & Spatie roles/permissions
        $filteredMenus = $rootMenus->filter(function (Menu $menu) use ($user) {
            return $menu->isVisibleForUser($user);
        });

        $view->with('sidebarMenus', $filteredMenus);
    }
}
