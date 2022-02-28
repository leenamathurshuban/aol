<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Vendor;
use Auth;
class VendorLoginController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 10;
    }

    public function index($value='')
    {
    	//print_r(Auth::guard('vendor')->user());
    }

    public function login($value='')
    {
    	if(isset(Auth::guard('vendor')->user()->id) && Auth::guard('vendor')->user()->id){
    		return redirect()->route('vendor.home');
    	}
    	return view('vendor.auth.login');
    }

    public function checkLogin(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(Auth::guard('vendor')->attempt(array('email' => $request->email, 'password' => $request->password)))
        {
            return redirect()->route('vendor.home');
            
        }else{
            return redirect()->route('vendor.login')
                ->with('failed','Email address and password are wrong.');
        }
    }

    public function logout () {
	    //logout user
	    Auth::guard('vendor')->logout();
	    // redirect to homepage
	    return redirect()->route('vendor.login');
	}
}
