<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\ActivityLog;
use App\Models\Admin\System\AppFeature;
use App\Models\Admin\System\LoginLog;
use App\Models\Admin\System\Menu;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AboutController extends Controller
{
    /**
     * Display the About & Documentation page.
     */
    public function index(): View
    {
        // System Information
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug') ? 'Aktif (True)' : 'Nonaktif (False)',
            'db_connection' => config('database.default'),
            'db_version' => $this->getDatabaseVersion(),
            'timezone' => config('app.timezone'),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown / CLI',
            'os' => PHP_OS_FAMILY,
        ];

        // System Metrics & Entity Counts
        $metrics = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'total_menus' => Menu::count(),
            'total_features' => AppFeature::count(),
            'total_login_logs' => LoginLog::count(),
            'total_activity_logs' => ActivityLog::count(),
            'total_backups' => $this->getBackupCount(),
        ];

        return view('admin.system.about.about', compact('systemInfo', 'metrics'));
    }

    /**
     * Get Database Version string safely.
     */
    protected function getDatabaseVersion(): string
    {
        try {
            $pdo = DB::connection()->getPdo();
            return $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION) ?? 'Unknown';
        } catch (\Throwable $e) {
            return 'N/A';
        }
    }

    /**
     * Count existing backup files in storage/app/backups.
     */
    protected function getBackupCount(): int
    {
        $backupDir = storage_path('app/backups');
        if (File::exists($backupDir)) {
            return count(File::files($backupDir));
        }
        return 0;
    }
}
