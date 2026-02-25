<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Colocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'cancelled_at',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'colocation_user')
            ->withPivot(['role', 'joined_at', 'left_at', 'is_active'])
            ->withTimestamps();
    }
}