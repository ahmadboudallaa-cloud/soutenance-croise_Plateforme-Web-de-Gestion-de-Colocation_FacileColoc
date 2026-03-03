<?php


namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_global_admin',
        'banned_at',
        'reputation',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
     protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_global_admin' => 'boolean',
        'banned_at' => 'datetime',
        'reputation' => 'integer',
    ];

     public function isBanned(): bool
    {
        return !is_null($this->banned_at);
    }


        public function memberships()
{
    return $this->hasMany(Membership::class);
}


    public function isGlobalAdmin(): bool
    {
        return  $this->is_global_admin;
    }

public function colocations()
{
    return $this->belongsToMany(Colocation::class)
    ->withPivot(['role','left_at'])
    ->withTimestamps();   // âš ï¸ ICI
}
public function expensesPaid()
{
    return $this->hasMany(Expense::class, 'paid_by');
}
}

