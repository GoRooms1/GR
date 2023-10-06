<?php

declare(strict_types=1);

namespace Domain\Hotel\Casts;

use Domain\Hotel\Models\Hotel;
use Domain\Hotel\ValueObjects\PhoneNumberValueObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

final class PhoneNumberCast implements CastsAttributes
{
    /**
     * @param  Hotel  $model
     * @param  string  $key
     * @param  ?string  $value
     * @param  array<string>  $attributes
     * @return PhoneNumberValueObject|null
     */
    public function get($model, string $key, $value, array $attributes): ?PhoneNumberValueObject
    {
        if (! $value) {
            return null;
        }
        
        if (! $model->hide_phone && ! \Request::is('admin/*') && ! \Request::is('lk/*') && ! \Request::is('moderator/*') && !\Request::is('rooms/booking')) {
            return null;
        }

        return PhoneNumberValueObject::fromNative($value);
    }

    /**
     * @param  Hotel  $model
     * @param  string  $key
     * @param  PhoneNumberValueObject|string|null  $value
     * @param  array<string>  $attributes
     * @return string|null
     */
    public function set($model, string $key, $value, array $attributes): string|null
    {
        if (is_null($value)) {
            return null;
        }
        if (is_string($value)) {
            return $value;
        }

        return $value->toNative();
    }
}
