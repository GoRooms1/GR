<?php

declare(strict_types=1);

namespace Support\Actions;

use DB;
use Domain\PageDescription\Models\PageDescription;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;
use Support\DataProcessing\Traits\CustomStr;

final class GetSeoUrlAction extends Action
{    
    public function handle(Request $request): string | null
    {
        $paramsData = ParamsData::fromRequest($request);
        $url = "";

        $city = $paramsData->hotels->city;
        $area = $paramsData->hotels->area;
        $district = $paramsData->hotels->district;
        $metro = $paramsData->hotels->metro;

        
        if (empty($city))
            return null;

        if ($city == 'Москва и МО') {
            $paramsData->hotels->city = null;           
            return empty($paramsData->toQueryString()) ? '/' : '/?'.$paramsData->toQueryString();
        }

        /** City slug */
        if (!$this->checkSlug($city))
            return null;

        $url .= '/address/'.CustomStr::getCustomSlug($city);
        $paramsData->hotels->city = null;
        
        /** Metro slug */        
        if (!empty($metro)) {
            $url .= '/metro-'.CustomStr::getCustomSlug($metro);
            $paramsData->hotels->metro = null;
        }
        
        /** Area slug */
        if (!empty($area) && empty($metro)) {
            $url .= '/area-'.CustomStr::getCustomSlug($area);
            $paramsData->hotels->area = null;
        }           
        
        /** District slug */
        if (!empty($area) && !empty($district) && empty($metro)) {          
            $url .= '/district-'.CustomStr::getCustomSlug($district);
            $paramsData->hotels->district = null;
        }

        if (! PageDescription::where('url', $url)->exists()) {
            return null;
        }
        
        $queryParamsString = $paramsData->toQueryString();
        $queryParamsString = empty($queryParamsString) ? '' : '?'.$queryParamsString;
        
        return $url.$queryParamsString;
    }
    private function checkSlug(string $slug): bool
    {
        $slug = CustomStr::getCustomSlug($slug);
        return DB::table('address_slug')->where('slug', $slug)->first() != null;
    }
}
