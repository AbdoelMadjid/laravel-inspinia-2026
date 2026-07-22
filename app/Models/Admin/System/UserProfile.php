<?php

namespace App\Models\Admin\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected static function newFactory()
    {
        return \Database\Factories\UserProfileFactory::new();
    }

    protected $fillable = [
        'user_id',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'marital_status',
        'address',
        'rt',
        'rw',
        'village',
        'district',
        'city_regency',
        'province',
        'postal_code',
        'motto',
        'cover_image',
        'job_title',
        'education',
        'location',
        'phone',
        'website',
        'languages',
        'about_me',
        'skills',
        'social_links',
        'extra_data',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'languages' => 'array',
        'skills' => 'array',
        'social_links' => 'array',
        'extra_data' => 'array',
    ];

    /**
     * Get user associated with this profile identity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor for cover image URL with fallback.
     */
    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
                return $this->cover_image;
            }
            if (Storage::disk('public')->exists($this->cover_image)) {
                return Storage::url($this->cover_image);
            }
            if (file_exists(public_path($this->cover_image))) {
                return asset($this->cover_image);
            }
        }

        return asset('assets/images/profile-bg.jpg');
    }

    /**
     * Helper accessor for languages display array.
     */
    public function getLanguagesListAttribute(): array
    {
        if (is_array($this->languages)) {
            return $this->languages;
        }
        if (is_string($this->languages) && !empty($this->languages)) {
            return array_map('trim', explode(',', $this->languages));
        }
        return [];
    }

    /**
     * Helper accessor for skills display array.
     */
    public function getSkillsListAttribute(): array
    {
        if (is_array($this->skills)) {
            return $this->skills;
        }
        if (is_string($this->skills) && !empty($this->skills)) {
            return array_map('trim', explode(',', $this->skills));
        }
        return [];
    }

    /**
     * Helper accessor for full formatted address from KTP components.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = [];
        if ($this->address) {
            $parts[] = $this->address;
        }
        if ($this->rt || $this->rw) {
            $rtRw = [];
            if ($this->rt) $rtRw[] = 'RT ' . $this->rt;
            if ($this->rw) $rtRw[] = 'RW ' . $this->rw;
            $parts[] = implode('/', $rtRw);
        }
        if ($this->village) {
            $parts[] = 'Kel. ' . $this->village;
        }
        if ($this->district) {
            $parts[] = 'Kec. ' . $this->district;
        }
        if ($this->city_regency) {
            $parts[] = $this->city_regency;
        }
        if ($this->province) {
            $parts[] = $this->province;
        }
        if ($this->postal_code) {
            $parts[] = $this->postal_code;
        }

        return !empty($parts) ? implode(', ', $parts) : ($this->location ?? '');
    }
}
