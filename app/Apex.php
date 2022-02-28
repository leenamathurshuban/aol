<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apex extends Model
{
    public static function apxWidIdPluck($value='')
    {
    	return Apex::orderBy('id','asc')->pluck('name','id');
    }
}
