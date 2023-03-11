<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressData;
use Domain\Address\DataTransferObjects\MetroData;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\ValueObjects\PhoneNumberValueObject;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

final class RoomHotelData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?PhoneNumberValueObject $phone,
        public ?string $phone_2,
        public ?string $email,
        public Lazy|HotelTypeData|null $type,
        public Lazy|AddressData|null $address,
        #[DataCollectionOf(MetroData::class)]
        public readonly null|Lazy|DataCollection $metros
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        return self::from([
            ...$hotel->toArray(),
            'phone' => $hotel->phone,
            'address' => Lazy::whenLoaded('address', $hotel, fn () => AddressData::from($hotel->address)),
            'type' => Lazy::whenLoaded('type', $hotel, fn () => HotelTypeData::from($hotel->type)),
            'metros' => Lazy::whenLoaded('metros', $hotel, fn () => MetroData::collection($hotel->metros)),
        ]);
    }
}
