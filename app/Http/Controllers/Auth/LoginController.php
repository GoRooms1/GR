<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }
   
    protected function authenticated(Request $request, User $user)
    {
        if ($user->personal_hotel) {            
            return Inertia::location(route('lk.start'));
        }

        if ($user->is_admin) {            
            return Inertia::location(route('admin.index'));
        }

        if ($user->is_moderate) {                              
            return redirect(route('hotels.index'));
        }

        return redirect($this->redirectTo);
    }    

    public function username()
    {
        if(request()->get('hotelier', false)) {
            return 'email';
        }            

        return 'phone';
    }
}
