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

        if (empty($validated['sort_order']) || $validated['sort_order'] == 0) {
            $maxOrder = Menu::where('parent_id', $validated['parent_id'] ?? null)->max('sort_order') ?? 0;
            $validated['sort_order'] = $maxOrder + 1;
        }

        $menu = Menu::create($validated);

        if (!empty($validated['permission_name'])) {
            $perm = Permission::firstOrCreate(['name' => $validated['permission_name']]);
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole && !$adminRole->hasPermissionTo($perm)) {
                $adminRole->givePermissionTo($perm);
            }
        }

        if (!empty($request->roles)) {
            $menu->roles()->sync($request->roles);
        } else {
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $menu->roles()->sync([$adminRole->id]);
            }
        }

        if (!empty($validated['data_lang'])) {
            $this->syncTranslationKey($validated['data_lang'], $validated['name'], $validated['name']);
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

        if (!empty($validated['permission_name'])) {
            $perm = Permission::firstOrCreate(['name' => $validated['permission_name']]);
            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole && !$adminRole->hasPermissionTo($perm)) {
                $adminRole->givePermissionTo($perm);
            }
        }

        if ($request->has('roles')) {
            $menu->roles()->sync($request->roles);
        } else {
            $menu->roles()->detach();
        }

        if (!empty($validated['data_lang'])) {
            $this->syncTranslationKey($validated['data_lang'], $validated['name'], $validated['name']);
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

    /**
     * Reorder menu items via drag-and-drop.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:menus,id',
            'orders.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Menu::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan menu berhasil diperbarui.',
        ]);
    }

    /**
     * Automatically update or append translation keys to en.json and id.json.
     */
    protected function syncTranslationKey(string $key, string $textEn, string $textId): void
    {
        $enPath = public_path('assets/data/translations/en.json');
        $idPath = public_path('assets/data/translations/id.json');

        if (file_exists($enPath)) {
            $enJson = json_decode(file_get_contents($enPath), true) ?: [];
            if (!isset($enJson[$key])) {
                $enJson[$key] = $textEn;
                file_put_contents($enPath, json_encode($enJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }

        if (file_exists($idPath)) {
            $idJson = json_decode(file_get_contents($idPath), true) ?: [];
            if (!isset($idJson[$key])) {
                $idJson[$key] = $textId;
                file_put_contents($idPath, json_encode($idJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }
}
