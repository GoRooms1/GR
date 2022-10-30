<?php

declare(strict_types=1);

namespace Domain\Attribute\DataTransferObjects;

use Domain\Attribute\Model\Attribute;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Lazy;

final class AttributeData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $model,
        public readonly ?Carbon $created_at,
        public readonly ?Carbon $updated_at,
        public readonly bool $in_filter,
        public readonly int $attribute_category_id,
        public string $category,
        public readonly null|Lazy|AttributeCategoryData $relationCategory,
    ) {
    }

    public static function fromModel(Attribute $attribute): self
    {
        return self::from([
            ...$attribute->toArray(),
            'category' => $attribute->category,
            'relationCategory' => Lazy::whenLoaded('relationCategory', $attribute, fn () => AttributeCategoryData::from($attribute->relationCategory)),
        ]);
    }
}
