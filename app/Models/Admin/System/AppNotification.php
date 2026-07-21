<?php

namespace App\Models\Admin\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    use HasFactory;

    protected $table = 'app_notifications';

    protected $fillable = [
        'category',
        'title',
        'message',
        'url',
        'icon',
        'icon_bg',
        'target_role',
        'user_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * User targeted by notification if specific.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope notifications visible to a specific user.
     */
    public function scopeForUser($query, ?User $user)
    {
        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function ($q) use ($user) {
            // Targeted directly to user
            $q->where('user_id', $user->id);

            // Targeted by role (e.g. 'admin') if user has that role
            if ($user->hasRole('admin')) {
                $q->orWhere('target_role', 'admin');
            }

            // General notification (no specific user and no role restriction)
            $q->orWhere(function ($gq) {
                $gq->whereNull('user_id')
                   ->whereNull('target_role');
            });
        });
    }

    /**
     * Scope unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
