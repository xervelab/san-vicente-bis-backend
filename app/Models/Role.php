<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Get all permissions for this role
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * Get all users with this role
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Assign permission to role
     */
    public function grantPermission(Permission|string $permission): void
    {
        $permission = $permission instanceof Permission ? $permission : Permission::where('name', $permission)->first();
        
        if ($permission && !$this->permissions()->where('permission_id', $permission->id)->exists()) {
            $this->permissions()->attach($permission);
        }
    }

    /**
     * Remove permission from role
     */
    public function revokePermission(Permission|string $permission): void
    {
        $permission = $permission instanceof Permission ? $permission : Permission::where('name', $permission)->first();
        
        if ($permission) {
            $this->permissions()->detach($permission);
        }
    }
}
