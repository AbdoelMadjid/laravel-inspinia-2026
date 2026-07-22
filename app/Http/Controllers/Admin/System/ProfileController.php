<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.system.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            if ($user->email !== $request->input('email')) {
                $user->email = $request->input('email');
                $user->email_verified_at = null;
            }
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($user->isDirty()) {
            $user->save();
        }

        // Save UserProfile identity fields
        $profile = $user->getOrCreateProfile();
        $profileData = $request->only([
            'nik', 'birth_place', 'birth_date', 'gender', 'religion', 'marital_status',
            'address', 'rt', 'rw', 'village', 'district', 'city_regency', 'province', 'postal_code',
            'motto', 'job_title', 'education', 'location', 'phone', 'website', 'about_me'
        ]);

        if ($request->has('languages')) {
            $langs = $request->input('languages');
            $profileData['languages'] = is_array($langs) ? $langs : array_filter(array_map('trim', explode(',', $langs)));
        }

        if ($request->has('skills')) {
            $skills = $request->input('skills');
            $profileData['skills'] = is_array($skills) ? $skills : array_filter(array_map('trim', explode(',', $skills)));
        }

        if ($request->has('social_links')) {
            $profileData['social_links'] = $request->input('social_links');
        }

        if ($request->hasFile('cover_image')) {
            if ($profile->cover_image && Storage::disk('public')->exists($profile->cover_image)) {
                Storage::disk('public')->delete($profile->cover_image);
            }
            $profileData['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $profile->update($profileData);

        $formSection = $request->input('form_section');
        $successMessage = match($formSection) {
            'account' => 'Informasi akun berhasil diperbarui!',
            'header' => 'Data tampilan header & motto berhasil diperbarui!',
            'identity' => 'Data identitas KTP & alamat berhasil diperbarui!',
            'professional' => 'Data profil profesional & sosmed berhasil diperbarui!',
            default => 'Profil Anda berhasil diperbarui!',
        };

        return Redirect::route('profile.edit')->with('success', $successMessage);
    }

    /**
     * Quick update for user avatar via AJAX.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = $request->file('avatar')->store('avatars', 'public');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui.',
            'avatar_url' => $user->avatar_url,
        ]);
    }

    /**
     * Quick update for user cover image via AJAX.
     */
    public function updateCover(Request $request)
    {
        $request->validate([
            'cover_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
        ]);

        $user = $request->user();
        $profile = $user->getOrCreateProfile();

        if ($profile->cover_image && Storage::disk('public')->exists($profile->cover_image)) {
            Storage::disk('public')->delete($profile->cover_image);
        }

        $coverPath = $request->file('cover_image')->store('covers', 'public');
        $profile->update(['cover_image' => $coverPath]);

        return response()->json([
            'success' => true,
            'message' => 'Gambar sampul profil berhasil diperbarui.',
            'cover_url' => $profile->cover_image_url,
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
