<?php

declare(strict_types=1);

namespace Support\Enums;

use Domain\AdBanner\Models\AdBanner;
use Domain\Hotel\Models\Hotel;
use Domain\Room\Models\Room;

enum ModelNamesEnum
{
    case Hotel;
    case Room;
    case AdBanner;

    public static function fromName(string $name): self
    {
        /** @var self $result */
        $result = constant("self::$name");

        return $result;
    }

    public function getClassName(): string
    {
        return match ($this) {
            self::Hotel => Hotel::class,
            self::Room => Room::class,
            self::AdBanner => AdBanner::class,
        };
    }
}
