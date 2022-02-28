<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\User;
use Auth;
use App\Category;
use App\ProductCategory;
use App\Product;

class HomeController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 10;
    }

    public function adminHome()
    {
           return view('admin.adminHome');
       
    }
   
    public function profile()
    {
        $data=Auth::user();
    	return view('admin.profile',compact('data'));
    	
    }
   
    public function profileSave(Request $request)
    {
        $request->validate(['name'=>'required','email'=>'required|email|unique:users,email,'.Auth::user()->id]);
        $data=User::where(['id'=>Auth::user()->id])->first();
        $data->name=$request->name;
        $data->email=$request->email;
        if ($data->save()) {
           return redirect()->route('admin.profile')->with('success','Profile updated Successfully');
        }else{
            return redirect()->route('admin.profile')->with('failed','Sorry ! Please try again');
        }
    }

   

    public function passwordSave(Request $request)
    {
       $request->validate(['current_password'=>'required','new_password'=>'required|min:6|different:current_password','confirm_password'=>'required|same:new_password']);
       if (Hash::check($request->current_password, Auth::user()->password)) 
       { 
            $user=User::where(['id'=>Auth::user()->id])->first();
           $user->fill([
            'password' => Hash::make($request->new_password)
            ])->save();

            return redirect()->route('admin.profile')->with('success', 'Password changed Successfully');

        } else {

            return redirect()->route('admin.profile')->with('failed','Sorry ! Old Password does not match');
        }

    }

}
