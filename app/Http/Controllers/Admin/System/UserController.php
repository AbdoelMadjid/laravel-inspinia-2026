<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\User;
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

        // Filter by approval status
        $status = $request->get('status');
        if ($status === 'pending') {
            $query->where('is_approved', false);
        } elseif ($status === 'approved') {
            $query->where('is_approved', true);
        }

        $users = $query->orderBy('is_approved', 'asc')->orderBy('name', 'asc')->paginate(12)->withQueryString();
        $roles = Role::all();

        return view('admin.system.users.users', compact('users', 'roles', 'status'));
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

    /**
     * Toggle approval status for the specified user account.
     */
    public function toggleApproval(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah status persetujuan akun Anda sendiri.');
        }

        $user->update([
            'is_approved' => !$user->is_approved,
        ]);

        $statusText = $user->is_approved ? 'disetujui dan diaktifkan' : 'dinonaktifkan / ditolak';

        return redirect()->back()->with('success', "Status akun {$user->name} berhasil {$statusText}.");
    }

    /**
     * Download CSV/Excel import template for bulk user registration.
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_user.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel auto-detecting UTF-8 encoding
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, ['Name', 'Email', 'Password', 'Role', 'Is Approved']);

            // Sample rows
            fputcsv($file, ['Budi Santoso', 'budi.santoso@example.com', 'password123', 'user', '1']);
            fputcsv($file, ['Siti Rahma', 'siti.rahma@example.com', 'password123', 'user', '1']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import users from uploaded CSV / Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:5120'],
            'default_role' => ['nullable', 'string', 'exists:roles,name'],
            'default_approval' => ['nullable', 'boolean'],
        ], [
            'file.required' => 'Silakan pilih berkas CSV/Excel untuk diunggah.',
            'file.mimes' => 'Format berkas harus berupa CSV atau TXT.',
            'file.max' => 'Ukuran berkas maksimal 5MB.',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $defaultRoleName = $request->input('default_role', 'user');
        $defaultApproval = $request->boolean('default_approval', true);

        $handle = fopen($path, 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Gagal membuka berkas yang diunggah.');
        }

        // Check UTF-8 BOM
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle, 1000, ',');
        // Support semicolon separator if comma fails
        if ($header && count($header) == 1 && str_contains($header[0], ';')) {
            rewind($handle);
            if ($bom === "\xEF\xBB\xBF") fread($handle, 3);
            $header = fgetcsv($handle, 1000, ';');
            $delimiter = ';';
        } else {
            $delimiter = ',';
        }

        if (!$header || count($header) < 2) {
            fclose($handle);
            return redirect()->back()->with('error', 'Format header berkas tidak valid. Gunakan template yang disediakan.');
        }

        // Map column names (lowercase)
        $headerMap = array_map(fn($col) => strtolower(trim(str_replace(['"', "'"], '', $col))), $header);

        $nameIndex = array_search('name', $headerMap);
        if ($nameIndex === false) $nameIndex = array_search('nama', $headerMap);

        $emailIndex = array_search('email', $headerMap);

        $passIndex = array_search('password', $headerMap);
        if ($passIndex === false) $passIndex = array_search('kata sandi', $headerMap);

        $roleIndex = array_search('role', $headerMap);
        $approvalIndex = array_search('is approved', $headerMap);
        if ($approvalIndex === false) $approvalIndex = array_search('approved', $headerMap);

        if ($nameIndex === false || $emailIndex === false) {
            fclose($handle);
            return redirect()->back()->with('error', 'Kolom wajib "Name" dan "Email" tidak ditemukan di berkas.');
        }

        $importedCount = 0;
        $skippedCount = 0;

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (empty(array_filter($row))) {
                continue; // Skip empty lines
            }

            $name = isset($row[$nameIndex]) ? trim($row[$nameIndex]) : null;
            $email = isset($row[$emailIndex]) ? trim(strtolower($row[$emailIndex])) : null;

            if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skippedCount++;
                continue;
            }

            // Check duplicate email
            if (User::where('email', $email)->exists()) {
                $skippedCount++;
                continue;
            }

            $rawPass = ($passIndex !== false && !empty($row[$passIndex])) ? trim($row[$passIndex]) : 'password123';
            $roleName = ($roleIndex !== false && !empty($row[$roleIndex])) ? trim(strtolower($row[$roleIndex])) : $defaultRoleName;
            
            $isApproved = $defaultApproval;
            if ($approvalIndex !== false && isset($row[$approvalIndex])) {
                $val = trim($row[$approvalIndex]);
                if (in_array(strtolower($val), ['1', 'true', 'yes', 'ya'])) {
                    $isApproved = true;
                } elseif (in_array(strtolower($val), ['0', 'false', 'no', 'tidak'])) {
                    $isApproved = false;
                }
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($rawPass),
                'email_verified_at' => now(),
                'is_approved' => $isApproved,
            ]);

            // Assign role
            $roleObj = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $user->assignRole($roleObj);

            $importedCount++;
        }

        fclose($handle);

        $msg = "Berhasil mengimpor {$importedCount} pengguna baru.";
        if ($skippedCount > 0) {
            $msg .= " {$skippedCount} baris dilewati (email ganda atau data tidak valid).";
        }

        return redirect()->route('admin.users.index')->with('success', $msg);
    }
}
