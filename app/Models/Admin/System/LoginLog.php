<?php

namespace App\Models\Admin\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginLog extends Model
{
    use HasFactory;

    protected $table = 'login_logs';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'points_awarded',
        'login_at',
    ];

    protected function casts(): array
    {
        return [
            'login_at' => 'datetime',
            'points_awarded' => 'integer',
        ];
    }

    /**
     * Get user associated with the login log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
