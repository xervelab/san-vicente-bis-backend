<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

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
        ];
    }

    /**
     * User role constants
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';
    const ROLE_APPROVER = 'approver';
    const ROLE_RESIDENT = 'resident';

    /**
     * Demo accounts configuration
     */
    const DEMO_ACCOUNTS = [
        'admin@bisv.ph' => [
            'name' => 'Ricardo Dela Cruz',
            'role' => self::ROLE_ADMIN,
            'roleName' => 'Administrator'
        ],
        'staff@bisv.ph' => [
            'name' => 'Maria Santos',
            'role' => self::ROLE_STAFF,
            'roleName' => 'Barangay Staff'
        ],
        'captain@bisv.ph' => [
            'name' => 'Eduardo Reyes',
            'role' => self::ROLE_APPROVER,
            'roleName' => 'Barangay Captain'
        ],
        'resident@bisv.ph' => [
            'name' => 'Ana Bautista',
            'role' => self::ROLE_RESIDENT,
            'roleName' => 'Resident'
        ],
    ];

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    /**
     * Check if user is staff
     */
    public function isStaff(): bool
    {
        return $this->hasRole(self::ROLE_STAFF);
    }

    /**
     * Check if user is approver
     */
    public function isApprover(): bool
    {
        return $this->hasRole(self::ROLE_APPROVER);
    }

    /**
     * Check if user is resident
     */
    public function isResident(): bool
    {
        return $this->hasRole(self::ROLE_RESIDENT);
    }

    /**
     * Get role display name
     */
    public function getRoleNameAttribute(): string
    {
        return self::DEMO_ACCOUNTS[$this->email]['roleName'] ?? ucfirst($this->role);
    }
}
