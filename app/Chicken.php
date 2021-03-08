<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chicken extends Model
{
    public function notes()
    {
        return $this->belongsToMany(Note::class);
    }
}
