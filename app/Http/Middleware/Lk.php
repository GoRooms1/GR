<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * if user login and have hotel
 */
class Lk
{
    /**
     * Handle an incoming request.
     * Check isset user exist Hotel
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
//    If logged in
            try {
                $user = User::findOrFail(auth()->id());
                if ($user->personal_hotel) {
                    return $next($request);
                }
                
                return redirect()->route('lk.start');
            } catch (ModelNotFoundException $e) {
                abort(404, 'Пользователь не найден');
            }
        }

        return redirect()->route('index');
    }
}
