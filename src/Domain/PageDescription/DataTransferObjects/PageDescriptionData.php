<?php

declare(strict_types=1);

namespace Domain\PageDescription\DataTransferObjects;

use App\Http\Requests\HotelRequest;
use App\Http\Requests\RoomRequest;
use Domain\Hotel\Models\Hotel;
use Domain\Image\Models\Image;
use Domain\PageDescription\Models\PageDescription;
use Domain\Room\Models\Room;
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
     * @param  Collection<Image>|array<\Domain\Image\Models\Image>  $images
     * @param  int|null  $model_id
     */
    public function __construct(
        public ?int $id,
        public string $url,
        public readonly ?string $type,
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
        public ?int $model_id,
    ) {
    }

    public static function fromModel(PageDescription $pageDescription): self
    {
        return self::from([
            ...$pageDescription->toArray(),
            'images' => [],
        ]);
    }
    
    public static function fromHotel(Hotel $hotel): self
    {        
        $pageDescription = $hotel->meta;
        
        return new self(
            id: $pageDescription?->id, 
            url: $pageDescription?->url ?? '/hotels/'.$hotel->slug, 
            type: 'hotel',
            title: $pageDescription?->title ?? sprintf('Отель "%s" - бронь номера на час ▶Gorooms', $hotel->name),
            h1: $pageDescription?->h1 ?? $hotel->name,
            model_type: $hotel::class,
            meta_description: $pageDescription?->meta_description 
                    ?? 
                sprintf('Забронируйте номер в отеле на час (сутки) "%s" онлайн в компании Gorooms ▶ Без комиссий и посредников▶ Качественное обслуживание ▶ Низкие цены ▶ Звоните!', $hotel->name),
            meta_keywords: $pageDescription?->meta_keywords,
            description: $pageDescription?->description,
            created_at: $pageDescription?->created_at ?? Carbon::now(),
            updated_at: $pageDescription?->updated_at ?? Carbon::now(),
            image: null,
            images: [], 
            model_id: $hotel->id
        );
    }

    public static function fromRequestAndHotel(HotelRequest $request, Hotel $hotel): self
    {
        /** @var string $h1 */
        $h1 = $request->get('h1', $hotel->meta_h1);
        /** @var string $title */
        $title = $request->get('meta_title', $hotel->meta_title);
        /** @var string $description */
        $description = $request->get('meta_description', $hotel->meta_description);
        /** @var string $keywords */
        $keywords = $request->get('meta_keywords');

        return new self(
            id: null, url: '/hotels/'.$hotel->slug, type: 'hotel',
            title: $title,
            h1: $h1,
            model_type: $hotel::class,
            meta_description: $description,
            meta_keywords: $keywords,
            description: null,
            created_at: Carbon::now(),
            updated_at: Carbon::now(),
            image: null,
            images: [], model_id: $hotel->id
        );
    }

    public static function fromRoomRequest(RoomRequest $request): self
    {
        /** @var string $meta_title */
        $meta_title = $request->get('meta_title');
        /** @var string $description */
        $description = $request->get('meta_description');
        /** @var string $keywords */
        $keywords = $request->get('meta_keywords');

        return new self(
            id: null, url: '', type: 'room',
            title: $meta_title,
            h1: $meta_title,
            model_type: Room::class,
            meta_description: $description,
            meta_keywords: $keywords,
            description: null,
            created_at: Carbon::now(),
            updated_at: Carbon::now(),
            image: null,
            images: [], model_id: 0
        );
    }
}
