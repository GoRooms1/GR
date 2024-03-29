<?php

declare(strict_types=1);

namespace Domain\Settings\Models;

use App\Parents\Model;
use Cache;
use Domain\Settings\DataTransferObjects\SettingsData;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use JsonException;
use Spatie\LaravelData\WithData;

/**
 * Domain\Settings\Models\Settings
 *
 * @property int         $id
 * @property string      $option
 * @property string      $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Settings newModelQuery()
 * @method static Builder|Settings newQuery()
 * @method static Builder|Settings query()
 * @method static Builder|Settings whereCreatedAt($value)
 * @method static Builder|Settings whereId($value)
 * @method static Builder|Settings whereOption($value)
 * @method static Builder|Settings whereUpdatedAt($value)
 * @method static Builder|Settings whereValue($value)
 * @mixin Eloquent
 *
 * @property string|null $header
 *
 * @method static Builder|Settings whereHeader($value)
 */
class Settings extends Model
{
    use WithData;

    protected string $dataClass = SettingsData::class;

    protected $fillable = ['option', 'value', 'header'];

    /**
     * @todo refactor with action
     *
     * @param  string|null  $option
     * @param  string|null  $default
     * @return mixed
     */
    public static function header(string $option = null, string $default = null): mixed
    {
        $setting = Cache::store('redis')->rememberForever('setting.'.$option, function () use ($option) {
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
     * @todo remove after refactor header() and option()
     */
    public function __call($method, $parameters): mixed
    {
        if ($method === 'option') {
            return static::option(...$parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * @todo refactor with action
     *
     * @param  string|null  $option
     * @param  string|null  $default
     * @return mixed
     */
    public static function option($option = null, $default = null): mixed
    {
        $setting = Cache::store('redis')->rememberForever('setting.'.$option, function () use ($option) {
            return Settings::where('option', $option)->first();
        });
        if ($setting) {
            try {               
                return json_decode($setting->value, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
            } catch (JsonException $e) {
                return $setting->value;
            }
        }

        return $default;
    }
}
