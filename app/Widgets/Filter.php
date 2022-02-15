<?php

namespace App\Widgets;

use Cookie;
use App\Models\Metro;
use App\Models\Address;
use App\Models\HotelType;
use App\Models\Attribute;
use Illuminate\Support\Collection;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class Filter extends AbstractWidget
{
  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [
    'request' => null,
  ];


  protected ?string $metro = null;
  protected ?string $city = null;
  protected ?string $district = null;
  protected ?string $area = null;
  protected ?string $street = null;
  protected $request;
  protected ?string $query = null;
  protected Collection $hotels_type;
  protected Collection $hotels_attributes;
  protected Collection $rooms_attributes;
  protected ?string $hotel_type;
  protected Object $data;

  /**
   * Treat this method as a controller action.
   * Return view() or other content to display.
   */
  public function run()
  {
    $this->request = Request();

    if ($metro_req = Request::get('metro')) {
      $metro = Metro::where('name', 'like', '%' . $metro_req . '%')->first();
      if ($metro) {
        $this->metro = $metro->name;
      }
    }

    if ($city_req = Request::get('city', $this->defaultLocation())) {
      $adr = Address::where('city', 'like', '%' . $city_req . '%')->first();
      if ($adr) {
        $this->city = $adr->city;
      }
    }

    if ($district_req = Request::get('district')) {
      $adr = Address::where('city_district', 'like', '%' . $district_req . '%')->first();
      if ($adr) {
        $this->district = $adr->city_district;
      }
    }

    if ($area_req = Request::get('city_area')) {
      $adr = Address::where('city_area', 'like', '%' . $area_req . '%')->first();
      if ($adr) {
        $this->area = $adr->city_area;
      }
    }

    if ($street_req = Request::get('street')) {
      $adr = Address::where('street', 'like', '%' . $street_req . '%')->first();
      if ($adr) {
        $this->street = $adr->street;
      }
    }

    $this->query = Request::get('query');

    $this->hotels_type = Cache::remember('hotels_type', 60*60*24*12, static function () {
      return HotelType::orderBy('sort')->get();
    });

    $this->hotel_type = Request::get('hotel_type');

    $this->hotels_attributes = Cache::remember('hotels_attributes', 60*60*24*12, static function() {
      return Attribute::forHotels()->filtered()->get();
    });

    $this->rooms_attributes = Cache::remember('rooms_attributes', 60*60*24*12, static function () {
      return Attribute::forRooms()->filtered()->get();
    });


    return view('widgets.filter', [
      'request'           => $this->request,
      'city'              => $this->city,
      'metro'             => $this->metro,
      'district'          => $this->district,
      'area'              => $this->area,
      'street'            => $this->street,
      'query'             => $this->query,
      'hotels_type'       => $this->hotels_type,
      'hotels_attributes' => $this->hotels_attributes,
      'rooms_attributes'  => $this->rooms_attributes,
      'hotel_type'        => $this->hotel_type,
    ]);
  }

  private function defaultLocation(): string
  {
    return Cookie::get('city', 'Москва');
  }
}
