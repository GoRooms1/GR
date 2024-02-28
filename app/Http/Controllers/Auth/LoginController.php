<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Domain\Room\Actions\SyncFavoritesAction;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
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
        if ($user->is_client) {
            SyncFavoritesAction::run();                              
            return redirect(route('client.index'));
        }
        
        if ($user->personal_hotel) {            
            return Inertia::location(route('lk.start'));
        }

        if ($user->is_admin) {            
            return Inertia::location(route('admin.index'));
        }

        if ($user->is_moderate) {                              
            return Inertia::location(route('hotels.index'));
        }

        return redirect($this->redirectTo);
    }
    
    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $creditnails = $request->only($this->username(), 'password');
        $creditnails['is_client'] = false;

        if ($this->username() === 'phone') {
            $creditnails['is_client'] = true;
            $creditnails['phone'] = (new ClientsPhoneNumberValueObject($creditnails['phone']))->toNative();
        }        
        
        return $creditnails;
    }

    public function username()
    {
        if(request()->get('hotelier', false)) {
            return 'email';
        }            

        return 'phone';
    }    
}
