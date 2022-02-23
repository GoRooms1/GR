<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Json;
use App\Models\Metro;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
  /**
   * @param Request $request
   *
   * @return JsonResponse
   */
  public function cities(Request $request): JsonResponse
  {
    $request->validate([
      'search' => 'nullable|string',
    ]);
    $search = $request->get('search');
    if ($search) {
      $cities = Address::where('city', 'like', '%' . $search . '%')
        ->pluck('city')
        ->unique();
    } else {
      $cities = Address::pluck('city')
        ->unique()->take(5);
    }

    return Json::good(['cities' => $cities]);
  }

  public function city_area(Request $request): JsonResponse
  {
    $request->validate([
      'search' => 'nullable|string',
      'city' => 'required|string',
    ]);

    $search = $request->get('search', '');
    $search = $search ?? '';
    $city = $request->get('city');

    $city_areas = Address::whereCity($city)
      ->where('city_area', 'like', '%' . $search . '%')
      ->pluck('city_area')
      ->unique();

    return Json::good(['city_areas' => $city_areas]);
  }

  public function count_city_area (Request $request): JsonResponse
  {
    $request->validate([
      'city' => 'required|string'
    ]);

    $city = $request->get('city');
    $count = Address::whereCity($city)
      ->whereNotNull('city_area')
      ->pluck('city_area')
      ->count();

    return Json::good(['count' => $count]);
  }

  public function district (Request $request): JsonResponse
  {
    $request->validate([
      'search' => 'nullable|string',
      'city' => 'required|string',
      'city_area' => 'nullable|string'
    ]);

    $search = $request->get('search', '');
    $search = $search ?? '';

    $city = $request->get('city');
    $city_area = $request->get('city_area', '');
    $city_area = $city_area ?? '';

    $districts = Address::query();
    $districts = $districts->where('city', $city);
    if ($city_area !== '') {
      $districts = $districts->where('city_area', $city_area);
    }
    $districts = $districts->where('city_district', 'like', '%' . $search . '%')
      ->pluck('city_district')
      ->unique();

    return Json::good(['districts' => $districts]);
  }

  public function metro (Request $request): JsonResponse
  {
    $request->validate([
      'search' => 'nullable|string',
      'city' => 'required|string',
      'city_area' => 'nullable|string',
      'district' => 'nullable|string',
    ]);

    $hotels_id = Address::query();
    if ($city = $request->get('city')) {
      $hotels_id = $hotels_id->whereCity($city);
    }

    if ($city_area = $request->get('city_area')) {
      $hotels_id = $hotels_id->where('city_area', $city_area);
    }

    if ($district = $request->get('district')) {
      $hotels_id = $hotels_id->where('city_district', $district);
    }

    $hotels_id = $hotels_id->pluck('hotel_id')->unique();

    $metros = Metro::query()->whereIn('hotel_id', $hotels_id);
    if ($search = $request->get('search')) {
      $metros = $metros->where('name', 'like', '%' . $search . '%');
    }
    $metros = $metros->orderBy('name')->pluck('name')
      ->unique();

    return Json::good(['metros' => $metros]);
  }
}