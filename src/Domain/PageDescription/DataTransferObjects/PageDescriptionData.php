<?php

declare(strict_types=1);

namespace Domain\PageDescription\DataTransferObjects;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

final class PageDescriptionData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $url,
        public readonly string $type,
        public readonly ?string $title,
        public readonly ?string $h1,
        public readonly ?string $model_type,
        public readonly ?string $meta_description,
        public readonly ?string $meta_keywords,
        public readonly ?string $description,
        public readonly ?Carbon $created_at,
        public readonly ?Carbon $updated_at,
        public readonly ?Image $image,
        public readonly Collection|array $images,
        public readonly ?int $model_id,
    ) {
    }
}
