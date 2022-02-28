<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;
class Vendor extends Authenticatable
{
    use Notifiable;
    protected $table = 'vendors'; 
    protected $guard = 'vendor';

    protected $fillable=['name', 'email', 'password','original_password', 'mobile_code', 'mobile', 'phone', 'status', 'image', 'bank_account_type', 'bank_account_number', 'ifsc', 'pan', 'specified_person', 'address', 'location', 'zip', 'state_id', 'state_ary', 'city_id', 'city_ary', 'user_id', 'user_ary', 'constitution', 'specify_if_other','gst','vendor_code'];

    //protected $hidden=['password'];

    public static function Constitution($value='')
    {
    	$data=['Sole Propritor'=>'Sole Propritor','Partnership'=>'Partnership','Company'=>'Company','Trust'=>'Trust','AOP'=>'AOP','Others'=>'Others'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public function state($value='')
    {
    	return $this->hasOne('\App\State','id','state_id')->select('id','name');
    }

    public function city($value='')
    {
    	return $this->hasOne('\App\City','id','city_id')->select('id','name');
    }

    public static function status($value='')
    {
        $data=['1'=>'Active','2'=>'Inactive'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function accountStatus($value='')
    {
        $data=['1' => 'Pending', '2' => 'Rejected', '3' => 'Approved'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function requestType($value='')
    {
        $data=['1'=>'Request by employee','2'=>'Request by vendor form'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function approvedVendor($value='')
    {
        if ($value) {
            return Vendor::where(['id' => $value,'account_status'=>'3','status'=>'1'])->first();
        }else{
             return Vendor::where(['account_status'=>'3','status'=>'1'])->pluck('name','id');
             //Vendor::select(DB::raw('CONCAT(name, " ", vendor_code) AS name, id'))->where(['account_status'=>'3','status'=>'1'])->pluck('name','id');
        }
    }

    public static function vendorAry($value='')
    {
        return Vendor::where('id',$value)->select('id','name','email','phone','vendor_code','bank_account_number', 'ifsc', 'pan', 'specified_person', 'address', 'location', 'zip')->first();
    }

    public static function approvedPoVendor($value='')
    {
        if ($value) {
            return Vendor::where(['id' => $value,'account_status'=>'3','status'=>'1'])->first();
        }else{
             return Vendor::where(['account_status'=>'3','status'=>'1'])->pluck('name','vendor_code');
             //Vendor::select(DB::raw('CONCAT(name, " ", vendor_code) AS name, id'))->where(['account_status'=>'3','status'=>'1'])->pluck('name','id');
        }
    }

    
}