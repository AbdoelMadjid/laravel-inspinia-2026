<?php

namespace App\Models\Admin\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AppProfile extends Model
{
    use HasFactory;

    protected $table = 'app_profiles';

    protected $fillable = [
        'app_name',
        'app_description',
        'app_year',
        'developer_name',
        'developer_url',
        'logo_light',
        'logo_dark',
        'logo_sm',
        'favicon',
    ];

    /**
     * Cache single instance in memory per request.
     */
    protected static ?AppProfile $cachedInstance = null;

    /**
     * Get active application profile record or create initial default.
     */
    public static function get(): self
    {
        if (static::$cachedInstance === null) {
            static::$cachedInstance = static::firstOrCreate([], [
                'app_name' => 'INSPINIA Laravel 2026',
                'app_description' => 'INSPINIA Responsive Bootstrap 5 Admin & Web Application Template',
                'app_year' => '2026',
                'developer_name' => 'Abdoel Madjid / RPL Team',
                'developer_url' => 'https://github.com/AbdoelMadjid',
            ]);
        }

        return static::$cachedInstance;
    }

    /**
     * Clear runtime cache instance.
     */
    public static function clearCache(): void
    {
        static::$cachedInstance = null;
    }

    /**
     * Logo Light URL Accessor (Fallback: assets/images/logo.png).
     */
    public function getLogoLightUrlAttribute(): string
    {
        if ($this->logo_light && Storage::disk('public')->exists($this->logo_light)) {
            return Storage::url($this->logo_light);
        }
        return asset('assets/images/logo.png');
    }

    /**
     * Logo Dark URL Accessor (Fallback: assets/images/logo-black.png).
     */
    public function getLogoDarkUrlAttribute(): string
    {
        if ($this->logo_dark && Storage::disk('public')->exists($this->logo_dark)) {
            return Storage::url($this->logo_dark);
        }
        return asset('assets/images/logo-black.png');
    }

    /**
     * Logo Small URL Accessor (Fallback: assets/images/logo-sm.png).
     */
    public function getLogoSmUrlAttribute(): string
    {
        if ($this->logo_sm && Storage::disk('public')->exists($this->logo_sm)) {
            return Storage::url($this->logo_sm);
        }
        return asset('assets/images/logo-sm.png');
    }

    /**
     * Favicon URL Accessor (Fallback: assets/images/favicon.ico).
     */
    public function getFaviconUrlAttribute(): string
    {
        if ($this->favicon && Storage::disk('public')->exists($this->favicon)) {
            return Storage::url($this->favicon);
        }
        return asset('assets/images/favicon.ico');
    }
}
