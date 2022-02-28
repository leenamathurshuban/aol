<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    function __construct($foo = null)
    {
    	$this->foo = $foo;
    }
    public function index($value='')
    {
    	$num=Setting::count();
    	$socialArray=Setting::socialArray();
    	$downloadArray=Setting::downloadArray();
    	if ($num) {
    		$data=Setting::first();

    		return view('admin.setting.edit',compact('data','socialArray','downloadArray'));
    	}else{

    		return view('admin.setting.add',compact('socialArray','downloadArray'));
    	}
    }
    public function settingSave(Request $request)
    {
        $path='setting/';
    	$num=Setting::count();
    	if ($num) {
    		$data=Setting::first();

            $preDarkLogo=$data->dark_logo;
            $preLightLogo=$data->light_logo;
            $prefavicon=$data->favicon_icon;

            $existsDarkLogo=public_path($data->dark_logo);
            $existsLightLogo=public_path($data->light_logo);
            $existsfavicon=public_path($data->favicon_icon);

    		$request->validate(['title'=>'required','email'=>'required|email','mobile_number'=>'required','phone_number'=>'required','address'=>'required','city'=>'required','pin_code'=>'required','country'=>'required','dark_logo'=>'mimes:jpeg,png,jpg,gif,svg|max:2048','light_logo'=>'mimes:jpeg,png,jpg,gif,svg|max:2048','favicon_icon'=>'mimes:jpeg,png,jpg,gif,svg|max:2048']);
    		$data->title=$request->title;
    		$data->email=$request->email;
    		$data->mobile=$request->mobile_number;
    		$data->phone=$request->phone_number;
    		$data->address=$request->address;
    		$data->city=$request->city;
    		$data->pin_code=$request->pin_code;
    		$data->country=$request->country;

            $darkTime=time();
            if ($request->dark_logo) {
                $darkLogoName=$darkTime.'.'.$request->dark_logo->extension();
                $data->dark_logo=$path.$darkLogoName;

            }
            $lightTime=time().rand(1000,9999);
            if ($request->light_logo) {
                $lightLogoName=$lightTime.'.'.$request->light_logo->extension();
                $data->light_logo=$path.$lightLogoName;
            }
            $faviconTime=time().rand(1000,9999);
            if ($request->favicon_icon) {
                $faviconIconName=$faviconTime.'.'.$request->favicon_icon->extension();
                $data->favicon_icon=$path.$faviconIconName;
            }

    		$data->social_link=json_encode($request->social);
    		$data->download_link=json_encode($request->download);
    		
            

    		if ($data->save()) {
                if ($request->dark_logo) {
                    if(file_exists($existsDarkLogo) && $preDarkLogo){
                        unlink($existsDarkLogo);
                    }

                     $request->dark_logo->move(public_path($path),$darkLogoName);

                }
                if ($request->light_logo) {

                    if(file_exists($existsLightLogo) && $preLightLogo){
                        unlink($existsLightLogo);
                    }

                    $request->light_logo->move(public_path($path),$lightLogoName);
                }
                if ($request->favicon_icon) {

                    if(file_exists($existsfavicon) && $prefavicon){
                        unlink($existsfavicon);
                    }
                    $request->favicon_icon->move(public_path($path),$faviconIconName);
                }

    			return redirect()->route('admin.setting')->with('success','Setting updated Successfully');
    		}else{
    			return redirect()->route('admin.setting')->with('failed','Failed ! try again.');
    		}

    	}else{
    		$request->validate(['title'=>'required','email'=>'required|email','mobile_number'=>'required','phone_number'=>'required','address'=>'required','city'=>'required','pin_code'=>'required','country'=>'required','dark_logo'=>'mimes:jpeg,png,jpg,gif,svg|max:2048','light_logo'=>'mimes:jpeg,png,jpg,gif,svg|max:2048','favicon_icon'=>'mimes:jpeg,png,jpg,gif,svg|max:2048']);
    		$data= new Setting;
    		$data->title=$request->title;
    		$data->email=$request->email;
    		$data->mobile=$request->mobile_number;
    		$data->phone=$request->phone_number;
    		$data->address=$request->address;
    		$data->city=$request->city;
    		$data->pin_code=$request->pin_code;
    		$data->country=$request->country;

    		$darkTime=time();
            if ($request->dark_logo) {
                $darkLogoName=$darkTime.'.'.$request->dark_logo->extension();
                $data->dark_logo=$path.$darkLogoName;

            }
            $lightTime=time().rand(1000,9999);
            if ($request->light_logo) {
                $lightLogoName=$lightTime.'.'.$request->light_logo->extension();
                $data->light_logo=$path.$lightLogoName;
            }
            $faviconTime=time().rand(1000,9999);
            if ($request->favicon_icon) {
                $faviconIconName=$faviconTime.'.'.$request->favicon_icon->extension();
                $data->favicon_icon=$path.$faviconIconName;
            }


    		$data->social_link=json_encode($request->social);
    		$data->download_link=json_encode($request->download);
    		
    		if ($data->save()) {

                if ($request->dark_logo) {
                
                     $request->dark_logo->move(public_path($path),$darkLogoName);

                }
                if ($request->light_logo) {

                    $request->light_logo->move(public_path($path),$lightLogoName);
                }
                if ($request->favicon_icon) {

                    $request->favicon_icon->move(public_path($path),$faviconIconName);
                }
    			return redirect()->route('admin.setting')->with('success','Setting changed Successfully');
    		}else{
    			return redirect()->route('admin.setting')->with('failed','Failed ! try again.');
    		}
    	}
    }
}
