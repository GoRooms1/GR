<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $address = $this->collection;

        return ['data' => $address];
        $areas = explode('-', $address->city_area);
        $area = '';
        foreach ($areas as $area_prefix) {
            $area .= mb_substr($area_prefix, 0, 1);
        }
        $area = mb_strtoupper($area).'АО';

        return [
            'city' => $address->city,
            'city_area' => $area,
            'city_district' => $address->city_district,
            'street' => $address->street,
            'geo_lat' => $address->geo_lat,
            'geo_lon' => $address->geo_lon,
            'value' => $address->value,
            'street_with_type' => $address->street_with_type,
        ];
    }
}
