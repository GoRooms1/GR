<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Notifications\VerifyDeleteUserEmail;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DeleteController extends Controller
{
    public function resend(Request $request)
    {       
        $user = User::find(auth()->user()->id);
        
        if (!$user->email_verified_at) {
            return Redirect::back()->withErrors("Почта не подтвержедна!");
        }
        
        $user->delete_token = Str::random(32);
        $user->save();

        $user->notify(new VerifyDeleteUserEmail());

        return Redirect::back()->with([
            'message' => "Вам на почту отправлено письмо со ссылкой, пройдя по которой Ваш аккаунт будем полностью удален. Спасибо."
        ]);
    }

    public function verify(Request $request)
    {
        if (!$request->hasValidSignature(true)) {
            throw new InvalidSignatureException;
        }
        
        $user = User::where('id', $request->route('id'))->where('is_client', true)->firstOrFail();
        
        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->route('hash'), sha1($user->delete_token))) {
            throw new AuthorizationException;
        }

        $user->forceDelete();

        return Inertia::render('Auth/Deleted');
    }
}
