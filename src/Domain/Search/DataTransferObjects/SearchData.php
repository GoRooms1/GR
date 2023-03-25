<?php

declare(strict_types=1);

namespace Domain\Search\DataTransferObjects;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

final class SearchData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public string $title,
        public ?int $sort,        
        #[DataCollectionOf(\Parent\DataTransferObjects\Data::class)]     
        public DataCollection $data,
        public ?bool $blank = false,
    ) {
    }
}
