<?php

namespace Domain\Page\DataTransferObjects;

use Domain\Address\DataTransferObjects\AddressData;
use Domain\Address\Models\Address;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\Models\Hotel;
use Spatie\DataTransferObject\DataTransferObject;

class SeoData extends DataTransferObject
{
    public ?string $url;

    public ?string $title;

    public ?string $h1;

    public ?string $description;

    public ?string $metro;

    public ?HotelData $hotel;

    public ?AddressData $address;

    public string $lastOfType = '';

    public static function fromAddressAndUrlHotel(string $url, Hotel $hotel, ?Address $address = null): self
    {
        return new self([
            'url' => $url,
            'hotel' => HotelData::fromModel($hotel),
            'address' => $address ? AddressData::from($address) : null,
            'lastOfType' => 'hotel',
        ]);
    }
}
