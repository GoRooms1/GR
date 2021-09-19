<?php

namespace App;

use Cache;
use Eloquent;
use JsonException;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Settings
 *
 * @property int         $id
 * @property string      $option
 * @property string      $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Settings newModelQuery()
 * @method static Builder|Settings newQuery()
 * @method static Builder|Settings query()
 * @method static Builder|Settings whereCreatedAt($value)
 * @method static Builder|Settings whereId($value)
 * @method static Builder|Settings whereOption($value)
 * @method static Builder|Settings whereUpdatedAt($value)
 * @method static Builder|Settings whereValue($value)
 * @mixin Eloquent
 * @property string|null $header
 * @method static Builder|Settings whereHeader($value)
 */
class Settings extends Model
{

  protected $fillable = ['option', 'value', 'header'];

  public static function header (string $option = null, $default = null)
  {
    $setting = Cache::store('file')->rememberForever('setting.' . $option, function () use ($option) {
      return Settings::where('option', $option)->first();
    });
    if ($setting) {
      try {
        return json_decode($setting->header, true, 512, JSON_THROW_ON_ERROR);
      } catch (JsonException $e) {
        return $setting->header;
      }
    }

    return $default;
  }

  /**
   */
  private static function is_json ($data): bool
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
  public function __call ($method, $parameters)
  {
    if ($method === 'option') {
      return static::option(...$parameters);
    }

    return parent::__call($method, $parameters);
  }

  /**
   */
  public static function option (string $option = null, $default = null)
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
