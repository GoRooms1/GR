<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = User::find(auth()->id());
            if ($user->is_admin) {                              
                return Inertia::location(route('admin.index'));
            }

            if ($user->personal_hotel) {
                return Inertia::location(route('lk.index'));
            }

            if ($user->is_moderate) {                              
                return redirect(route('hotels.index'));
            }

            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
