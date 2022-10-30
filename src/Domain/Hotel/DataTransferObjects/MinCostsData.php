<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

final class MinCostsData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly string $info,
        public readonly float $value,
        public readonly ?string $description = '',
    ) {
    }
}
