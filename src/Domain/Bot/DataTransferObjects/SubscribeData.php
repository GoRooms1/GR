<?php

declare(strict_types=1);

namespace Domain\Bot\DataTransferObjects;

final class SubscribeData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $hotel_id,
        public ?string $phone,        
    ) {
    }
}
