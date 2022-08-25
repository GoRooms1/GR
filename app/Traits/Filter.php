<?php

namespace App\Traits;

use ErrorException;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Address;
use App\Models\CostType;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

trait Filter
{
  /** @noinspection StaticInvocationViaThisInspection */
  public function filter(
    ?string $search,
    ?array  $attributes,
    ?string $city,
    ?string $city_area,
    ?string $district,
    ?int    $hotel_type,
    ?string $metro,
    bool    $hot,
    ?string $search_price,
    ?string $cost,
    bool    $with_map,
    bool    $popular  = false,
    bool    $moderate = false,
    bool    $no_city  = false
  ): object
  {
    $is_room = (isset($attributes['room']) && count($attributes['room'])) || $hot || isset($cost);

    $unitedHotelsBool = false;
    $unitedCities = null;

    //    Normalize data
    if (!isset($attributes['room'])) {
      $attributes['room'] = [];
    }

    if (!isset($attributes['hotel'])) {
      $attributes['hotel'] = [];
    }
    if ($moderate) {
      $is_room = false;
    }
    if ($with_map) {
      $is_room = false;
    }
    $hotels = null;
    $rooms = null;

    $hotels_popular = Collection::empty();

    // Если отели
    if (!$is_room) {
      $hotels = Hotel::query();
      $hotels = $hotels->with(['address', 'attrs']);

      if ($moderate) {
        $hotels = $hotels->withoutGlobalScopes(['moderation'])->where(function ($q) {
          $q->where('moderate', true)->where('old_moderate', true);
        });

        $hotelsWhereModerateRoom = Hotel::withoutGlobalScopes(['moderation'])->whereHas('rooms', function ($q) {
          $q->withoutGlobalScopes(['moderation'])->where('moderate', true);
        })->pluck('id');

        $hotelsID = $hotels->pluck('id')->merge($hotelsWhereModerateRoom)->unique();

        $hotels = Hotel::query();
        $hotels = $hotels->with(['address', 'attrs']);
        $hotels = $hotels
          ->withoutGlobalScopes(['moderation'])
          ->whereIn('id',$hotelsID)
          ->orderBy('updated_at', 'DESC');
      }

      if ($search) {
        $hotels = $hotels->where('name', 'like', '%' . $search . '%')
          ->orWhereHas('rooms', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
          })
          ->orWhereHas('metros', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
          })
          ->orWhereHas('address', function ($q) use ($search) {
            $q->where('value', 'like', '%' . $search . '%');
          });
      }

      if ($metro) {
        $hotels = $hotels->whereHas('metros', static function (Builder $q) use ($metro) {
          $q->where('name', $metro);
        });
      }

      if (!$no_city) {
        if ($city) {

          if ($metro) {

            $unitedCities = Address::whereCity($city)->first();
            if ($unitedCities) {
              $unitedHotelsBool = true;
              $unitedCities = $unitedCities->unitedCities();
              $hotels = $hotels->whereHas('address', static function (Builder $q) use ($unitedCities, $city) {
                foreach ($unitedCities as $key => $unitedCity) {
                  if ($key === 0) {
                    $q->where('city', $unitedCity);
                  } else {
                    $q->orWhere('city', $unitedCity);
                  }
                }
              });
            }
          } else {

            $hotels = $hotels->whereHas('address', static function (Builder $q) use ($city) {
              $q->where('city', $city);
            });
          }
        }

        if ($city_area) {
          $hotels = $hotels->whereHas('address', function (Builder $q) use ($city_area) {
            $q->where('city_area', $city_area);
          });
        }

        if ($district) {
          $hotels = $hotels->whereHas('address', function (Builder $q) use ($district) {
            $q->where('city_district', $district);
          });
        }
      }


      if ($hotel_type) {
        $hotels = $hotels->where('type_id', $hotel_type);
      }

      if (count($attributes['hotel']) > 0) {
        foreach ($attributes['hotel'] as $id) {
          $hotels = $hotels->whereHas('attrs', function (Builder $q_attrs) use ($id) {
            $q_attrs->where('id', $id);
          });
        }
      }

