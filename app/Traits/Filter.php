<?php

namespace App\Traits;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\CostType;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

trait Filter
{
  public function filter (
    ?string $search,
    ?array $attributes,
    ?string $city,
    ?string $city_area,
    ?string $district,
    ?int $hotel_type,
    ?string $metro,
    bool $hot,
    ?string $search_price,
    ?string $cost,
    bool $with_map,
    bool $popular = false
  ): object
  {
    $is_room = (isset($attributes['room']) && count($attributes['room'])) || $hot;
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

      if ($city) {
        $hotels = $hotels->whereHas('address', function (Builder $q) use ($city) {
          $q->where('city', $city);
        });
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

      if ($metro) {
        $hotels = $hotels->whereHas('metros', function (Builder $q) use ($metro) {
          $q->where('name', $metro);
        });
      }

      if ($hotel_type) {
        $hotels = $hotels->where('type_id', $hotel_type);
      }

      if (count($attributes['hotel']) > 0) {
        $hotels = $hotels->whereHas('attrs', function (Builder $q) use ($attributes) {
          $q->whereIn('id', $attributes['hotel']);
        });
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
        $hotels = $hotels->paginate(16);
      }
    }
    else {
      $rooms = Room::query();

      if ($search) {
        $rooms = $rooms->where('name', 'like', '%' . $search . '%')
          ->orWhereHas('rooms', function ($q) use ($search) {
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
        $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($city) {
          $q_hotel->whereHas('address', function ($q) use ($city) {
            $q->where('city', $city);
          });
        });
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
        $rooms = $rooms->whereHas('attrs', function (Builder $q_attrs) use ($attributes) {
          $q_attrs->whereIn('id', $attributes['room']);
        });
      }

      if (isset($attributes['hotel'])) {
        if (count($attributes['hotel']) > 0) {
          $rooms = $rooms->whereHas('hotel', function (Builder $q_hotel) use ($attributes) {
            $q_hotel->whereHas('attrs', function (Builder $q_attrs) use ($attributes) {
              $q_attrs->whereIn('id', $attributes['hotel']);
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
        });
      }

      $rooms = $rooms->paginate(16);
    }

    return (object) [
      'rooms'  => $rooms,
      'hotels' => $hotels,
      'is_room' => $is_room,
      'hotels_popular' => $hotels_popular
    ];
  }

  private function costTypeTranslate($type): string
  {
    $answer = '';
    switch ($type) {
      case 'day':
        $answer = CostType::where('name', 'На Сутки')->first()->id;
        break;
      case 'hour':
        $answer = CostType::where('name', 'На Час')->first()->id;
        break;
      case 'night':
        $answer = CostType::where('name', 'На Ночь')->first()->id;
        break;
    }

    return $answer;
  }
}