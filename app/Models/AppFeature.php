<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'category',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Cache feature flags per request to avoid repeated DB queries.
     */
    protected static array $featureCache = [];

    /**
     * Check if a feature is enabled.
     */
    public static function isEnabled(string $key, bool $default = true): bool
    {
        if (array_key_exists($key, static::$featureCache)) {
            return static::$featureCache[$key];
        }

        try {
            $feature = static::where('key', $key)->first();
            $enabled = $feature ? (bool) $feature->is_active : $default;
        } catch (\Throwable $e) {
            $enabled = $default;
        }

        static::$featureCache[$key] = $enabled;
        return $enabled;
    }

    /**
     * Clear runtime feature cache.
     */
    public static function clearCache(): void
    {
        static::$featureCache = [];
    }
}
