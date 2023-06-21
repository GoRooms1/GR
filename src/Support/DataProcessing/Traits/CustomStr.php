<?php

declare(strict_types=1);

namespace Support\DataProcessing\Traits;

use Str;

/**
 * Summary of CustomStr
 */
final class CustomStr
{
    const CUSTOM_SLUG_RULES = [
        'ю' => 'yu',
        'я' => 'ya',
        'ё' => 'yo'
    ];

    /**
     * Generate slug from string with custom char replace
     *
     * @param  string|null  $str
     * @return string
     */
    public static function getCustomSlug(string|null $str): string
    {
        if (is_null($str))
            return '';
            
        /** @var string */
        $str = Str::lower($str);

        foreach (CustomStr::CUSTOM_SLUG_RULES as $key => $value) {
            $str = Str::replace($key, $value, $str);
        }

        return Str::slug($str);
    }
}
