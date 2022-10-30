<?php

declare(strict_types=1);

namespace Domain\Attribute\DataTransferObjects;

use Domain\Attribute\Model\AttributeCategory;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class AttributeCategoryData extends \Spatie\LaravelData\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?Carbon $created_at,
        public readonly ?Carbon $updated_at,
        /** @var DataCollection<AttributeData> */
        public readonly null|Lazy|DataCollection $attributes,
    ) {
    }

    public static function fromModel(AttributeCategory $attributeCategory): self
    {
        return self::from([
            ...$attributeCategory->toArray(),
            'attributes' => Lazy::whenLoaded('attributes', $attributeCategory, fn () => AttributeData::collection($attributeCategory->attributes)),
        ]);
    }
}
