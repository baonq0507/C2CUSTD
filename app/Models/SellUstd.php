<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellUstd extends Model
{
    protected $fillable = [
        'user_id',
        'price',
        'amount',
        'remaining',
        'limit',
        'limit_max',
        'status',
        'transaction_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
