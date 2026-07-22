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

        // Check if this login is triggered by switch account / impersonation
        $isSwitchAccount = session()->get('is_switching_account', false) || session()->has('impersonator_id');

        $today = Carbon::today();

        // Check if user has already earned points today
        $alreadyPointsEarnedToday = LoginLog::where('user_id', $user->id)
            ->whereDate('login_at', $today)
            ->where('points_awarded', '>', 0)
            ->exists();

        $pointsAwarded = 0;

        // Points are only awarded for direct user login, NOT for switch account / impersonation
        if (!$isSwitchAccount && !$alreadyPointsEarnedToday) {
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
