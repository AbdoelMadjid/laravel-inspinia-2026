<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $roleName = $request->role;
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        $users = $query->orderBy('name')->paginate(12)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:2048'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'avatar' => $avatarPath,
        ]);

        $rolesToAssign = $request->input('roles', []);
        if (empty($rolesToAssign) && $request->filled('role')) {
            $rolesToAssign = [$request->role];
        }

        if (!empty($rolesToAssign)) {
            $user->syncRoles($rolesToAssign);
        }

        return redirect()->route('admin.users.index')->with('success', 'User successfully created.');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:2048'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userData);

        $rolesToSync = $request->input('roles', null);
        if ($rolesToSync === null && $request->has('role')) {
            $rolesToSync = $request->role ? [$request->role] : [];
        }

        if ($rolesToSync !== null) {
            $user->syncRoles($rolesToSync);
        }

        return redirect()->route('admin.users.index')->with('success', 'User successfully updated.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own user account.');
        }

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User successfully deleted.');
    }

    /**
     * Bulk assign role(s) to selected users.
     */
    public function bulkAssignRole(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
            'action_mode' => ['nullable', 'string', 'in:sync,add'],
        ]);

        $targetRoles = $request->input('roles', []);
        if (empty($targetRoles) && $request->filled('role')) {
            $targetRoles = [$request->role];
        }

        if (empty($targetRoles)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Silakan pilih minimal 1 role untuk diberikan kepada user.');
        }

        $actionMode = $request->input('action_mode', 'sync');
        $userIds = $validated['user_ids'];

        $users = User::whereIn('id', $userIds)->get();

        foreach ($users as $user) {
            if ($actionMode === 'add') {
                $user->assignRole($targetRoles);
            } else {
                $user->syncRoles($targetRoles);
            }
        }

        $count = $users->count();
        $rolesTitle = implode(', ', array_map('ucfirst', $targetRoles));

        return redirect()->route('admin.users.index')
            ->with('success', "Role '{$rolesTitle}' massal berhasil diberikan kepada {$count} user!");
    }

    /**
     * Impersonate / switch to the specified user account.
     */
    public function impersonate(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat beralih ke akun Anda sendiri.');
        }

        // Store original user ID if not already impersonating
        if (!session()->has('impersonator_id')) {
            session(['impersonator_id' => $currentUser->id]);
        }

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', "Berhasil beralih ke akun {$user->name}.");
    }

    /**
     * Stop impersonating and return to original admin account.
     */
    public function impersonateStop(Request $request)
    {
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda sedang tidak dalam mode switch akun.');
        }

        $impersonatorId = session()->pull('impersonator_id');
        $originalUser = User::find($impersonatorId);

        if (!$originalUser) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun asli tidak ditemukan.');
        }

        Auth::login($originalUser);

        return redirect()->route('admin.users.index')
            ->with('success', "Kembali ke akun asli ({$originalUser->name}).");
    }
}
