<?php

namespace App\Http\Middleware;

use App;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
  /**
   * Handle an incoming request.
   * Check isset user Admin Flag
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
      if ($user->is_admin) {
        return $next($request);
      }
    }

    return route('index');
  }
}