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
     * @param  string|null  $city
     * @param  string|null  $metro
     * @param  string|null  $area
     * @param  string|null  $district
     * @param  string|null  $street
     * @param  int|null  $type
     * @param  array<int>|null  $attrs
     */
    public function __construct(        
        public ?string $city,
        public ?int $type,      
        public ?string $area,
        public ?string $district,
        public ?string $street,
        public ?string $metro,        
        public ?bool $moderate,
        public ?array $attrs,
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
            'city' => $data['city'] ?? null,
            'metro' => $data['metro'] ?? null,
            'area' => $data['area'] ?? null,
            'district' => $data['district'] ?? null,
            'street' => $data['street'] ?? null,
            'type' => $data['type'] ?? null,
            'moderate' => $data['moderate'] ?? null,
            'attrs' => $data['attrs'] ?? [],
        ]);
    }
}
