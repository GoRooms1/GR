<?php

declare(strict_types=1);

namespace Domain\Category\DataTransferObjects;

use Domain\Category\Models\Category;
use Illuminate\Support\Carbon;

final class CategoryData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public int $hotel_id,
        public ?int $value,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
    ) {
    }

    public static function fromModel(Category $category): self
    {
        return self::from([
            ...$category->toArray(),
        ]);
    }
}
