<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
class AdminLoginController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 10;
    }

    public function index($value='')
    {
    	# code...
    }

    public function login($value='')
    {
    	if(isset(Auth()->user()->id) && Auth()->user()->id){
    		return redirect()->route('admin.home');
    	}
    	return view('admin.auth.login');
    }

    public function checkLogin(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(auth()->attempt(array('email' => $request->email, 'password' => $request->password)))
        {
            return redirect()->route('admin.home');
            
        }else{
            return redirect()->route('admin.login')
                ->with('failed','Email address and password are wrong.');
        }
    }

    public function logout () {
	    //logout user
	    auth()->logout();
	    // redirect to homepage
	    	return redirect()->route('admin.login');
	}
}
