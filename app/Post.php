<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function girls() {
        return $this->belongsToMany(Girl::class);
    }
}
