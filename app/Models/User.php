<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles; 
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'index_number',
    'role',
    'requires_password_change',
    'profile_picture',
    'phone_number',
    'job_title',
    'department',
    'otp_code',              
    'otp_expires_at',
    'must_change_password'

];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
    public function systemRole()
    {
        // Renamed to avoid colliding with the 'role' database column
        return $this->belongsTo(Role::class, 'role', 'name');
    }

    // Custom Permission Checker
    public function hasPermission($permission)
    {
        // 1. Super Admin gets an automatic VIP pass to everything
        if ($this->role === 'super_admin') {
            return true;
        }

        // 2. Check if the user has a custom role with permissions assigned
        if ($this->systemRole && is_array($this->systemRole->permissions)) {
            return in_array($permission, $this->systemRole->permissions);
        }

        return false;
    }
    //confirm if github repository is updating as expected
}
