<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\PasswordResetRequest;
use App\Models\Admin\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username_or_email' => ['required', 'string', 'max:255'],
        ], [
            'username_or_email.required' => 'Silakan masukkan Email atau Username Anda.',
        ]);

        $input = trim($request->username_or_email);

        // Find user by email or name
        $user = User::where('email', $input)
            ->orWhere('name', $input)
            ->first();

        // Create reset request record
        PasswordResetRequest::create([
            'user_id' => $user?->id,
            'username_or_email' => $input,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'pending',
        ]);

        return back()->with('status', 'Permintaan reset password Anda telah berhasil dikirimkan ke Admin. Silakan hubungi Administrator untuk mendapatkan kata sandi baru Anda.');
    }
}
