<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les champs qu’on peut remplir (mass assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_global_admin',
        'banned_at',
        'reputation',
    ];

    /**
     * Champs cachés quand on retourne l’utilisateur en JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts (types)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'banned_at' => 'datetime',
        'is_global_admin' => 'boolean',
    ];

    /**
     * ✅ Helpers simples (pour ton code)
     */
    public function isGlobalAdmin(): bool
    {
        return $this->is_global_admin;
    }

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }
}