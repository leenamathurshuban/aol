<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)

    {   

        $input = $request->all();
       

        $this->validate($request, [

            'email' => 'required',

            'password' => 'required',

        ]);

   

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))

        {
             if ($request->remember) {
                    setcookie ("username",$input['email'],time()+ (6*30*24*3600));
                    setcookie ("password",$input['password'],time()+ (6*30*24*3600));
                    setcookie ("companyRemember",$input['remember'],time()+ (6*30*24*3600));
                }else{
                    setcookie ("username",'',time()+ (6*30*24*3600));
                    setcookie ("password",'',time()+ (6*30*24*3600));
                    setcookie ("companyRemember",'',time()+ (6*30*24*3600));
                }
            if (isset(auth()->user()->is_admin) && (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 2)) {

                return redirect()->route('admin.home');

            }else{

                return redirect()->route('home');

            }

        }else{

            return redirect()->route('login')

                ->with('error','Invalid login detail.');

        }

          

    }
}
