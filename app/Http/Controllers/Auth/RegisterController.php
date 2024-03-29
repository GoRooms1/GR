<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Support\Rules\UniqueClientPhone;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }
    
    public function showRegistrationForm()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {        
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:7', 'max:25', new UniqueClientPhone()],
            'gender' => ['required', 'string', 'in:m,f'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => (new ClientsPhoneNumberValueObject($data['phone']))->toNative(),
            'gender' => $data['gender'],
            'is_client' => true,
            'password' => Hash::make($data['password']),
            'notify_hot' => true,
            'notify_review' => true,
            'register_sent_at' => Carbon::now(),
        ]);
    }

    protected function redirectTo()
    {
        if (auth()->user()->is_client) {
            return route('client.settings.index');
        }

        return RouteServiceProvider::HOME;
    }
}
