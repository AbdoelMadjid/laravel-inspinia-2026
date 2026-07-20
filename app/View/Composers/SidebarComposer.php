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

        $showTemplateMenus = \App\Models\AppFeature::isEnabled('template_menus');

        // Filter menus based on user visibility & Spatie roles/permissions & feature toggle
        $filteredMenus = $rootMenus->filter(function (Menu $menu) use ($user, $showTemplateMenus) {
            if (!$showTemplateMenus && $menu->sort_order >= 100) {
                return false;
            }
            return $menu->isVisibleForUser($user);
        });

        $view->with('sidebarMenus', $filteredMenus);
    }
}
