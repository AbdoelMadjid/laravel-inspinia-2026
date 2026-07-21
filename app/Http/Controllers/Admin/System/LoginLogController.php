<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\LoginLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class LoginLogController extends Controller
{
    /**
     * Display a listing of login logs.
     */
    public function index(Request $request): View
    {
        $query = LoginLog::with(['user.roles'])->latest('login_at');

        // Default date filter to today if no date or search param is passed,
        // but if user explicitly passes empty date (date=''), show all dates.
        if ($request->has('date')) {
            if ($request->filled('date')) {
                $query->whereDate('login_at', $request->input('date'));
            }
        } else {
            // Default on initial page load: filter to today
            $query->whereDate('login_at', now()->toDateString());
            $request->merge(['date' => now()->toDateString()]);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                    ->orWhere('user_agent', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('role')) {
            $role = $request->input('role');
            $query->whereHas('user.roles', function ($rq) use ($role) {
                $rq->where('name', $role);
            });
        }

        if ($request->filled('points')) {
            if ($request->input('points') === '1') {
                $query->where('points_awarded', '>', 0);
            } elseif ($request->input('points') === '0') {
                $query->where('points_awarded', 0);
            }
        }

        $logs = $query->paginate(15)->withQueryString();
        $roles = Role::all();

        $stats = [
            'total_logins' => LoginLog::count(),
            'total_points_awarded' => LoginLog::sum('points_awarded'),
            'logins_today' => LoginLog::whereDate('login_at', now()->toDateString())->count(),
            'unique_users_today' => LoginLog::whereDate('login_at', now()->toDateString())->distinct('user_id')->count('user_id'),
        ];

        return view('admin.system.login-log.login-log', compact('logs', 'stats', 'roles'));
    }
}
