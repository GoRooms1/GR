<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

final class MetroData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $color,
        public string $name,
        public string $api_value,
        public int $distance,
        public int $hotel_id,
        public bool $custom,
    ) {
    }
}
