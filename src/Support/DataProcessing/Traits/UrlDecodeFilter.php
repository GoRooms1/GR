<?php

declare(strict_types=1);

namespace Support\DataProcessing\Traits;

use Domain\Search\DataTransferObjects\HotelParamsData;
use Illuminate\Support\Facades\DB;

/**
 * Summary of UrlDecodeFilter
 */
trait UrlDecodeFilter
{
    /**
     * Генерирует массив данные адреса из ссыоки для SEO
     *
     * @param  string  $url
     * @return HotelParamsData
     */
    private function decodeUrl(string $url): HotelParamsData
    {
        $array = explode('/', $url);
        $addressIndex = array_search('address', $array, true);
        $arrayParams = array_slice($array, $addressIndex + 1);

        if (count($arrayParams) == 0) {
            return new HotelParamsData(
                attrs: [],
                city: null,
                metro: null,
                area: null,
                district: null,
                street: null,
                type: null,
                moderate: null,
            );
        }

        $city_url = $arrayParams[0];
        $metro_url = null;
        $area_url = null;
        $district_url = null;
        $street_url = null;

        array_map(static function ($item) use (&$metro_url, &$area_url, &$district_url, &$street_url) {
            if (false !== strpos($item, 'metro-')) {
                $metro_url = explode('metro-', $item)[1];
            }

            if (false !== strpos($item, 'area-')) {
                $area_url = explode('area-', $item)[1];
            }

            if (false !== strpos($item, 'district-')) {
                $district_url = explode('district-', $item)[1];
            }

            if (false !== strpos($item, 'street-')) {
                $street_url = explode('street-', $item)[1];
            }
        }, $arrayParams);

        /** @var array<string, string|null> */
        $data = [
            'city' => $city_url,
            'metro' => $metro_url,
            'area' => $area_url,
            'district' => $district_url,
            'street' => $street_url,
        ];

        return $this->getDecodeData($data);
    }

    /**
     * @param  array<string, string|null>  $data
     * @return HotelParamsData
     */
    private function getDecodeData(array $data): HotelParamsData
    {
        $city = null;
        $metro = null;
        $area = null;
        $district = null;
        $street = null;

        foreach ($data as $key => $item) {           
            $slug = is_null($item) ? null : DB::table('address_slug')->where('slug', $item)->first();
            
            if (is_null($slug) && !is_null($item))
                abort(404);

            switch ($key) {
                case 'city':
                    $city = $slug->address ?? null;
                    break;
                case 'metro':
                    $metro = $slug->address ?? null;
                    break;
                case 'area':
                    $area = $slug->address ?? null;
                    break;
                case 'district':
                    $district = $slug->address ?? null;
                    break;
                case 'street':
                    $street = $slug->address ?? null;
                    break;
            }
        }

        $hotelParamsData = HotelParamsData::from(HotelParamsData::empty());
        $hotelParamsData->city = $city;
        $hotelParamsData->metro = $metro;
        $hotelParamsData->area = $area;
        $hotelParamsData->district = $district;
        $hotelParamsData->street = $street;

        return $hotelParamsData;
    }
}
