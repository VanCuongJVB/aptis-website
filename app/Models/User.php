<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'access_starts_at', 'access_ends_at', 'is_active', 'is_admin',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'access_starts_at'  => 'datetime',
        'access_ends_at'    => 'datetime',
        'is_active'         => 'boolean',
        'is_admin'          => 'boolean',
    ];
}
