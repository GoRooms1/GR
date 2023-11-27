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
        public ?string $sort,        
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
            'search' => str_replace('\\', '/', $request->get('search') ?? ''),
            'filter' => filter_var($request->get('filter', false), FILTER_VALIDATE_BOOLEAN),
            'as' => $request->get('as'),
            'sort' => $request->get('as') != 'map' ? $request->get('sort') : null,
        ]);
    }

    public static function getEmptyData(): self
    {
        $emptyData = self::empty();
        $emptyData['room_filter'] = false;
        return self::from($emptyData);
    }

    /**     
     * @return string
     */
    public function toQueryString(): string {
        $queryArray = $this->toArray();
        
        foreach ($queryArray as $key => $value) {
           if (empty($value))
            unset($queryArray[$key]);
        }

        return Arr::query($queryArray);
    }
}
