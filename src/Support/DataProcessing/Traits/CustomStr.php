<?php

declare(strict_types=1);

namespace Support\DataProcessing\Traits;

use Str;

final class CustomStr
{
    const CUSTOM_SLUG_RULES = [
        'ю' => 'yu',
        'я' => 'ya',
    ];

    public static function getCustomSlug(string $str) {
        $str = Str::lower($str);
        foreach(CustomStr::CUSTOM_SLUG_RULES as $key => $value) {
            $str = Str::replace($key, $value, $str);
        }

        return Str::slug($str);        
    }
}
