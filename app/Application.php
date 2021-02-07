<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'client_id',
        'client_secret',
        'redirect_uri',
        'browser_url',
    ];
}
