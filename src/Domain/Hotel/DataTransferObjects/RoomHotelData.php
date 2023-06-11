<?php

declare(strict_types=1);

namespace Domain\Hotel\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressSimpleData;
use Domain\Address\DataTransferObjects\MetroSimpleData;
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
        public ?string $slug,
        public Lazy|HotelTypeSimpleData|null $type,
        public Lazy|AddressSimpleData|null $address,
        #[DataCollectionOf(MetroSimpleData::class)]
        public readonly null|Lazy|DataCollection $metros
    ) {
    }

    public static function fromModel(Hotel $hotel): self
    {
        return self::from([
            ...$hotel->toArray(),
            'phone' => $hotel->phone,
            'address' => AddressSimpleData::from($hotel->address),
            'type' => HotelTypeSimpleData::from($hotel->type),
            'metros' => MetroSimpleData::collectionWithAddressSlug($hotel->metros, $hotel->address),
        ]);
    }
}
