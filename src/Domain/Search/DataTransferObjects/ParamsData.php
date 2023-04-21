<?php

declare(strict_types=1);

namespace Domain\Search\DataTransferObjects;

use Arr;
use Illuminate\Http\Request;

final class ParamsData extends \Parent\DataTransferObjects\Data
{
    /**     
     * @param HotelParamsData $hotels
     * @param RoomParamsData $rooms     
     * @param string|null $search
     * @param bool $isRoomsFilter
     */
    public function __construct(
        public HotelParamsData $hotels,
        public RoomParamsData $rooms,
        public ?int $hotel_id,
        public ?string $search,        
        public bool $isRoomsFilter = false,        
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            'hotels' => HotelParamsData::fromRequest($request),
            'rooms' => RoomParamsData::fromRequest($request),
            'isRoomsFilter' => filter_var($request->get('isRoomsFilter', false), FILTER_VALIDATE_BOOLEAN),
            'hotel_id' => $request->get('hotel_id'),         
            'search' => $request->get('search'),            
        ]);
    }

    /**     
     * @return string
     */
    public function toQueryString(): string {
        return Arr::query($this->toArray());
    }
}
