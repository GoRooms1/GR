<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Domain\User\DataTransferObjects\ClientUserData;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:1,60')->only('resend');
        $this->middleware('throttle:10,1')->only('verify');    
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $user = User::find($request->user()->id);
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : Inertia::render('Auth/Verify', [
                            'user' => ClientUserData::from($user),
                        ]);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                        ? new JsonResponse([], 204)
                        : redirect($this->redirectPath());
        }      

        $request->user()->sendEmailVerificationNotification();
        $user = User::find($request->user()->id);       
        $user->verification_sent_at = Carbon::now();
        $user->save();

        return $request->wantsJson()
                    ? new JsonResponse([], 202)
                    : back()->with([
                        'resent'=> true,
                        'message' => 'Ссылка для подтверждения email адреса была отправлена!',
                    ]);
    }
}
