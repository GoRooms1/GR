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
     * @param bool $room_filter
     */
    public function __construct(
        public HotelParamsData $hotels,
        public RoomParamsData $rooms,
        public ?int $hotel_id,        
        public ?string $search,
        public ?bool $filter,
        public ?string $as,
        public bool $room_filter = false,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        $hotels = HotelParamsData::fromRequest($request);
        $rooms = RoomParamsData::fromRequest($request);
        $isRoomsFilter = !$rooms->isEmpty();

        return self::from([
            'hotels' => $hotels,
            'rooms' => $rooms,
            'room_filter' => $isRoomsFilter,
            'hotel_id' => $request->get('hotel_id'),     
            'search' => $request->get('search'),
            'filter' => filter_var($request->get('filter', false), FILTER_VALIDATE_BOOLEAN),
            'as' => $request->get('as'),         
        ]);
    }

    public static function getEmptyData(): self
    {
        return self::from(self::empty());
    }

    /**     
     * @return string
     */
    public function toQueryString(): string {
        return Arr::query($this->toArray());
    }
}
