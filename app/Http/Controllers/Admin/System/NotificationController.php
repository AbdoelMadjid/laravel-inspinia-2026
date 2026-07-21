<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\AppNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark a single notification as read and redirect to target URL.
     */
    public function markAsRead(AppNotification $notification): RedirectResponse
    {
        $user = Auth::user();

        // Security check: ensure notification is visible to user
        if ($notification->user_id && $notification->user_id !== $user->id) {
            abort(403);
        }

        if ($notification->target_role && $notification->target_role === 'admin' && !$user->hasRole('admin')) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        if ($notification->url) {
            return redirect($notification->url);
        }

        return back()->with('status', 'Notifikasi telah ditandai dibaca.');
    }

    /**
     * Mark all unread notifications for current user as read.
     */
    public function markAllAsRead(): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            AppNotification::forUser($user)
                ->unread()
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        }

        return back()->with('status', 'Semua notifikasi telah ditandai dibaca.');
    }

    /**
     * Delete/dismiss a notification.
     */
    public function destroy(AppNotification $notification): RedirectResponse
    {
        $user = Auth::user();

        if ($notification->user_id && $notification->user_id !== $user->id) {
            abort(403);
        }

        $notification->delete();

        return back()->with('status', 'Notifikasi berhasil dihapus.');
    }
}
