<?php

declare(strict_types=1);

namespace Domain\Object\ViewModels;

use Cache;
use Closure;
use Domain\Address\Actions\GetMapCenterByCityAction;
use Domain\Address\Traits\GeolocationTrait;
use Domain\Hotel\Actions\FilterHotelsOnMapAction;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\DataTransferObjects\HotelCardData;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\DataTransferObjects\HotelMapData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\Actions\GetPageDescriptionFromParamsData;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsInHotelAction;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomCardData;
use Domain\Search\Traits\SearchResultTrait;
use Domain\Settings\Models\Settings;
use Str;
use Support\DataProcessing\Traits\ResultsCaching;

/**
 * Summary of ObjectsViewModel
 */
final class ObjectsViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    use SearchResultTrait;
    use ResultsCaching;
    use GeolocationTrait;

    /**
     * @param  ParamsData  $params     
     */
    public function __construct(
        protected ParamsData $params,
        protected string $url,      
    ) {
    }
    
    /**     
     * @return Closure
     */
    public function page_description(): Closure
    {        
        return fn () => $this->params->filter ? null :
            PageDescriptionData::fromModel(
                GetPageDescriptionByUrlAction::run($this->url) 
                    ?? 
                GetPageDescriptionFromParamsData::run($this->params)
            );
    }
   
    /**
     * Summary of hotels
     * @return \Closure
     */
    public function hotels(): Closure
    {
        $page = $this->isMap() ? 'all' : request()->get("page", 1);

        if ($this->isMap())
            return fn() => $this->getHotelsOnMap($page, $this->params);
        
        return fn() => $this->getHotelsOnList($page, $this->params);
    }    
    
    public function rooms(): Closure
    {
        $page = $this->isMap() ? 'all' : request()->get("page", 1);
        
        if ($this->isMap())
            return fn() => $this->getRoomsOnMap($page, $this->params);

        return fn() => $this->getRoomsOnList($page, $this->params);
    }

    /**    
     * @return string
     */
    public function list_type(): string 
    { 
        return $this->params->room_filter ? 'rooms' : 'hotels';
    }

    public function default_description(): Closure 
    {     
        if ($this->isMap())
            return fn() => null;
        
        $option = $this->params->room_filter ? 'seo_/rooms' : 'seo_/hotels';
        
        return fn() => Cache::remember($option, now()->addDays(365), fn() => optional(Settings::where('option', $option)->first())->value);
    }

    public function map_center(): Closure
    {
        return fn() => GetMapCenterByCityAction::run($this->params->hotels->city);
    }

    public function is_map() 
    {
        return $this->isMap();
    }   
    private function isMap(): bool 
    {
        return $this->params->as == 'map';
    }

    private function getHotelsOnMap(string|int $page, ParamsData $params) 
    {
        return $this->getCahchedData(
            $params, 
            $page, 
            'map', 
            fn() => HotelMapData::fromCollectionWithFilters(FilterHotelsOnMapAction::run($params->hotels, $params->rooms), $params)
        );
    }

    private function getHotelsOnList(string|int $page, ParamsData $params)
    {
        if ($params->room_filter)
            return [];

        return $this->getCahchedData(
            $params, 
            $page, 
            'hotels', 
            fn() => HotelCardData::collection(FilterHotelsPaginateAction::run($params->hotels))
        );
    }

    private function getRoomsOnMap(string|int $page, ParamsData $params) 
    {
        if (is_null($params->hotel_id))
            return [];

        return $this->getCahchedData(
            $params,
            $page, 
            'rooms-hotel-'.$params->hotel_id.'-',
            fn() => RoomCardData::collection(FilterRoomsInHotelAction::run($params->hotel_id, $params->rooms))
        );
    }

    private function getRoomsOnList(string|int $page, ParamsData $params)
    {
        if (!$params->room_filter)
            return [];

        return $this->getCahchedData(
            $params, 
            $page,
            'rooms',
            fn() => RoomCardData::collection(FilterRoomsPaginateAction::run($params->rooms, $params->hotels))
        );
    }
}
