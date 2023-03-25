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
use Domain\Search\DataTransferObjects\SearchData;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;


/**
 * Summary of SearchResultTrait
 */
trait SearchResultTrait
{
    
    /**     
     * @return CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
     */
    public function search_result(): CursorPaginatedDataCollection|DataCollection|PaginatedDataCollection
    {        
        $search = $this->params->search;
        
        return SearchData::collection([
            [
                'title' => 'Отели',
                'sort' => 1,
                'blank' => true,
                'data' => HotelSearchData::collection(SearchHotelsAction::run($search))
            ],
            [
                'title' => 'Метро',
                'sort' => 2,
                'data' => MetroSearchData::collection(SearchMetrosAction::run($search))
            ],
            [
                'title' => 'Районы',
                'sort' => 3,
                'data' => CityDistrictSearchData::collection(SearchCityDistrictsAction::run($search))
            ],
            [
                'title' => 'Огруга',
                'sort' => 4,
                'data' => CityAreaSearchData::collection(SearchCityAreasAction::run($search))
            ],
            [
                'title' => 'Города',
                'sort' => 5,
                'data' => CitySearchData::collection(SearchCitiesAction::run($search))
            ],
        ]);
    }

}
