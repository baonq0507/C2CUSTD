<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gifbox extends Model
{
    //
    protected $fillable = [
        'name',
        'amount'
    ];

    public function userGifboxes()
    {
        return $this->hasMany(UserGifbox::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_gifboxes');
    }

}
