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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
     * Download native Excel (.xlsx) import template for bulk user registration.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import User');

        // Header Styling
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'], // Primary Theme Color
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];

        // Column Headers
        $headers = ['Name', 'Email', 'Password', 'Role', 'Is Approved'];
        $columnLetter = 'A';
        foreach ($headers as $headerText) {
            $sheet->setCellValue($columnLetter . '1', $headerText);
            $columnLetter++;
        }
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(26);

        // Sample Data Rows
        $sampleData = [
            ['Budi Santoso', 'budi.santoso@example.com', 'password123', 'user', '1'],
            ['Siti Rahma', 'siti.rahma@example.com', 'password123', 'user', '1'],
        ];

        $rowNum = 2;
        foreach ($sampleData as $dataRow) {
            $colLetter = 'A';
            foreach ($dataRow as $value) {
                $sheet->setCellValue($colLetter . $rowNum, $value);
                $colLetter++;
            }
            $rowNum++;
        }

        // Auto-fit Column Widths
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_import_user.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Import users from uploaded Excel (.xlsx, .xls) or CSV file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt', 'max:5120'],
            'default_role' => ['nullable', 'string', 'exists:roles,name'],
            'default_approval' => ['nullable', 'boolean'],
        ], [
            'file.required' => 'Silakan pilih berkas Excel (.xlsx / .xls) untuk diunggah.',
            'file.mimes' => 'Format berkas harus berupa Excel (.xlsx / .xls) atau CSV.',
            'file.max' => 'Ukuran berkas maksimal 5MB.',
        ]);

        $file = $request->file('file');
        $filePath = $file->getRealPath();

        $defaultRoleName = $request->input('default_role', 'user');
        $defaultApproval = $request->boolean('default_approval', true);

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca berkas Excel: ' . $e->getMessage());
        }

        if (empty($rows) || count($rows) < 2) {
            return redirect()->back()->with('error', 'Berkas Excel kosong atau tidak memiliki data.');
        }

        // Extract Header row (row 1)
        $headerRow = array_shift($rows);
        $headerMap = [];
        foreach ($headerRow as $colKey => $colName) {
            if ($colName) {
                $headerMap[$colKey] = strtolower(trim(str_replace(['"', "'"], '', (string)$colName)));
            }
        }

        // Find column keys
        $nameKey = array_search('name', $headerMap);
        if ($nameKey === false) $nameKey = array_search('nama', $headerMap);

        $emailKey = array_search('email', $headerMap);

        $passKey = array_search('password', $headerMap);
        if ($passKey === false) $passKey = array_search('kata sandi', $headerMap);

        $roleKey = array_search('role', $headerMap);

        $approvalKey = array_search('is approved', $headerMap);
        if ($approvalKey === false) $approvalKey = array_search('approved', $headerMap);

        if ($nameKey === false || $emailKey === false) {
            return redirect()->back()->with('error', 'Kolom wajib "Name" dan "Email" tidak ditemukan di berkas Excel.');
        }

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($rows as $row) {
            $name = isset($row[$nameKey]) ? trim((string)$row[$nameKey]) : null;
            $email = isset($row[$emailKey]) ? trim(strtolower((string)$row[$emailKey])) : null;

            if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skippedCount++;
                continue;
            }

            // Check duplicate email
            if (User::where('email', $email)->exists()) {
                $skippedCount++;
                continue;
            }

            $rawPass = ($passKey !== false && !empty($row[$passKey])) ? trim((string)$row[$passKey]) : 'password123';
            $roleName = ($roleKey !== false && !empty($row[$roleKey])) ? trim(strtolower((string)$row[$roleKey])) : $defaultRoleName;

            $isApproved = $defaultApproval;
            if ($approvalKey !== false && isset($row[$approvalKey])) {
                $val = trim((string)$row[$approvalIndex ?? $approvalKey]);
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

        $msg = "Berhasil mengimpor {$importedCount} pengguna baru dari Excel.";
        if ($skippedCount > 0) {
            $msg .= " {$skippedCount} baris dilewati (email ganda atau data tidak valid).";
        }

        return redirect()->route('admin.users.index')->with('success', $msg);
    }
}
