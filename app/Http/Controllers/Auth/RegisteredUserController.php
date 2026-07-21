<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ],
        ], [
            'name.required' => 'Silakan masukkan nama lengkap Anda.',
            'email.required' => 'Silakan masukkan alamat email Anda.',
            'email.email' => 'Format email tidak valid (contoh: user@example.com).',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.',
            'password.required' => 'Silakan buat kata sandi Anda.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi yang dimasukkan.',
            'password' => 'Kata sandi harus terdiri dari minimal 8 karakter dan mengandung setidaknya 1 huruf besar, 1 huruf kecil, dan 1 angka.',
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'email' => trim(strtolower($request->email)),
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        // Assign default 'user' role
        $role = Role::firstOrCreate(['name' => 'user']);
        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
