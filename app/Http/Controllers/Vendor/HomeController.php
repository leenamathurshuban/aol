<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Vendor;
use Auth;
class HomeController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 10;
    }

    public function index($value='')
    {
    	return view('vendor.home');
    }

    public function profile()
    {
        $data=Auth::guard('vendor')->user();
    	return view('vendor.profile',compact('data'));
    	
    }
   
    public function profileSave(Request $request)
    {
        $request->validate(['name'=>'required','email'=>'required|email|unique:vendors,email,'.Auth::guard('vendor')->user()->id]);
        $data=Vendor::where(['id'=>Auth::guard('vendor')->user()->id])->first();
        $data->name=$request->name;
        $data->email=$request->email;
        if ($data->save()) {
           return redirect()->route('vendor.profile')->with('success','Profile updated Successfully');
        }else{
            return redirect()->route('vendor.profile')->with('failed','Sorry ! Please try again');
        }
    }

   

    public function passwordSave(Request $request)
    {
       $request->validate(['current_password'=>'required','new_password'=>'required|min:6|different:current_password','confirm_password'=>'required|same:new_password']);
       if (Hash::check($request->current_password, Auth::guard('vendor')->user()->password)) 
       { 
            $user=Vendor::where(['id'=>Auth::guard('vendor')->user()->id])->first();
           $user->fill([
            'password' => Hash::make($request->new_password)
            ])->save();

            return redirect()->route('vendor.profile')->with('success', 'Password changed Successfully');

        } else {

            return redirect()->route('vendor.profile')->with('failed','Sorry ! Old Password does not match');
        }

    }
}
