<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    /**
     * Get the loans handled by this staff member.
     */
    public function loans() {
        return $this->hasMany(Loan::class, 'staff_id');
    }

    /**
     * Get the usages recorded by this staff member.
     */
    public function usages() {
        return $this->hasMany(Usage::class, 'staff_id');
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin() {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a staff member.
     */
    public function isStaff() {
        return $this->role === 'staff';
    }
}
