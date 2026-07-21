<?php

namespace App\View\Composers;

use App\Models\Admin\System\AppFeature;
use App\Models\Admin\System\Menu;
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

        // Fetch root database menus with eager-loaded children and roles
        $rootMenus = Menu::with(['activeChildren.activeChildren.roles', 'roles'])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Filter database menus based on user visibility & Spatie roles/permissions
        $filteredMenus = $rootMenus->filter(function (Menu $menu) use ($user) {
            return $menu->isVisibleForUser($user);
        });

        // Merge hardcoded demo template menus if feature is enabled
        $showTemplateMenus = AppFeature::isEnabled('template_menus');
        if ($showTemplateMenus) {
            $templateArray = config('template_menus', []);
            $templateCollection = collect($templateArray)->map(function ($item) {
                return $this->arrayToMenuModel($item);
            });
            $filteredMenus = $filteredMenus->concat($templateCollection);
        }

        $view->with('sidebarMenus', $filteredMenus);
    }

    /**
     * Convert hardcoded array array to Menu model instance in memory.
     */
    protected function arrayToMenuModel(array $item): Menu
    {
        $menu = new Menu();
        $menu->id = null;
        $menu->name = $item['name'] ?? '';
        $menu->type = $item['type'] ?? 'item';
        $menu->icon = $item['icon'] ?? null;
        $menu->route_name = $item['route_name'] ?? null;
        $menu->route_params = $item['route_params'] ?? null;
        $menu->url = $item['url'] ?? null;
        $menu->badge_text = $item['badge_text'] ?? null;
        $menu->badge_variant = $item['badge_variant'] ?? 'primary';
        $menu->is_active = true;
        $menu->sort_order = $item['sort_order'] ?? 999;
        $menu->setRelation('roles', collect());

        $children = collect();
        if (!empty($item['children'])) {
            foreach ($item['children'] as $childArray) {
                $children->push($this->arrayToMenuModel($childArray));
            }
        }
        $menu->setRelation('activeChildren', $children);
        $menu->setRelation('children', $children);

        return $menu;
    }
}
