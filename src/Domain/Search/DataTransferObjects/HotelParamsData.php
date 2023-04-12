<?php

declare(strict_types=1);

namespace Domain\Search\DataTransferObjects;

use Illuminate\Http\Request;

/**
 * Summary of HotelParamsData
 */
final class HotelParamsData extends \Parent\DataTransferObjects\Data
{
    /**
     * @param  array<int>|null  $attributes
     * @param  string|null  $city
     * @param  string|null  $metro
     * @param  string|null  $city_area
     * @param  string|null  $city_district
     * @param  string|null  $street
     * @param  int|null  $hotel_type
     */
    public function __construct(
        public ?array $attributes,
        public ?string $city,
        public ?string $metro,
        public ?string $city_area,
        public ?string $city_district,
        public ?string $street,
        public ?int $hotel_type,
    ) {
    }

    /**
     * @param  Request  $request
     * @return HotelParamsData
     */
    public static function fromRequest(Request $request): self
    {
        /** @var array<string, array<int>|string|int|bool|null> $data */
        $data = $request->get('hotels', []);

        return self::from([
            'attributes' => $data['attributes'] ?? [],
            'city' => $data['city'] ?? null,
            'metro' => $data['metro'] ?? null,
            'city_area' => $data['city_area'] ?? null,
            'city_district' => $data['city_district'] ?? null,
            'street' => $data['street'] ?? null,
            'hotel_type' => $data['hotel_type'] ?? null,
        ]);
    }
}
