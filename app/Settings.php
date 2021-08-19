<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;
use JsonException;

class Settings extends Model
{
  protected $fillable = [
    'option',
    'value',
  ];

  /**
   */
  private static function is_json($data): bool
  {
    try {
      json_decode($data, true, 512, JSON_THROW_ON_ERROR);
      return false;
    } catch (JsonException $e) {
      return true;
    }

//    return (json_last_error() === JSON_ERROR_NONE);
  }

  /**
   */
  public function __call($method, $parameters)
  {
    if ($method === 'option') {
      return static::option(...$parameters);
    }
    return parent::__call($method, $parameters);
  }

  /**
   */
  public static function option(string $option = null, $default = null)
  {
    $setting = Cache::store('file')->rememberForever('setting.' . $option, function () use ($option) {
      return Settings::where('option', $option)->first();
    });
    if ($setting) {
      try {
        return json_decode($setting->value, true, 512, JSON_THROW_ON_ERROR);
      } catch (JsonException $e) {
        return $setting->value;
      }
    }

    return $default;
  }
}
