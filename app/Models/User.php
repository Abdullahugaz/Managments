<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'email',
        'phone',
        // add 'password' here if you want auth
    ];

    // Hide attributes when serialized (optional)
    protected $hidden = [
        // 'password',
        // 'remember_token',
    ];
}
