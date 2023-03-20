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
    ];

    /**
     * Generate slug from string with custom char replace
     *
     * @param  string  $str
     * @return string
     */
    public static function getCustomSlug(string $str): string
    {
        /** @var string */
        $str = Str::lower($str);

        foreach (CustomStr::CUSTOM_SLUG_RULES as $key => $value) {
            $str = Str::replace($key, $value, $str);
        }

        return Str::slug($str);
    }
}
