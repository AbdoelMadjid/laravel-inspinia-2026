<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'type',
        'icon',
        'route_name',
        'route_params',
        'url',
        'target',
        'link_class',
        'badge_text',
        'badge_class',
        'permission_name',
        'sort_order',
        'is_active',
        'data_lang',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'route_params' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Parent menu relationship.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Children / Submenus relationship.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Active Children relationship.
     */
    public function activeChildren(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    /**
     * Spatie Roles assigned to this menu.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'menu_role');
    }

    /**
     * Resolve menu URL dynamically.
     */
    public function getResolvedUrlAttribute(): string
    {
        if (!empty($this->route_name)) {
            if (Route::has($this->route_name)) {
                try {
                    return route($this->route_name, $this->route_params ?? []);
                } catch (\Throwable $e) {
                    return '#';
                }
            }
            return '#';
        }

        if (!empty($this->url)) {
            return $this->url;
        }

        return '#';
    }

    /**
     * Check if the menu has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Determine if menu is visible for a given user based on Spatie Roles and Permissions.
     */
    public function isVisibleForUser(?User $user): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$user) {
            return false;
        }

        // Check explicit permission requirement if set
        if (!empty($this->permission_name) && !$user->can($this->permission_name)) {
            return false;
        }

        // Check role requirement if roles are attached to this menu
        if ($this->roles->isNotEmpty()) {
            if (!$user->hasAnyRole($this->roles)) {
                return false;
            }
        }

        // If it's a dropdown container with submenus, check if any child is visible
        if ($this->type === 'item' && $this->activeChildren->isNotEmpty()) {
            $hasVisibleChild = $this->activeChildren->contains(function ($child) use ($user) {
                return $child->isVisibleForUser($user);
            });
            
            // If none of the submenus are visible, hide parent container unless it has its own route
            if (!$hasVisibleChild && (empty($this->route_name) && empty($this->url) || $this->url === '#')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if menu item is active based on current request URL.
     */
    public function isActiveRoute(): bool
    {
        if (!empty($this->route_name)) {
            $pattern = $this->route_name;
            if (str_ends_with($pattern, '.index')) {
                $pattern = substr($pattern, 0, -6) . '.*';
            }

            if (request()->routeIs($this->route_name) || request()->routeIs($pattern)) {
                if (!empty($this->route_params) && is_array($this->route_params)) {
                    foreach ($this->route_params as $key => $val) {
                        if (request()->route($key) != $val && request()->query($key) != $val) {
                            return false;
                        }
                    }
                }
                return true;
            }
        }

        if (!empty($this->url) && $this->url !== '#' && $this->url !== 'javascript:void(0);') {
            return request()->fullUrlIs($this->url) || request()->is(ltrim($this->url, '/'));
        }

        // Check if any children are active
        foreach ($this->activeChildren as $child) {
            if ($child->isActiveRoute()) {
                return true;
            }
        }

        return false;
    }
}
