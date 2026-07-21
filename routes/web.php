<?php

use App\Http\Controllers\Admin\System\AppFeatureController;
use App\Http\Controllers\Admin\System\AppProfileController;
use App\Http\Controllers\Admin\System\BackupController;
use App\Http\Controllers\Admin\System\LoginLogController;
use App\Http\Controllers\Admin\System\MenuController;
use App\Http\Controllers\Admin\System\NotificationController;
use App\Http\Controllers\Admin\System\PasswordResetRequestController;
use App\Http\Controllers\Admin\System\PermissionController;
use App\Http\Controllers\Admin\System\ProfileController;
use App\Http\Controllers\Admin\System\RoleController;
use App\Http\Controllers\Admin\System\UserController;
use App\Http\Controllers\Admin\System\ActivityLogController;
use Illuminate\Support\Facades\Route;

// Home / Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Breeze Auth Routes (login, register, forgot-password, logout, etc.)
require __DIR__.'/auth.php';

// Dashboard Page (Admin Dashboard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Protected Admin Pages
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/impersonate/stop', [UserController::class, 'impersonateStop'])->name('admin.users.impersonate-stop');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Apps Management Group
        Route::prefix('apps-management')->group(function () {
            Route::post('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
            Route::patch('menus/{menu}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menus.toggle-status');
            Route::resource('menus', MenuController::class);

            Route::patch('app-features/{appFeature}/toggle-status', [AppFeatureController::class, 'toggleStatus'])->name('app-features.toggle-status');
            Route::resource('app-features', AppFeatureController::class);

            Route::get('app-profile', [AppProfileController::class, 'index'])->name('app-profile.index');
            Route::put('app-profile', [AppProfileController::class, 'update'])->name('app-profile.update');

            Route::get('backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
            Route::delete('backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');
            Route::resource('backups', BackupController::class)->only(['index', 'store']);

            Route::resource('login-logs', LoginLogController::class)->only(['index']);
            Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        });

        // Users Management Group
        Route::prefix('users-management')->group(function () {
            Route::get('users/export-template', [UserController::class, 'downloadTemplate'])->name('users.export-template');
            Route::get('users/export-excel', [UserController::class, 'exportExcel'])->name('users.export-excel');
            Route::get('users/export-pdf', [UserController::class, 'exportPdf'])->name('users.export-pdf');
            Route::post('users/import', [UserController::class, 'import'])->name('users.import');
            Route::post('users/bulk-assign-role', [UserController::class, 'bulkAssignRole'])->name('users.bulk-assign-role');
            Route::post('users/bulk-approve', [UserController::class, 'bulkApprove'])->name('users.bulk-approve');
            Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');
            Route::post('users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
            Route::patch('users/{user}/toggle-approval', [UserController::class, 'toggleApproval'])->name('users.toggle-approval');
            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::post('password-reset-requests/{passwordResetRequest}/reset', [PasswordResetRequestController::class, 'resetPassword'])->name('password-reset-requests.reset');
            Route::post('password-reset-requests/{passwordResetRequest}/reject', [PasswordResetRequestController::class, 'reject'])->name('password-reset-requests.reject');
            Route::resource('password-reset-requests', PasswordResetRequestController::class);
        });
    });

    Route::get('/{page}', function ($page) {
        if ($page === 'landing') {
            return view('template.landing');
        }
        if ($page === 'index' || $page === 'dashboard-projects') {
            return view('template.index');
        }
        if ($page === 'profile-page') {
            return view('admin.system.profile.profile-index');
        }
        if (view()->exists('admin.system.' . $page)) {
            return view('admin.system.' . $page);
        }
        if (view()->exists('admin.system.' . $page . '.' . $page)) {
            return view('admin.system.' . $page . '.' . $page);
        }
        if (view()->exists('admin.system.profile.' . $page)) {
            return view('admin.system.profile.' . $page);
        }
        if (view()->exists('template.' . $page)) {
            return view('template.' . $page);
        }
        if (view()->exists('admin.' . $page)) {
            return view('admin.' . $page);
        }
        abort(404);
    })->name('page');
});

// Fallback route for non-existent pages/routes
Route::fallback(function () {
    if (view()->exists('template.error-404')) {
        return response()->view('template.error-404', [], 404);
    }
    abort(404);
});
