<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'option',
        'value',
    ];

    public static function option(string $option = null, $default = null)
    {
        $setting = \Cache::store('file')->rememberForever('setting.'.$option, function() use ($option) {
            return Settings::where('option', $option)->first();
        });
        if ($setting)
            return self::is_json($setting->value) ? json_decode($setting->value) : $setting->value;

        return $default;
    }

    private static function is_json($data):bool
    {
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function __call($method, $parameters)
    {
        if ($method === 'option')
            return static::option(...$parameters);
        return parent::__call($method, $parameters);
    }
}
