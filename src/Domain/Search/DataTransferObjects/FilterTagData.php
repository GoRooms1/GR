<?php

declare(strict_types=1);

namespace Domain\Search\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

final class FilterTagData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?String $title,
        public string $modelType,
        public ?string $key,        
        public ?bool $isAttribute,
        public bool|int|string $value,
    ) {
    }
}
