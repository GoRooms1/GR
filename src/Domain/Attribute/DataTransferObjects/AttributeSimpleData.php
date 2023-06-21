<?php

declare(strict_types=1);

namespace Domain\Attribute\DataTransferObjects;

use Domain\Attribute\Model\Attribute;
use Illuminate\Support\Carbon;

final class AttributeSimpleData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $model,       
        public readonly bool $in_filter,
        public readonly int $attribute_category_id,
        public string $category,       
    ) {
    }

    public static function fromModel(Attribute $attribute): self
    {
        return self::from([
            ...$attribute->toArray(),
            'category' => $attribute->category,         
        ]);
    }
}
