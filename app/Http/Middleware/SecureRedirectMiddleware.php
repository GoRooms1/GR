<?php

namespace App\Http\Middleware;

use Closure;

class SecureRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('FORCE_HTTPS', true)) {
          
            return redirect()->secure($request->path(),301);
        }
        return $next($request);
    }
}
