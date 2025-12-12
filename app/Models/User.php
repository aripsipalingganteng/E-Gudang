<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Check if user has specific role
     */
    public function hasRole($role): bool
    {
        $userRole = $this->role ?? 'user';
        
        if (is_array($role)) {
            return in_array($userRole, $role);
        }
        
        // Handle comma-separated roles
        if (strpos($role, ',') !== false) {
            $roles = array_map('trim', explode(',', $role));
            return in_array($userRole, $roles);
        }
        
        return $userRole === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get user role with default
     */
    public function getRoleAttribute($value)
    {
        return $value ?? 'user';
    }
}