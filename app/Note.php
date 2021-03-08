<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public function chickens()
    {
        return $this->belongsToMany(Chicken::class);
    }
}
