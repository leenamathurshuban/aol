<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


 use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    
    use Notifiable;

     public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin','original_password','image','address','gst_number','pin_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function loginType($value='')
    {
        $data=['1'=>'Email','2'=>'Twitter','3'=>'Facebook'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }


    /*public static function loginType($value='')
    {
        $data=['1'=>'Admin','2'=>'Company'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }*/

    public static function mobileVerificationStatus($value='')
    {
        $data=['0'=>'Unverified','1'=>'Verified'];
        if ($value) {
            return $data[$value];
        }else{
            return $data;
        }
    }

    public static function send_sms($message, $to_number) {
        
        //Your authentication key
        $authKey = "6578Aj5tCgdEwD15ec38059P5";
        //Multiple mobiles numbers separated by comma
        $mobileNumber = $to_number;
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "DEVGRO";
        //Your message to send, Add URL encoding here.
        $message = urlencode($message);
        //Define route 
        $route = 4;
        //Prepare you post parameters
        $postData = array(
            'authkey' => $authKey,
            'mobiles' => $mobileNumber,
            'message' => $message,
            'sender' => $senderId,
            'route' => $route
        );
        //API URL
        $url="http://prosms.easy2approach.com/api/sendhttp.php";

        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //get response
        $output = curl_exec($ch);
        //print_r($output);
        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }

}
