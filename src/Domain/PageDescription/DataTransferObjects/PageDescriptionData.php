<?php

declare(strict_types=1);

namespace Domain\PageDescription\DataTransferObjects;

use App\Http\Requests\HotelRequest;
use App\Models\Image;
use Domain\Hotel\Models\Hotel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
final class PageDescriptionData extends \Parent\DataTransferObjects\Data
{
    /**
     * @param  int|null  $id
     * @param  string  $url
     * @param  string  $type
     * @param  string|null  $title
     * @param  string|null  $h1
     * @param  string|null  $model_type
     * @param  string|null  $meta_description
     * @param  string|null  $meta_keywords
     * @param  string|null  $description
     * @param  Carbon|null  $created_at
     * @param  Carbon|null  $updated_at
     * @param  Image|null  $image
     * @param  Collection<Image>|array<Image>  $images
     * @param  int|null  $model_id
     */
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

    public static function fromRequestAndHotel(HotelRequest $request, Hotel $hotel): self
    {
        return new self(
            id: null, url: '/hotels/'.$hotel->slug, type: 'hotel',
            title: $request->get('meta_title', $hotel->meta_title), h1: $request->get('h1', $hotel->meta_h1),
            model_type: $hotel::class,
            meta_description: $request->get('meta_description', $hotel->meta_description),
            meta_keywords: $request->get('meta_keywords'),
            description: null,
            created_at: Carbon::now(),
            updated_at: Carbon::now(),
            image: null,
            images: [], model_id: $hotel->id
        );
    }
}
