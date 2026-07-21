<?php

namespace App\Models\Admin\System;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password', 'avatar', 'points', 'is_approved', 'last_seen_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'users';
    protected string $guard_name = 'web';

    public function getMorphClass()
    {
        return 'App\Models\User';
    }

    /**
     * Check if user is currently online (active within last 5 minutes).
     */
    public function isOnline(): bool
    {
        return $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(5));
    }

    /**
     * Humanized text for last seen status.
     */
    public function getLastSeenTextAttribute(): string
    {
        if ($this->isOnline()) {
            return 'Online sekarang';
        }
        if ($this->last_seen_at) {
            return 'Aktif ' . $this->last_seen_at->diffForHumans();
        }
        return 'Belum pernah aktif';
    }

    /**
     * Get login logs for user.
     */
    public function loginLogs(): HasMany
    {
        return $this->hasMany(LoginLog::class, 'user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'points' => 'integer',
            'is_approved' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Get the avatar URL or fallback default image.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }
            if (Storage::disk('public')->exists($this->avatar)) {
                return Storage::url($this->avatar);
            }
            if (file_exists(public_path($this->avatar))) {
                return asset($this->avatar);
            }
        }

        return asset('assets/images/users/avatar-neutral.svg');
    }
}
