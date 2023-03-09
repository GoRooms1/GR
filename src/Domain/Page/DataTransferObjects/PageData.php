<?php

declare(strict_types=1);

namespace Domain\Page\DataTransferObjects;

use Domain\Image\Models\Image;
use Domain\Page\Models\Page;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Lazy;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class PageData extends \Parent\DataTransferObjects\Data
{
    /**
     * @param  int|null  $id
     * @param  string  $title
     * @param  string  $slug
     * @param  string  $content
     * @param  string|null  $header
     * @param  string|null  $footer
     * @param  \Domain\Image\Models\Image|null  $image
     * @param  Collection<\Domain\Image\Models\Image>|array<\Domain\Image\Models\Image>  $images
     * @param  int|null  $user_id
     * @param  Carbon|null  $created_at
     * @param  Lazy|PageDescriptionData|null  $meta
     */
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

    public static function fromPageDescription(PageDescription | null $pageDescription): self
    { 
        return new self(            
            id: 0,
            title: $pageDescription ? $pageDescription->title : env('APP_NAME', 'App'),
            slug: $pageDescription ? $pageDescription->url : '/',
            content: '',
            header: '',
            footer: '',
            image: null,
            images: [],
            user_id: 0,
            created_at: $pageDescription ? $pageDescription->created_at : Carbon::now(),
            meta: $pageDescription ? PageDescriptionData::fromModel($pageDescription) : null
        );
    }
}
