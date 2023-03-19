<?php

declare(strict_types=1);

namespace Domain\Filter\DataTransferObjects;

use Illuminate\Http\Request;

final class ParamsData extends \Parent\DataTransferObjects\Data
{    
    public function __construct(
        public HotelParamsData $hotels,
        public RoomParamsData $rooms,
        public Bool $isRoomsFilter = false,
    ) {

    }   

    public static function fromRequest(Request $request): self
    {        
        return self::from([
           'hotels' => HotelParamsData::fromRequest($request),
           'rooms' => RoomParamsData::fromRequest($request),
           'isRoomsFilter' => filter_var($request->get('isRoomsFilter', false), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
