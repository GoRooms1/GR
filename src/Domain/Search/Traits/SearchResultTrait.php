<?php

declare(strict_types=1);

namespace Domain\Search\Traits;

use Domain\Address\Actions\SearchCitiesAction;
use Domain\Address\Actions\SearchCityAreasAction;
use Domain\Address\Actions\SearchCityDistrictsAction;
use Domain\Address\Actions\SearchMetrosAction;
use Domain\Address\DataTransferObjects\CityAreaSearchData;
use Domain\Address\DataTransferObjects\CityDistrictSearchData;
use Domain\Address\DataTransferObjects\CitySearchData;
use Domain\Address\DataTransferObjects\MetroSearchData;
use Domain\Hotel\Actions\SearchHotelsAction;
use Domain\Hotel\DataTransferObjects\HotelSearchData;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

trait SearchResultTrait
{
    /**    
     * @return array<string,  DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection>
     */
    public function search_result(): array
    {        
        $search = $this->params->search;

        return [
            'hotels' => HotelSearchData::collection(SearchHotelsAction::run($search)),
            'metros' => MetroSearchData::collection(SearchMetrosAction::run($search)),
            'city_districts' => CityDistrictSearchData::collection(SearchCityDistrictsAction::run($search)),
            'city_areas' => CityAreaSearchData::collection(SearchCityAreasAction::run($search)),
            'cities' => CitySearchData::collection(SearchCitiesAction::run($search)),           
        ];
    }

}
