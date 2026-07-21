<?php

namespace App\View\Composers;

use App\Models\Admin\System\AppNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TopbarComposer
{
    /**
     * Bind notification data to the view.
     */
    public function compose(View $view): void
    {
        $user = Auth::user();

        if ($user) {
            $unreadNotifications = AppNotification::forUser($user)
                ->unread()
                ->latest()
                ->take(15)
                ->get();

            $unreadCount = AppNotification::forUser($user)
                ->unread()
                ->count();
        } else {
            $unreadNotifications = collect();
            $unreadCount = 0;
        }

        $view->with('topbarNotifications', $unreadNotifications);
        $view->with('topbarUnreadCount', $unreadCount);
    }
}
