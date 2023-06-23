<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Support\Actions\GetSeoUrlAction;

class SeoPathRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $isFilter = filter_var( $request->query('filter'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        
        if (!$isFilter) {
            $seoUrl = GetSeoUrlAction::run($request);
            
            if ($seoUrl)
                return redirect()->to($seoUrl);
        }

        return $next($request);
    }
}
