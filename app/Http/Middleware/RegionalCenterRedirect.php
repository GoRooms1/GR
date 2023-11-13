<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Address\Actions\GetLocationFromSession;
use Domain\Address\Models\RegionalCenter;
use Domain\Hotel\Models\Hotel;
use Illuminate\Http\Request;
use Support\DataProcessing\Traits\CustomStr;

class RegionalCenterRedirect
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
        
        /** Skip if filter */
        if ($isFilter)
            return $next($request);
        
        /** Skip if location was found */
        if (session()->get('location', false))
            return $next($request);
        
        $geoLocation = GetLocationFromSession::run($request->ip());
        
        /**Skip for Moscow */
        if ($geoLocation->city == 'Москва' || $geoLocation->region == 'Московская')
            return $next($request);

        $regionalCenter = RegionalCenter::where('region', $geoLocation->region)->first();
       
        /** Skip if regional center not defined */
        if (is_null($regionalCenter))
            return $next($request);

        $region = $regionalCenter->region;
        $hotelInRegion = Hotel::whereHas('address', function ($q) use ($region) {
            $q->where('region', $region);
        })->count();

        /** Skip if no hotels in region */
        if ($hotelInRegion == 0)
            return $next($request);

        /** Redirect to Regional Center SEO page*/
        $citySlug = CustomStr::getCustomSlug($regionalCenter->city);
        return redirect()->route('address', ['city' => $citySlug]);
    }    
}
