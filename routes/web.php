<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home / Landing Page
Route::get('/', function () {
    return view('admin.landing');
})->name('home');

// Breeze Auth Routes (login, register, forgot-password, logout, etc.)
require __DIR__.'/auth.php';

// Dashboard Page (Admin Dashboard)
Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

// Protected Admin Pages
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::patch('menus/{menu}/toggle-status', [\App\Http\Controllers\Admin\MenuController::class, 'toggleStatus'])->name('menus.toggle-status');
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
        Route::post('users/bulk-assign-role', [\App\Http\Controllers\Admin\UserController::class, 'bulkAssignRole'])->name('users.bulk-assign-role');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

        Route::get('backups/{filename}/download', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backups.download');
        Route::delete('backups/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backups.destroy');
        Route::resource('backups', \App\Http\Controllers\Admin\BackupController::class)->only(['index', 'store']);
    });

    Route::get('/{page}', function ($page) {
        if ($page === 'landing') {
            return redirect()->route('home');
        }
        if ($page === 'index' || $page === 'dashboard-projects') {
            return view('admin.index');
        }
        if (view()->exists('admin.' . $page)) {
            return view('admin.' . $page);
        }
        abort(404);
    })->name('page');
});

// Fallback route for non-existent pages/routes
Route::fallback(function () {
    return response()->view('admin.error-404', [], 404);
});
