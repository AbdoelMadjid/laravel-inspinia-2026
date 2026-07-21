<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])
            ->with(['permissions', 'users' => function($q) {
                $q->limit(5);
            }])
            ->get();

        $permissions = Permission::orderBy('name')->get();

        return view('admin.system.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Display the specified role details.
     */
    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        $allPermissions = Permission::orderBy('name')->get();

        return view('admin.system.roles.show', compact('role', 'allPermissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role = Role::create([
            'name' => strtolower($validated['name']),
            'guard_name' => 'web',
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role successfully created.');
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role->update(['name' => strtolower($validated['name'])]);

        if ($request->has('permissions')) {
            $role->syncPermissions($validated['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role successfully updated.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('admin.roles.index')->with('error', 'The default admin role cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role successfully deleted.');
    }
}
