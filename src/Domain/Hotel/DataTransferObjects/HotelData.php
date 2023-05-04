<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressData;
use Domain\Address\DataTransferObjects\MetroData;
use Domain\Attribute\DataTransferObjects\AttributeData;
use Domain\Hotel\Actions\MinimumCostsCalculation;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\ValueObjects\PhoneNumberValueObject;
use Domain\Image\Models\Image;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\DataTransferObjects\RoomData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class HotelData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public ?PhoneNumberValueObject $phone,
        public ?string $phone_2,
        public ?string $type_fond,
        public int $user_id,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
        public ?bool $is_popular,
        public ?int $type_id,
        public ?string $route,
        public bool $old_moderate,
        public bool $show,
        public bool $moderate,
        public ?string $route_title,
        public ?string $slug,
        public bool $hide_phone,
        public ?string $email,
        public bool $checked_type_fond,
        public Image $image,
        /** @var Collection<Image>|Image[] */
        public Collection|array $images,
        public Lazy|AddressData|null $address,
        public Lazy|HotelTypeData|null $type,
        public Lazy|PageDescriptionData|null $meta,
        #[DataCollectionOf(AttributeData::class)]
        public readonly null|Lazy|DataCollection $attrs,
        #[DataCollectionOf(MetroData::class)]
        public readonly null|Lazy|DataCollection $metros,       
        #[DataCollectionOf(MinCostsData::class)]
        public readonly null|DataCollection $min_costs,
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        return self::from([
            ...$hotel->toArray(),
            'created_at' => $hotel->created_at,
            'updated_at' => $hotel->updated_at,
            'route_title' => $hotel->route_title,
            'hide_phone' => (bool) $hotel->hide_phone,
            'checked_type_fond' => (bool) $hotel->checked_type_fond,
            'phone' => $hotel->phone,
            'image' => $hotel->image,
            'images' => $hotel->images,
            'address' => Lazy::whenLoaded('address', $hotel, fn () => AddressData::from($hotel->address)),
            'type' => Lazy::whenLoaded('type', $hotel, fn () => HotelTypeData::from($hotel->type)),
            'meta' => Lazy::whenLoaded('meta', $hotel, fn () => PageDescriptionData::from($hotel->meta)),
            'attrs' => Lazy::whenLoaded('attrs', $hotel, fn () => AttributeData::collection($hotel->attrs)),
            'metros' => Lazy::whenLoaded('metros', $hotel, fn () => MetroData::collection($hotel->metros)),            
            'min_costs' => MinimumCostsCalculation::run($hotel),
        ]);
    }
}
