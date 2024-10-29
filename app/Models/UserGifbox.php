<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGifbox extends Model
{
    protected $fillable = [
        'user_id',
        'gifbox_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gifbox()
    {
        return $this->belongsTo(Gifbox::class);
    }
}
