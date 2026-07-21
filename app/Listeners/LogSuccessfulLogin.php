<?php

namespace App\Listeners;

use App\Models\Admin\System\LoginLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Carbon;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        if (!$user) {
            return;
        }

        $today = Carbon::today();

        // Check if user has already logged in today
        $alreadyLoggedToday = LoginLog::where('user_id', $user->id)
            ->whereDate('login_at', $today)
            ->exists();

        $pointsAwarded = 0;

        if (!$alreadyLoggedToday) {
            $user->increment('points', 1);
            $pointsAwarded = 1;
        }

        LoginLog::create([
            'user_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'points_awarded' => $pointsAwarded,
            'login_at' => now(),
        ]);
    }
}
