<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected $fillable = [
    	'id','title','date','venue','logintime','logouttime','loginfines','logoutfines',
    ];
}
