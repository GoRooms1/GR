<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait UrlDecodeFilter
{

  /**
   * Генерирует массив данные адреса из ссыоки для SEO
   *
   * @param string $url
   *
   * @return array
   */
  private function decodeUrl (string $url): array
  {
    $array = explode('/', $url);
    $addressIndex = array_search('address', $array, true);
    $arrayParams = array_slice($array, $addressIndex + 1);
    $arrayParams[] = 'address-test';

    $city_url = $arrayParams[0];
    $metro_url = null;
    $area_url = null;
    $district_url = null;
    $street_url = null;

    array_map(static function ($item) use (&$metro_url, &$area_url, &$district_url, &$street_url) {
      if(false !== strpos($item, "metro-")) {
        $metro_url = explode('metro-',$item)[1];
      }

      if(false !== strpos($item, "area-")) {
        $area_url = explode('area-',$item)[1];
      }

      if(false !== strpos($item, "district-")) {
        $district_url = explode('district-',$item)[1];
      }

      if(false !== strpos($item, "street-")) {
        $street_url = explode('street-',$item)[1];
      }
    }, $arrayParams);

    $data = [
      'city' => $city_url,
      'metro' => $metro_url,
      'area' => $area_url,
      'district' => $district_url,
      'street' => $street_url
    ];

    return $this->getDecodeData($data);
  }

  private function getDecodeData(array $data): array
  {
    $city = null;
    $metro = null;
    $area = null;
    $district = null;
    $street = null;

    foreach ($data as $key => $item) {
      $slug = DB::table('address_slug')->where('slug', $item)->first();
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

    return [
      'city' => $city,
      'metro' => $metro,
      'area' => $area,
      'district' => $district,
      'street' => $street
    ];
  }
}