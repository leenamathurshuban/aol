<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    
class City extends Model
{
    use SoftDeletes;
    public function state($value='')
    {
    	return $this->hasOne('\App\State','id','state_id')->select('id','name','image','slug');
    }
}
