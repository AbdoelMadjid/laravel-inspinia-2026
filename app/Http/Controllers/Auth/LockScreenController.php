<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LockScreenController extends Controller
{
    /**
     * Show the lock screen view.
     */
    public function show(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Lock session when showing lock screen
        session(['account_locked' => true]);

        return view('auth.lock-screen');
    }

    /**
     * Lock the user session and redirect to lock screen.
     */
    public function lock(Request $request): RedirectResponse
    {
        session(['account_locked' => true]);

        return redirect()->route('lock-screen');
    }

    /**
     * Unlock the screen using user password.
     */
    public function unlock(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Silakan masukkan kata sandi Anda.',
        ]);

        $user = Auth::user();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Kata sandi yang Anda masukkan salah.',
            ]);
        }

        // Remove lock state from session
        session()->forget('account_locked');

        return redirect()->intended(route('dashboard'))->with('status', 'Layar berhasil dibuka.');
    }
}
