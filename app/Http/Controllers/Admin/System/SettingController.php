<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\ActivityLog;
use App\Models\Admin\System\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class SettingController extends Controller
{
    /**
     * Display global application settings page.
     */
    public function index()
    {
        $roles = Role::all();

        $settings = [
            'app_name' => Setting::get('app_name', config('app.name', 'Inspinia Laravel')),
            'app_description' => Setting::get('app_description', 'Sistem Informasi Manajemen Enterprise berbasis Laravel 2026'),
            'app_logo' => Setting::get('app_logo', 'assets/images/logo-dark.png'),
            'allow_registration' => Setting::get('allow_registration', true),
            'auto_approve_registration' => Setting::get('auto_approve_registration', false),
            'default_registration_role' => Setting::get('default_registration_role', 'user'),
            'footer_text' => Setting::get('footer_text', '© 2026 Inspinia Laravel - Hak Cipta Dilindungi.'),
        ];

        return view('admin.system.settings.settings', compact('settings', 'roles'));
    }

    /**
     * Update global application settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'app_name' => ['required', 'string', 'max:100'],
            'app_description' => ['nullable', 'string', 'max:255'],
            'allow_registration' => ['nullable', 'boolean'],
            'auto_approve_registration' => ['nullable', 'boolean'],
            'default_registration_role' => ['required', 'string', 'exists:roles,name'],
            'footer_text' => ['nullable', 'string', 'max:255'],
            'app_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ]);

        Setting::set('app_name', $request->app_name, 'general');
        Setting::set('app_description', $request->app_description, 'general');
        Setting::set('allow_registration', $request->boolean('allow_registration'), 'auth');
        Setting::set('auto_approve_registration', $request->boolean('auto_approve_registration'), 'auth');
        Setting::set('default_registration_role', $request->default_registration_role, 'auth');
        Setting::set('footer_text', $request->footer_text, 'general');

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::set('app_logo', 'storage/' . $path, 'general');
        }

        ActivityLog::log('UPDATE_SETTINGS', 'Mengubah Pengaturan Global Sistem Aplikasi.');

        return redirect()->back()->with('success', 'Pengaturan aplikasi berhasil diperbarui!');
    }
}
