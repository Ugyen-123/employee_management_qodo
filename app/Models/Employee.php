<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $guard = 'employees';

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'password',
        'position',        // Add this
        'salary',          // Add this
        'profile_photo',   // Add this (since you use it in profileUpdate)
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'salary' => 'decimal:2',
    ];
}