      if (count($attributes['room']) > 0) {
        foreach ($attributes['hotel'] as $id) {
          $hotels = $hotels->whereHas('rooms', function (Builder $q_hotel) use ($id) {
            $q_hotel->whereHas('attrs', function (Builder $q_attrs) use ($id) {
              $q_attrs->where('id', $id);
            });
          });
        }
      }

      if ($type_price = $search_price) {
//        Ищем сами стоимости из запроса
        $prices = explode('.', $cost);
        $type_interval = explode('.', $cost)[1];
        $last_price = '';
//        Если выбрано от и до
        if ($flag = (count(explode('-', end($prices))) > 1)) {
          $first_price = explode('-', end($prices))[0];
          $last_price = explode('-', end($prices))[1];
        } else {
//          Если выбрато либо От либо До
          $first_price = end($prices);
        }
//        Поиск цены в комнатах
//        Ищем отели  которых есть данные стоимости
        $hotels = $hotels->whereHas('rooms', function (Builder $q_rooms) use ($type_price, $flag, $type_interval, $first_price, $last_price) {
          $q_rooms->whereHas('costs', function (Builder $q_cost) use ($type_price, $flag, $type_interval, $first_price, $last_price) {
            $q_cost->whereHas('period', function (Builder $q_period) use ($type_price) {
//              Ищем определённый тип периода в комнатах
              $q_period->where('cost_type_id', $this->costTypeTranslate($type_price));
            });
//            Фильтруем по цене в комнатах
            if ($flag) {
              $q_cost->where('value', '>=', $first_price)
                ->where('value', '<=', $last_price);
            } else {
              $q_cost->where('value', $type_interval === 'lte' ? '<=' : '>=', $first_price);
            }

            $q_cost->where('value', '>', 0);
          });
        });
      }

      if ($popular) {
        $hotels_popular = clone $hotels;
        $hotels_popular = $hotels_popular->where('is_popular', true)->get();
      }

