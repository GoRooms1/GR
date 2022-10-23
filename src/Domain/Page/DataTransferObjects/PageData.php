<?php

declare(strict_types=1);

namespace Domain\Page\DataTransferObjects;

use App\Models\Image;
use Domain\Page\Models\Page;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Lazy;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/** @typescript */
final class PageData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $slug,
        public readonly string $content,
        public readonly ?string $header,
        public readonly ?string $footer,
        public readonly ?Image $image,
        public readonly Collection|array $images,
        public readonly ?int $user_id,
        public readonly ?Carbon $created_at,
        public readonly null|Lazy|PageDescriptionData $meta,
    ) {
    }

    public static function fromModel(Page $page): self
    {
        return self::from([
            ...$page->toArray(),
            'meta' => Lazy::whenLoaded('meta', $page, fn () => PageDescriptionData::from($page->meta)),
        ]);
    }
}
