<?php

declare(strict_types=1);

namespace Domain\Attribute\DataTransferObjects;

use Domain\Attribute\Model\AttributeCategory;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class AttributeCategorySimpleData extends \Spatie\LaravelData\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,           
    ) {
    }

    public static function fromModel(AttributeCategory $attributeCategory): self
    {
        return self::from([
            ...$attributeCategory->toArray(),         
        ]);
    }
}
