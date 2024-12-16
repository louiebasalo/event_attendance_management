<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $fillable = [
    	'id','student_id','name','level', 'courses_id' , 'majors_id',
    ];
}
