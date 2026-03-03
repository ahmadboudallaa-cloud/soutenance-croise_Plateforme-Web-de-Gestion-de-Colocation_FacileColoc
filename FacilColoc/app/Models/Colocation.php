<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Colocation extends Model
{
    protected $fillable = [
    'name',
    'description',
    'status',
    'invitation_token'
];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function users()
{
   return $this->belongsToMany(User::class)
    ->withPivot(['role','left_at'])
    ->withTimestamps();   // âš ï¸ ICI
}
    public function expenses()
{
    return $this->hasMany(Expense::class);
}
protected static function booted()
{
    static::creating(function ($colocation) {
        $colocation->invitation_token = Str::uuid();
    });
}
public function payments()
{
    return $this->hasMany(Payment::class);
}

public function invitations()
{
    return $this->hasMany(Invitation::class);
}
}

