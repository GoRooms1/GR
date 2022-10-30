<?php

declare(strict_types=1);

namespace Domain\Address\DataTransferObjects;

final class AddressSlugData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public string $address,
        public string $slug,
    ) {
    }
}
