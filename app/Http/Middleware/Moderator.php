<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * If user moderator
 */
class Moderator
{

  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   *
   * @return mixed
   */
  public function handle (Request  $request, Closure $next)
  {
    if (Auth::check()) {
      try {
        $user = User::findOrFail(auth()->id());
        if ($user->is_moderate) {
          return $next($request);
        }
        return redirect()->route('index');
      } catch (ModelNotFoundException $e) {
        abort('404', 'Пользователь не найден');
      }
    }

    return redirect()->route('index');
  }
}
