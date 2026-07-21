<?php

namespace App\Models\Admin\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetRequest extends Model
{
    use HasFactory;

    protected $table = 'password_reset_requests';

    protected $fillable = [
        'user_id',
        'username_or_email',
        'ip_address',
        'user_agent',
        'status',
        'notes',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    /**
     * User requesting password reset.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Admin processor who approved/rejected the request.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
