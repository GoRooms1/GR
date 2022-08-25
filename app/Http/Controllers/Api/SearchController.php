<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Filter;

class SearchController extends Controller
{
  use Filter;

  public function index (Request $request)
  {
//    $search = $request->get('query');
    $search = '';
    $attributes = $request->get('attributes', ['hotel' => [], 'room' => []]);
    $city = $request->get('city');
    $city_area = $request->get('city_area');
    $district = $request->get('district');
    $hotel_type = $request->get('hotel_type');
    $metro = $request->get('metro');
    $cost = $request->get('cost');
    $search_price = $request->get('search-price');
    $hot = $request->boolean('hot');
    $moderate = $request->boolean('moderate', false);
    $no_city = $request->boolean('no_city', false);

    $data = $this->filter($search,
      $attributes,
      $city,
      $city_area,
      $district,
      $hotel_type,
      $metro,
      $hot,
      $search_price,
      $cost,
      false,
      false,
      $moderate,
      $no_city
    );

    $hotels = $data->hotels;
    $rooms = $data->rooms;

    $count = 0;
    if ($rooms === null || $moderate) {
      $count = $hotels->total();
    } else {
      $count = $rooms->total();
    }

    return Json::good([
      'count' => $count,
      'is_room' => $data->is_room
    ]);
  }

  public function map (Request $request)
  {
    $search = $request->get('query');
    $attributes = $request->get('attributes', ['hotel' => [], 'room' => []]);
    $city = $request->get('city');
    $city_area = $request->get('city_area');
    $district = $request->get('district');
    $hotel_type = $request->get('hotel_type');
    $metro = $request->get('metro');
    $cost = $request->get('cost');
    $search_price = $request->get('search-price');
    $hot = $request->boolean('hot');
    $moderate = $request->boolean('moderate');

    $data = $this->filter($search,
      $attributes,
      $city,
      $city_area,
      $district,
      $hotel_type,
      $metro,
      $hot,
      $search_price,
      $cost,
      true,
      false,
      $moderate
    );

    $hotels = $data->hotels;
    $rooms = $data->rooms;

    $count = 0;
    if ($rooms === null) {
      $count = $hotels->count();
    } else {
      $count = $rooms->count();
    }

    return Json::good([
      'count' => $count,
      'is_room' => $data->is_room
    ]);
  }
}