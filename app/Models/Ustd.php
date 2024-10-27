<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ustd extends Model
{
    protected $fillable = [
        'user_id',
        'usdt_buy_amount',
        'usdt_sell_amount',
        'usdt_total_amount',
        'usdt_available_amount',
        'usdt_min_limit',
        'usdt_max_limit',
        'usdt_profit',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
