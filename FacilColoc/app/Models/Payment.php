<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'colocation_id',
        'from_user_id',
        'to_user_id',
        'amount',
        'payment_date'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }
}