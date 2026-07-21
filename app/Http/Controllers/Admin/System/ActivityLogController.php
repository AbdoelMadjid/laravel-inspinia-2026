<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\System\ActivityLog;
use App\Models\Admin\System\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display system & admin activity audit logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Search Keyword
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Action Filter
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // User Filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();
        $actions = ActivityLog::distinct()->pluck('action')->filter()->values();

        return view('admin.system.activity-log.activity-log', compact('logs', 'users', 'actions'));
    }
}
