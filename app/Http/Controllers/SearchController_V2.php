<?php

namespace App\Http\Controllers;

use App\Traits\Filter;
use Illuminate\Http\Request;
use App\Traits\UrlDecodeFilter;

class SearchController_V2 extends Controller
{
  use Filter;
  use UrlDecodeFilter;

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
      false
    );

    $hotels = $data->hotels;
    $rooms = $data->rooms;

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

  public function address (Request $request)
  {
    $url = $request->url();

    $data = $this->decodeUrl($url);

    $city = $data['city'];
    $metro = $data['metro'];
    $area = $data['area'];
    $district = $data['district'];
    $street = $data['street'];
    $search_price = null;
    $hot = false;
    $cost = null;
    $attributes = ['hotel' => [], 'room' => []];
    $hotel_type = null;
    $search = null;

    $data = $this->filter($search,
      $attributes,
      $city,
      $area,
      $district,
      $hotel_type,
      $metro,
      $hot,
      $search_price,
      $cost,
      false
    );

    $hotels = $data->hotels;
    $rooms = $data->rooms;

    if ($api = $request->boolean('api')) {
      return view('web.search_', compact('rooms', 'hotels'));
    }

    return view('search.index', compact(
      'rooms',
      'hotels'
    ));
  }

}