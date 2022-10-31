<?php

declare(strict_types=1);

namespace Domain\Hotel\Filters;

use Parent\Filters\Filter;

enum Filters: string
{
    case Name = 'name';

    public function createFilter(string $value): Filter
    {
        return match ($this) {
            self::Name => new NameFilter($value)
        };
    }
}
