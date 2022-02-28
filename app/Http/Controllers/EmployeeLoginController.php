<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Employee;
use Auth;
class EmployeeLoginController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 10;
    }

    public function index($value='')
    {
    	//print_r(Auth::guard('employee')->user());
    }

    public function login($value='')
    {
    	if(isset(Auth::guard('employee')->user()->id) && Auth::guard('employee')->user()->id){
    		return redirect()->route('employee.home');
    	}
    	return view('employee.auth.login');
    }

    public function checkLogin(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'term_and_condition'=>'required|in:1'
        ]);
        if(Auth::guard('employee')->attempt(array('email' => $request->email, 'password' => $request->password)))
        {
            return redirect()->route('employee.home');
            
        }else{
            return redirect()->route('employee.login')
                ->with('failed','Email address and password are wrong.');
        }
    }

    public function logout () {
	    //logout user
	    Auth::guard('employee')->logout();
	    // redirect to homepage
	    return redirect()->route('employee.login');
	}
}
