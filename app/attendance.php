<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    protected $fillable = [
    	'id','events_id','login','logout',
    ];
}
