<?php

declare(strict_types=1);

namespace Support\Enums;

use App\Models\Room;
use Domain\Hotel\Models\Hotel;

enum ModelNamesEnum
{
    case Hotel;
    case Room;

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
        };
    }
}
