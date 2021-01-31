<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'url_group',
        'number_posts',
        'title',
        'vk_token'
    ];

    public function groups()
    {
        return $this->belongsTo(Group::class);
    }
}
