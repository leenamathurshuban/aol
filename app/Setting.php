<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    public static function socialArray($value='')
    {
    	return ['Youtube','Twitter','Facebook','Instagram'];
    }
     public static function downloadArray($value='')
    {
    	return ['Website','Android','IOS'];
    }
    public static function setting($value='')
    {
    	if ($value) {
    		return Setting::orderBy('id','desc')->first()->$value;
    	}else{
    		return Setting::orderBy('id','desc')->first();
    	}
    	
    }
}
