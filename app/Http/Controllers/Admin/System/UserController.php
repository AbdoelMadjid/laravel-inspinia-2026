<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\User;
use App\Models\Admin\System\ActivityLog;
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
        if ($request->ajax() || $request->wantsJson() || $request->has('draw') || $request->has('start') || $request->query('draw')) {
            $query = User::with('roles');

            $totalRecords = User::count();

            // Search by name or email
            $searchValue = $request->input('search_text') ?? $request->input('search.value') ?? $request->input('search');
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%")
                      ->orWhere('email', 'like', "%{$searchValue}%");
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

            $filteredRecords = (clone $query)->count();

            // Sorting by Tanggal Bergabung (created_at) from oldest to newest (asc)
            $orderColumnIndex = $request->input('order_col') ?? $request->input('order.0.column', 6);
            $orderDir = $request->input('order_dir') ?? $request->input('order.0.dir', 'asc');

            $columnsMap = [
                0 => 'created_at',
                1 => 'created_at',
                2 => 'name',
                3 => 'email',
                4 => 'points',
                5 => 'is_approved',
                6 => 'created_at',
                7 => 'created_at',
            ];

            $sortColumn = $columnsMap[$orderColumnIndex] ?? 'created_at';
            $query->orderBy($sortColumn, strtolower($orderDir) === 'asc' ? 'asc' : 'desc');

            // Pagination offset & limit
            $start = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 10);
            if ($length > 0) {
                $query->skip($start)->take($length);
            }

            $users = $query->get();
            $authUserId = Auth::id();

            $data = $users->map(function ($user) use ($authUserId) {
                // Checkbox
                $checkbox = '<div class="form-check text-center m-0">
                    <input class="form-check-input user-checkbox border-secondary" type="checkbox" value="' . $user->id . '" data-user-name="' . e($user->name) . '" style="border-color: #495057; border-width: 1.5px;">
                </div>';

                // Online indicator & Avatar HTML
                $onlineIndicator = $user->isOnline() 
                    ? '<span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle shadow-sm" style="width: 12px; height: 12px;" title="Online sekarang" data-bs-toggle="tooltip"></span>' 
                    : '<span class="position-absolute bottom-0 end-0 p-1 bg-secondary border border-white rounded-circle shadow-sm" style="width: 12px; height: 12px;" title="' . e($user->last_seen_text) . '" data-bs-toggle="tooltip"></span>';

                $avatarHtml = '<div class="position-relative d-inline-block">
                    <img src="' . e($user->avatar_url) . '" class="rounded-circle avatar-sm object-fit-cover" style="width: 40px; height: 40px;" alt="' . e($user->name) . '">
                    ' . $onlineIndicator . '
                </div>';

                // User Name & Email HTML
                $userHtml = '<div class="overflow-hidden">
                    <div class="fw-semibold text-dark text-truncate">' . e($user->name) . '</div>
                    <div class="text-muted fs-xs text-truncate">' . e($user->email) . '</div>
                </div>';

                // Roles HTML
                $rolesHtml = '<div class="d-flex align-items-center flex-wrap gap-1">';
                if ($user->roles->isNotEmpty()) {
                    foreach ($user->roles as $role) {
                        $rolesHtml .= '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-11 rounded-pill">' . e(ucfirst($role->name)) . '</span>';
                    }
                } else {
                    $rolesHtml .= '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 fs-11 rounded-pill">No Role</span>';
                }
                $rolesHtml .= '</div>';

                // Points HTML
                $pointsHtml = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 fs-11 rounded-pill" title="Total Poin Login Harian">
                    <i class="ti ti-star-filled me-1"></i> ' . ($user->points ?? 0) . ' Poin
                </span>';

                // Status HTML
                if ($user->is_approved) {
                    $statusHtml = '<span class="text-success fs-xs fw-semibold d-inline-flex align-items-center" title="Akun Disetujui / Aktif"><i class="ti ti-circle-check me-1 fs-14"></i> Disetujui</span>';
                } else {
                    $statusHtml = '<div class="d-flex align-items-center gap-2">
                        <span class="text-warning fs-xs fw-semibold d-inline-flex align-items-center"><i class="ti ti-clock me-1 fs-14"></i> Pending</span>
                        <form method="POST" action="' . route('admin.users.toggle-approval', $user->id) . '" id="approve-user-form-' . $user->id . '">
                            ' . csrf_field() . method_field('PATCH') . '
                            <button type="button" class="btn btn-sm btn-success fw-semibold py-0 px-2 fs-11"
                                data-swal-confirm="true"
                                data-swal-title="Setujui Akun Pengguna?"
                                data-swal-text="Akun ' . e($user->name) . ' akan disetujui dan diizinkan untuk login."
                                data-swal-icon="info"
                                data-swal-confirm-text="Ya, Setujui Akun!"
                                data-form-id="approve-user-form-' . $user->id . '">
                                Setujui
                            </button>
                        </form>
                    </div>';
                }

                // Joined Date HTML
                $joinedDateHtml = $user->created_at ? $user->created_at->format('d M Y, H:i') : '-';

                // Actions Dropdown HTML
                $userRolesJson = e(json_encode($user->roles->pluck('name')->toArray()));
                $actionsHtml = '<div class="dropdown text-center">
                    <a href="#" class="btn btn-icon btn-ghost-light text-muted btn-sm" data-bs-toggle="dropdown">
                        <i class="ti ti-dots-vertical fs-lg"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">';

                if ($user->id !== $authUserId) {
                    $actionsHtml .= '<li>
                        <form method="POST" action="' . route('admin.users.impersonate', $user->id) . '">
                            ' . csrf_field() . '
                            <button type="submit" class="dropdown-item text-primary fw-semibold fs-13">
                                <i class="ti ti-arrows-exchange me-2"></i> Switch Akun
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider"></li>';
                }

                $actionsHtml .= '<li>
                    <a class="dropdown-item edit-user-btn fs-13" href="javascript:void(0);"
                        data-user-id="' . $user->id . '"
                        data-user-name="' . e($user->name) . '"
                        data-user-email="' . e($user->email) . '"
                        data-user-avatar="' . e($user->avatar_url) . '"
                        data-user-roles=\'' . $userRolesJson . '\'
                        data-update-url="' . route('admin.users.update', $user->id) . '">
                        <i class="ti ti-edit me-2"></i> Edit
                    </a>
                </li>';

                if ($user->id !== $authUserId) {
                    if ($user->is_approved) {
                        $actionsHtml .= '<li>
                            <form method="POST" action="' . route('admin.users.toggle-approval', $user->id) . '" id="deactivate-user-form-' . $user->id . '">
                                ' . csrf_field() . method_field('PATCH') . '
                                <button type="button" class="dropdown-item text-warning fs-13"
                                    data-swal-confirm="true"
                                    data-swal-title="Nonaktifkan Akun?"
                                    data-swal-text="Akun ' . e($user->name) . ' tidak akan bisa login sampai disetujui kembali."
                                    data-swal-icon="warning"
                                    data-swal-confirm-text="Ya, Nonaktifkan!"
                                    data-form-id="deactivate-user-form-' . $user->id . '">
                                    <i class="ti ti-ban me-2"></i> Nonaktifkan
                                </button>
                            </form>
                        </li>';
                    }

                    $actionsHtml .= '<li>
                        <form method="POST" action="' . route('admin.users.destroy', $user->id) . '" id="delete-user-form-' . $user->id . '">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="dropdown-item text-danger fs-13"
                                data-swal-confirm="true"
                                data-swal-title="Hapus User?"
                                data-swal-text="Apakah Anda yakin ingin menghapus user \'' . e($user->name) . '\'?"
                                data-swal-confirm-text="Ya, Hapus!"
                                data-form-id="delete-user-form-' . $user->id . '">
                                <i class="ti ti-trash me-2"></i> Delete
                            </button>
                        </form>
                    </li>';
                }

                $actionsHtml .= '</ul></div>';

                return [
                    'checkbox' => $checkbox,
                    'avatar' => $avatarHtml,
                    'user' => $userHtml,
                    'roles' => $rolesHtml,
                    'points' => $pointsHtml,
                    'status' => $statusHtml,
                    'created_at' => $joinedDateHtml,
                    'actions' => $actionsHtml,
                ];
            });

            return response()->json([
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        }

        $roles = Role::all();
        $status = $request->get('status');

        return view('admin.system.users.users', compact('roles', 'status'));
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

        session(['is_switching_account' => true]);
        Auth::login($user);
        session()->forget('is_switching_account');

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

        session(['is_switching_account' => true]);
        Auth::login($originalUser);
        session()->forget('is_switching_account');

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

        ActivityLog::log('IMPORT_USERS', "Mengimpor {$importedCount} pengguna baru via berkas Excel.");

        return redirect()->route('admin.users.index')->with('success', $msg);
    }

    /**
     * Export filtered users to styled Excel (.xlsx) file.
     */
    public function exportExcel(Request $request)
    {
        $query = User::with('roles')->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $users = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Data Pengguna');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']], // Success Green
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ];

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama Pengguna');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Role / Peran');
        $sheet->setCellValue('E1', 'Status Persetujuan');
        $sheet->setCellValue('F1', 'Poin');
        $sheet->setCellValue('G1', 'Terakhir Aktif');
        $sheet->setCellValue('H1', 'Tanggal Bergabung');

        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(26);

        $rowNum = 2;
        foreach ($users as $u) {
            $sheet->setCellValue('A' . $rowNum, $u->id);
            $sheet->setCellValue('B' . $rowNum, $u->name);
            $sheet->setCellValue('C' . $rowNum, $u->email);
            $sheet->setCellValue('D' . $rowNum, $u->roles->pluck('name')->map('ucfirst')->join(', ') ?: 'User');
            $sheet->setCellValue('E' . $rowNum, $u->is_approved ? 'Disetujui' : 'Pending');
            $sheet->setCellValue('F' . $rowNum, $u->points ?? 0);
            $sheet->setCellValue('G' . $rowNum, $u->last_seen_text);
            $sheet->setCellValue('H' . $rowNum, $u->created_at ? $u->created_at->format('d M Y H:i') : '-');
            $rowNum++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        ActivityLog::log('EXPORT_USERS_EXCEL', "Mengunduh rekap Excel data pengguna ({$users->count()} baris).");

        $writer = new Xlsx($spreadsheet);
        $filename = 'export_users_' . date('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    /**
     * Export filtered users to printable view.
     */
    public function exportPdf(Request $request)
    {
        $query = User::with('roles')->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $users = $query->get();

        ActivityLog::log('EXPORT_USERS_PDF', "Mencetak laporan PDF data pengguna ({$users->count()} baris).");

        return view('admin.system.users.export-pdf', compact('users'));
    }

    /**
     * Bulk approve selected users.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        $count = User::whereIn('id', $request->user_ids)
            ->where('is_approved', false)
            ->update(['is_approved' => true]);

        ActivityLog::log('BULK_APPROVE', "Menyetujui {$count} akun pengguna secara massal.");

        return redirect()->back()->with('success', "Berhasil menyetujui {$count} akun pengguna secara massal.");
    }

    /**
     * Bulk delete selected users (except self).
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        // Prevent self-deletion
        $userIds = array_diff($request->user_ids, [auth()->id()]);

        $users = User::whereIn('id', $userIds)->get();
        $names = $users->pluck('name')->join(', ');
        $count = $users->count();

        foreach ($users as $user) {
            $user->delete();
        }

        ActivityLog::log('BULK_DELETE', "Menghapus {$count} pengguna secara massal: {$names}.");

        return redirect()->back()->with('success', "Berhasil menghapus {$count} pengguna secara massal.");
    }
}
