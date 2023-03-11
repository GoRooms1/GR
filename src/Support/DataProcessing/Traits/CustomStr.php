<?php

declare(strict_types=1);

namespace Support\DataProcessing\Traits;

use Str;

trait CustomStr
{
    protected array $custom_slug_rules = [
        'ю' => 'yu',
        'я' => 'ya',
    ];

    public function getCustomSlug(string $str) {
        $str = Str::lower($str);
        foreach($this->custom_slug_rules as $key => $value) {
            $str = Str::replace($key, $value, $str);
        }

        return Str::slug($str);        
    }
}