      if ($with_map) {
        $hotels = $hotels->get();
      } else {
//        Сортировка что бы был главный город выбранный
        if (!$no_city && $unitedHotelsBool) {
          $hotelsPrimary = clone $hotels;
          $unitedCitiesIsHas = clone $hotels;
          $unitedCities = $unitedCitiesIsHas->get('address')->pluck('address.city')->unique();
          $hotelsPrimary = $hotelsPrimary->whereHas('address', function (Builder $q) use ($city) {
            $q->where('city', $city);
          });

          $hotels = $hotels->whereHas('address', function (Builder $q) use ($city) {
            $q->where('city', '!=', $city);
          });

          $ids = $hotelsPrimary->pluck('id');

          $ids = $ids->merge($hotels->pluck('id'));

          $rawOrderSql = '(CASE ' . collect($ids)->map(function($id, $order) {
              return "WHEN id = '{$id}' THEN {$order}";
            })->implode(' ') . ' ELSE 9999 END) ASC';

          $hotels = Hotel::whereIn('id', $ids)->orderByRaw($rawOrderSql);
        }

        $hotels = $hotels->paginate(16);
      }


    }
    else {
      $rooms = Room::query();
      $rooms = $rooms->with('hotel');

      if ($search) {
        $rooms = $rooms->where('name', 'like', '%' . $search . '%')
          ->orWhereHas('hotel', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
          })
          ->orWhereHas('hotel', function (Builder $q_hotel) use ($search) {
            $q_hotel->whereHas('metros', function (Builder $q_metros) use ($search) {
              $q_metros->where('name', 'like', '%' . $search . '%');
            })
              ->orWhereHas('address', function ($q) use ($search) {
                $q->where('value', 'like', '%' . $search . '%');
              });
          });
      }

      if ($city) {
        if ($metro) {
          $unitedCities = Address::whereCity($city)->first();
          if ($unitedCities) {
            $unitedHotelsBool = true;
            $unitedCities = $unitedCities->unitedCities();
            $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($city, $unitedCities) {
              $q_hotel->whereHas('address', function ($q) use ($city, $unitedCities) {
                foreach ($unitedCities as $key => $unitedCity) {
                  if ($key === 0) {
                    $q->where('city', $unitedCity);
                  } else {
                    $q->orWhere('city', $unitedCity);
                  }
                }
              });
            });
          }
        } else {
          $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($city) {
            $q_hotel->whereHas('address', function ($q) use ($city) {
              $q->where('city', $city);
            });
          });
        }
      }

      if ($city_area) {
        $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($city_area) {
          $q_hotel->whereHas('address', function ($q) use ($city_area) {
            $q->where('city_area', $city_area);
          });
        });
      }

      if ($district) {
        $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($district) {
          $q_hotel->whereHas('address', function ($q) use ($district) {
            $q->where('city_district', $district);
          });
        });
      }

      if ($hotel_type) {
        $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($hotel_type) {
          $q_hotel->where('type_id', $hotel_type);
        });
      }

      if ($metro) {
        $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($metro) {
          $q_hotel->whereHas('metros', function ($q) use ($metro) {
            $q->where('name', $metro);
          });
        });
      }

      if (count($attributes['room']) > 0) {
        foreach ($attributes['room'] as $id) {
          $rooms = $rooms->whereHas('attrs', function (Builder $q_attrs) use ($id) {
            $q_attrs->where('id', $id);
          });
        }
      }

      if (isset($attributes['hotel']) && count($attributes['hotel']) > 0) {
        foreach ($attributes['hotel'] as $id) {
          $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($id) {
            $q_hotel->whereHas('attrs', function (Builder $q_attrs) use ($id) {
              $q_attrs->where('id', $id);
            });
          });
        }
      }

      if ($type_price = $search_price) {
//        Ищем сами стоимости из запроса
        $prices = explode('.', $cost);
        $type_interval = explode('.', $cost)[1];
        $last_price = '';
//        Если выбрано от и до
        if ($flag = (count(explode('-', end($prices))) > 1)) {
          $first_price = explode('-', end($prices))[0];
          $last_price = explode('-', end($prices))[1];
        } else {
//          Если выбрато либо От либо До
          $first_price = end($prices);
        }
//        Поиск цены в комнатах
//        Ищем отели  которых есть данные стоимости
        $rooms = $rooms->whereHas('costs', function (Builder $q_cost) use ($type_price, $flag, $type_interval, $first_price, $last_price) {
          $q_cost->whereHas('period', function (Builder $q_period) use ($type_price) {
//              Ищем определённый тип периода в комнатах
            $q_period->where('cost_type_id', $this->costTypeTranslate($type_price));
          });
//            Фильтруем по цене в комнатах
          if ($flag) {
            $q_cost->where('value', '>=', $first_price)
              ->where('value', '<=', $last_price);
          } else {
            $q_cost->where('value', $type_interval === 'lte' ? '<=' : '>=', $first_price);
          }

          $q_cost->where('value', '>', 0);
        });
      }

      if ($unitedHotelsBool) {
        $roomsPrimary = clone $rooms;
        $unitedCitiesIsHas = clone $rooms;
        $unitedCities = $unitedCitiesIsHas->get()->pluck('hotel.address.city')->unique();
        $roomsPrimary = $roomsPrimary->whereHas('hotel', function (Builder $q_hotel) use ($city) {
          $q_hotel->whereHas('address', function (Builder $q) use ($city) {
            $q->where('city', $city);
          });
        });

        $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($city) {
          $q_hotel->whereHas('address', function (Builder $q) use ($city) {
            $q->where('city', '!=', $city);
          });
        });

        $ids = $roomsPrimary->pluck('id');

        $ids = $ids->merge($rooms->pluck('id'));

        $rawOrderSql = '(CASE ' . collect($ids)->map(function($id, $order) {
            return "WHEN id = '{$id}' THEN {$order}";
          })->implode(' ') . ' ELSE 9999 END) ASC';

        $rooms = Room::whereIn('id', $ids)->orderByRaw($rawOrderSql);
      }

      $rooms = $rooms->paginate(16);
    }

    return (object)[
      'rooms' => $rooms,
      'hotels' => $hotels,
      'is_room' => $is_room,
      'hotels_popular' => $hotels_popular,
      'united_cities' => $unitedCities,
      'united_hotels_bool' => $unitedHotelsBool
    ];
  }

  private function costTypeTranslate($type): string
  {
    $costType = CostType::where('slug', $type)->first();
    if ($costType) {
      return $costType->id;
    }

    abort(404);
  }
}