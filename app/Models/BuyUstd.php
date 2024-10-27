<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyUstd extends Model
{
    protected $fillable = [
        'user_id',
        'price_buy',
        'total_buy',
        'remaining_buy',
        'min_limit_buy',
        'max_limit_buy',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
