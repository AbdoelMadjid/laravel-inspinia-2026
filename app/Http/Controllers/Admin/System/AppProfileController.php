<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\ActivityLog;
use App\Models\Admin\System\AppProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AppProfileController extends Controller
{
    /**
     * Display the Apps Profile settings form.
     */
    public function index()
    {
        $profile = AppProfile::get();
        $roles = Role::all();
        return view('admin.system.app-profile.app-profile', compact('profile', 'roles'));
    }

    /**
     * Update the Apps Profile settings, registration policy, and brand logos.
     */
    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string',
            'app_year' => 'required|string|max:20',
            'developer_name' => 'required|string|max:255',
            'developer_url' => 'nullable|url|max:255',
            'allow_registration' => 'nullable|boolean',
            'auto_approve_registration' => 'nullable|boolean',
            'default_registration_role' => 'required|string|exists:roles,name',
            'logo_light' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_sm' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'favicon' => 'nullable|file|mimes:ico,png,jpg,jpeg,svg,webp|max:1024',
        ]);

        $profile = AppProfile::get();

        $data = [
            'app_name' => $request->input('app_name'),
            'app_description' => $request->input('app_description'),
            'app_year' => $request->input('app_year'),
            'developer_name' => $request->input('developer_name'),
            'developer_url' => $request->input('developer_url'),
            'allow_registration' => $request->boolean('allow_registration'),
            'auto_approve_registration' => $request->boolean('auto_approve_registration'),
            'default_registration_role' => $request->input('default_registration_role'),
        ];

        // Handle file uploads for logos & favicon
        $imageFields = ['logo_light', 'logo_dark', 'logo_sm', 'favicon'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($profile->$field && Storage::disk('public')->exists($profile->$field)) {
                    Storage::disk('public')->delete($profile->$field);
                }
                $data[$field] = $request->file($field)->store('app-profile', 'public');
            }
        }

        $profile->update($data);
        AppProfile::clearCache();

        ActivityLog::log('UPDATE_APP_PROFILE', 'Mengubah Profil & Kebijakan Pendaftaran Aplikasi.');

        return redirect()->route('admin.app-profile.index')
            ->with('success', 'Profil Aplikasi & Kebijakan Pendaftaran berhasil diperbarui!');
    }
}
