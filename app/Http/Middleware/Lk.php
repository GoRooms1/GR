<?php

namespace App\Http\Middleware;

use App;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Lk
{
  /**
   * Handle an incoming request.
   * Check isset user exist Hotel
   *
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (Auth::check()) {
//    If logged in
      $user = User::find(auth()->id());
      if ($user->personal_hotel) {
        return $next($request);
      }
      return redirect()->route('lk.start');
    }

    return redirect()->route('index');
  }
}