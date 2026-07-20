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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::patch('menus/{menu}/toggle-status', [\App\Http\Controllers\Admin\MenuController::class, 'toggleStatus'])->name('menus.toggle-status');
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
    });

    Route::get('/{page}', function ($page) {
        if ($page === 'landing') {
            return redirect()->route('home');
        }
        if ($page === 'index') {
            return redirect()->route('dashboard');
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
