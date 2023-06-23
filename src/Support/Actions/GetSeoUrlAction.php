<?php

declare(strict_types=1);

namespace Support\Actions;

use DB;
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

        if ($city == 'Москва и МО') {
            return '/?'.$paramsData->toQueryString();
        }

        if (!empty($city)) {
            if (!$this->checkSlug($city))
                return null;

            $url .= '/address/'.CustomStr::getCustomSlug($city);
            $paramsData->hotels->city = null;            
        }            
        
        if (!empty($city) && empty($area) && empty($district) && !empty($metro)) {
            if (!$this->checkSlug($metro))
                return null;

            $url .= '/metro-'.CustomStr::getCustomSlug($metro);
            $paramsData->hotels->metro = null;
        }            
        
        if (!empty($city) && !empty($area)) {
            if (!$this->checkSlug($area))
                return null;

            $url .= '/area-'.CustomStr::getCustomSlug($area);
            $paramsData->hotels->area = null;
        }           
        
        if (!empty($city) && !empty($area) && !empty($district)) {
            if (!$this->checkSlug($district))
                return null;

            $url .= '/district-'.CustomStr::getCustomSlug($district);
            $paramsData->hotels->district = null;
        }

        if ($url == "")
            return null;
        
        $queryParamsString = $paramsData->toQueryString();   
        
        return $url.'?'.$queryParamsString;
    }
    private function checkSlug(string $slug): bool
    {
        $slug = CustomStr::getCustomSlug($slug);
        return DB::table('address_slug')->where('slug', $slug)->first() != null;
    }
}
