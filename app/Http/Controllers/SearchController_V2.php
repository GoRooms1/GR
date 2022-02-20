<?php

namespace App\Http\Controllers;

use App\Traits\Filter;
use Illuminate\Http\Request;

class SearchController_V2 extends Controller
{
  use Filter;

  public function index (Request $request)
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
    $with_map = false;
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
      $with_map
    );

    $hotels = $data->hotels;
    $rooms = $data->rooms;
    $is_room = $data->is_room;

    if ($api = $request->boolean('api')) {
      return view('web.search_', compact('rooms', 'hotels'));
    }
    return view('search.index', compact(
      'rooms',
      'hotels'
    ));
  }

  public function map (Request $request)
  {

    $search = $request->get('query');
    $attributes = $request->get('attributes', ['hotel' => [], 'room' => []]);
    $city = $request->get('city', 'Москва');
    $city_area = $request->get('city_area');
    $district = $request->get('district');
    $hotel_type = $request->get('hotel_type');
    $metro = $request->get('metro');
    $cost = $request->get('cost');
    $search_price = $request->get('search-price');
    $hot = $request->boolean('hot');

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
      true
    );
    $hotels = $data->hotels;
    $hotels_popular = $data->hotels_popular;


    return view('search.map', compact('hotels', 'hotels_popular'));
  }

}