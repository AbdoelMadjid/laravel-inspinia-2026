<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index(Request $request)
    {
        $query = Permission::with(['roles.users']);

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            $query->where('name', 'like', "%{$search}%");
        }

        $permissions = $query->orderBy('name')->get();
        $roles = Role::all();

        return view('admin.system.permissions.permissions', compact('permissions', 'roles'));
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        Permission::create([
            'name' => strtolower($validated['name']),
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission successfully created.');
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
        ]);

        $permission->update(['name' => strtolower($validated['name'])]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission successfully updated.');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission successfully deleted.');
    }
}
