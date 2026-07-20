<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
})->name('home');

Route::get('/{page}', function ($page) {
    if (view()->exists('admin.' . $page)) {
        return view('admin.' . $page);
    }
    abort(404);
})->name('page');
