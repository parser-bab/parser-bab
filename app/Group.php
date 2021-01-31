<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function girls()
    {
        return $this->belongsToMany(Girl::class);
    }
    public function tasks()
    {
        return $this->hasOne(Task::class);
    }
}
