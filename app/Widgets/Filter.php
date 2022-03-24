<?php

namespace App\Widgets;

use Log;
use Cookie;
use JsonException;
use App\Models\Metro;
use App\Models\Address;
use App\Models\CostType;
use App\Models\HotelType;
use App\Models\Attribute;
use App\Traits\UrlDecodeFilter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

class Filter extends AbstractWidget
{
  use UrlDecodeFilter;
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
  protected bool $hot = false;
  protected $request;
  protected ?string $query = null;
  protected Collection $hotels_type;
  protected Collection $hotels_attributes;
  protected Collection $rooms_attributes;
  protected ?string $hotel_type = '';
  protected Object $data;
  protected bool $moderate;
  protected Collection $attributes;

  /**
   * Treat this method as a controller action.
   * Return view() or other content to display.
   */
  public function run()
  {
    $this->request = Request();
    $flagRouteAddress = false;
    if (Request::routeIs('search.address')) {
      $flagRouteAddress = true;

      $url = $this->request->url();

      $data = $this->decodeUrl($url);

      $this->city = $data['city'];
      $this->metro = $data['metro'];
      $this->area = $data['area'];
      $this->district = $data['district'];
      $this->street = $data['street'];

    } else {

      if ($metro_req = Request::get('metro')) {
        $metro = Metro::where('name', $metro_req)->first();
        if ($metro) {
          $this->metro = $metro->name;
        }
      }

      if ($city_req = Request::get('city', $this->defaultLocation())) {
        $adr = Address::where('city', $city_req)->first();
        if ($adr) {
          $this->city = $adr->city;
        }
      }

      if ($district_req = Request::get('district')) {
        $adr = Address::where('city_district', $district_req)->first();
        if ($adr) {
          $this->district = $adr->city_district;
        }
      }

      if ($area_req = Request::get('city_area')) {
        $adr = Address::where('city_area', $area_req)->first();
        if ($adr) {
          $this->area = $adr->city_area;
        }
      }

      if ($street_req = Request::get('street')) {
        $adr = Address::where('street', $street_req)->first();
        if ($adr) {
          $this->street = $adr->street;
        }
      }

      $this->query = Request::get('query');

      $this->hotel_type = Request::get('hotel_type');
    }

    $this->hotels_type = Cache::remember('hotels_type', 60 * 60 * 24 * 12, static function () {
      return HotelType::orderBy('sort')->get();
    });

    $this->hotels_attributes = Cache::remember('hotels_attributes', 60 * 60 * 24 * 12, static function () {
      return Attribute::forHotels()->filtered()->get();
    });

    $this->rooms_attributes = Cache::remember('rooms_attributes', 60 * 60 * 24 * 12, static function () {
      return Attribute::forRooms()->filtered()->get();
    });

    $attributes = $this->normalizeAttrs();

    if (count($attributes['room']) > 0 || count($attributes['hotel']) > 0) {
      $this->attributes = Attribute::findMany(array_merge($attributes['room'], $attributes['hotel']));
    } else {
      $this->attributes = new Collection();
    }

//    Normalize attrs

    $this->hot = Request::boolean('hot');

    $this->moderate = Request::boolean('moderate');

    $data = [
      [
        'key' => 'city',
        'value' => $this->city
      ],
      [
        'key' => 'metro',
        'value' => $this->metro
      ],
      [
        'key' => 'district',
        'value' => $this->district
      ],
      [
        'key' => 'city_area',
        'value' => $this->area
      ],
      [
        'key' => 'hot',
        'value' => $this->hot
      ]
    ];

    $costTypes = CostType::with('filterCosts')->orderBy('sort')->get();

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
      'moderate'          => $this->moderate,
      'attributes'        => $this->attributes,
      'hot'               => $this->hot,
      'costTypes'         => $costTypes,
      'data'              => $data
    ]);
  }

  /**
   * @throws JsonException
   */
  private function defaultLocation(): string
  {
    if (Cookie::get('city', null) === null) {
      $ch = curl_init('http://ip-api.com/json/' . '95.188.80.41' . '?lang=ru');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      $res = curl_exec($ch);
      curl_close($ch);

      $res = json_decode($res, true, 512, JSON_THROW_ON_ERROR);

      if (!is_null($res) && isset($res['city'])) {
        $check = Address::where('city', $res['city'])->exists();
        if ($check) {
          Cookie::queue('city', $res['city'], 60);
          return $res['city'];
        }
      }
      Cookie::queue('city', 'Москва', 60);
    }
    return Cookie::get('city', 'Москва');
  }

  private function normalizeAttrs(): array
  {
    $attributes = Request::get('attributes', [
        'hotel' => [],
        'room' => []
      ]
    );

    if (!isset($attributes['hotel'])) {
      $attributes['hotel'] = [];
    }

    if (!isset($attributes['room'])) {
      $attributes['room'] = [];
    }

    return $attributes;
  }

  public static function remove_key($data, $key): string
  {
    if (Route::currentRouteName() === 'search.address') {
      $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/search?';
      foreach ($data as $d) {
        if ($d['key'] !== $key) {
          $url .= $d['key'] . '=' . $d['value'] . '&';
        }
      }

      return $url;
    }
    parse_str($_SERVER['QUERY_STRING'], $vars);
    Log::alert($vars);
    return strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query(array_diff_key($vars,array($key=>"")));
  }

  public static function remove_attr($type, $id): string
  {
    parse_str($_SERVER['QUERY_STRING'], $vars);
    Log::alert($vars);
    $attrs_of_type = $vars['attributes'][$type];
    foreach ($attrs_of_type as $i => $item) {
      if ((string)$item === (string)$id) {
        $attrs_of_type = array_diff_key($attrs_of_type,array($i=>""));
      }
    }
    $vars['attributes'][$type] = $attrs_of_type;

    return strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query($vars);
  }
}
