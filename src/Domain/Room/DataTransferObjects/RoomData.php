<?php

declare(strict_types=1);

namespace Domain\Room\DataTransferObjects;

use App\Models\Image;
use Domain\Attribute\DataTransferObjects\AttributeData;
use Domain\Category\DataTransferObjects\CategoryData;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class RoomData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?int $number,
        public ?int $order,
        public ?int $category_id,
        public bool $moderate,
        public ?string $description,
        public int $hotel_id,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
        public bool $is_hot,
        #[DataCollectionOf(AttributeData::class)]
        public readonly null|Lazy|DataCollection $attrs,
        public Image $image,
        /** @var Collection<Image>|Image[] */
        public Collection|array $images,
        public Lazy|PageDescriptionData|null $meta,
        public Lazy|HotelData|null $hotel,
        public Lazy|CategoryData|null $category,
        #[DataCollectionOf(CostData::class)]
        public readonly null|Lazy|DataCollection $costs,
    ) {
    }

    public static function fromModel(Room $room): self
    {
        return self::from([
            ...$room->toArray(),
            'created_at' => $room->created_at,
            'updated_at' => $room->updated_at,
            'image' => $room->image,
            'images' => $room->images,
            'attrs' => Lazy::whenLoaded('attrs', $room, fn () => AttributeData::collection($room->attrs)),
            'meta' => Lazy::whenLoaded('meta', $room, fn () => PageDescriptionData::from($room->meta)),
            'hotel' => Lazy::whenLoaded('hotel', $room, fn () => HotelData::fromModel($room->hotel)),
            'category' => Lazy::whenLoaded('category', $room, fn () => $room->category ? CategoryData::fromModel($room->category) : null),
            'costs' => Lazy::whenLoaded('costs', $room, fn () => CostData::collection($room->costs)),
        ]);
    }
}
