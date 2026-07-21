<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\Menu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuController extends Controller
{
    /**
     * Display a listing of menus.
     */
    public function index()
    {
        $menus = Menu::with(['children.children', 'roles', 'parent'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $allMenus = Menu::orderBy('name')->get();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.system.menus.menus', compact('menus', 'allMenus', 'roles', 'permissions'));
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'type' => 'required|in:header,item,divider',
            'icon' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'target' => 'nullable|string|in:_self,_blank',
            'badge_text' => 'nullable|string|max:50',
            'badge_class' => 'nullable|string|max:100',
            'permission_name' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'data_lang' => 'nullable|string|max:100',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $menu = Menu::create($validated);

        if (!empty($request->roles)) {
            $menu->roles()->sync($request->roles);
        }

        return redirect()->route('admin.menus.index')->with('success', 'Menu successfully created.');
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'type' => 'required|in:header,item,divider',
            'icon' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'target' => 'nullable|string|in:_self,_blank',
            'badge_text' => 'nullable|string|max:50',
            'badge_class' => 'nullable|string|max:100',
            'permission_name' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'data_lang' => 'nullable|string|max:100',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        if ($request->has('roles')) {
            $menu->roles()->sync($request->roles);
        } else {
            $menu->roles()->detach();
        }

        return redirect()->route('admin.menus.index')->with('success', 'Menu successfully updated.');
    }

    /**
     * Remove the specified menu item.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu successfully deleted.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);
        return redirect()->route('admin.menus.index')->with('success', 'Menu status updated.');
    }
}
