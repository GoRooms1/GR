<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Search\DataTransferObjects\ParamsData;
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
        $paramsData = ParamsData::fromRequest($request);              
        
        if (!$paramsData->filter) {     
            $prevPath = strtolower(parse_url(url()->previous(), PHP_URL_PATH));

            if($prevPath == '/hot' && $paramsData->rooms->is_hot == true)
                return redirect()->to($prevPath.'?'.ParamsData::fromRequest($request)->toQueryString());

            $seoUrl = GetSeoUrlAction::run($request);
            
            if ($seoUrl)
                return redirect()->to($seoUrl);
        }

        return $next($request);
    }

    
}
