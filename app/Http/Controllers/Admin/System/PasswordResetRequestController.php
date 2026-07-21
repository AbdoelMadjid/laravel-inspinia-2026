<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\PasswordResetRequest;
use App\Models\Admin\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PasswordResetRequestController extends Controller
{
    /**
     * Display a listing of password reset requests.
     */
    public function index(Request $request): View
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = PasswordResetRequest::with(['user', 'processor'])
            ->latest();

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username_or_email', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        return view('admin.system.password-reset-requests.password-reset-requests', compact('requests', 'status', 'search'));
    }

    /**
     * Approve and reset the user's password to a default password.
     */
    public function resetPassword(Request $request, PasswordResetRequest $passwordResetRequest): RedirectResponse
    {
        $defaultPassword = $request->input('default_password', 'password123');

        // Target user can be from relation or searched by email/name
        $user = $passwordResetRequest->user;
        if (!$user) {
            $user = User::where('email', $passwordResetRequest->username_or_email)
                ->orWhere('name', $passwordResetRequest->username_or_email)
                ->first();
        }

        if (!$user) {
            return back()->with('error', "Pengguna dengan email/username '{$passwordResetRequest->username_or_email}' tidak ditemukan di sistem.");
        }

        // Reset user password
        $user->update([
            'password' => Hash::make($defaultPassword),
        ]);

        // Update request status
        $passwordResetRequest->update([
            'user_id' => $user->id,
            'status' => 'approved',
            'notes' => "Password di-reset ke: {$defaultPassword}",
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return back()->with('status', "Password untuk akun {$user->name} ({$user->email}) berhasil di-reset menjadi: {$defaultPassword}");
    }

    /**
     * Reject the password reset request.
     */
    public function reject(Request $request, PasswordResetRequest $passwordResetRequest): RedirectResponse
    {
        $passwordResetRequest->update([
            'status' => 'rejected',
            'notes' => $request->input('notes', 'Permintaan ditolak oleh Admin.'),
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return back()->with('status', 'Permintaan reset password berhasil ditolak.');
    }

    /**
     * Remove the specified password reset request from storage.
     */
    public function destroy(PasswordResetRequest $passwordResetRequest): RedirectResponse
    {
        $passwordResetRequest->delete();

        return back()->with('status', 'Riwayat permintaan reset password berhasil dihapus.');
    }
}
