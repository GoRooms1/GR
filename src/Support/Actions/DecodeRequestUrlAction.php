<?php

declare(strict_types=1);

namespace Support\Actions;

use DB;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

final class DecodeRequestUrlAction extends Action
{    
    public function handle(Request $request): \Domain\Search\DataTransferObjects\HotelParamsData
    {
        $paramsData = ParamsData::fromRequest($request);
        $hotelPramsData = $paramsData->hotels;

        $url = $request->url();
        $array = explode('/', $url);
        $addressIndex = array_search('address', $array, true);
        $arrayParams = array_slice($array, $addressIndex + 1);
        
        if (count($arrayParams) == 0)
            abort(404);
        
        $slugs = [];
        $slugs['city'] = $arrayParams[0];

        array_map(static function ($item) use (&$slugs) {            
            if (false !== strpos($item, 'metro-')) {
                $metro_url = explode('metro-', $item)[1];
                $slugs['metro'] = $metro_url;           
            }
            else if (false !== strpos($item, 'area-')) {
                $area_url = explode('area-', $item)[1];
                $slugs['area'] = $area_url;
            }
            else if (false !== strpos($item, 'district-')) {
                $district_url = explode('district-', $item)[1];
                $slugs['district'] = $district_url;
            }
            else {
                abort(404);
            }

        }, array_slice($arrayParams, 1));

        foreach ($slugs as $key => $item) {
            $hotelPramsData->$key = $this->decodeSlug($item);
        }
        
        return $hotelPramsData;
    }
    private function decodeSlug(string $slug)
    {       
        $addressSlug = DB::table('address_slug')->where('slug', $slug)->first();

        if (is_null($addressSlug))
            abort(404);

        return $addressSlug->address;
    }    
}
