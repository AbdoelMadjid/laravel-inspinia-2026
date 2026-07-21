<?php

namespace App\Models\Admin\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    /**
     * Get setting value by key with fallback default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $val = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : null;
        });

        if ($val === null) {
            return $default;
        }

        if ($val === 'true') return true;
        if ($val === 'false') return false;

        return $val;
    }

    /**
     * Set / update setting key value.
     */
    public static function set(string $key, mixed $value, string $group = 'general'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_bool($value) ? ($value ? 'true' : 'false') : (string)$value,
                'group' => $group,
            ]
        );

        Cache::forget("setting_{$key}");

        return $setting;
    }
}
