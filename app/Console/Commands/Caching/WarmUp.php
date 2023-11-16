<?php

namespace App\Console\Commands\Caching;

use Cache;
use Domain\Attribute\Model\Attribute;
use Domain\Hotel\Actions\FilterHotelsOnMapAction;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\DataTransferObjects\HotelCardData;
use Domain\Hotel\DataTransferObjects\HotelMapData;
use Domain\Hotel\DataTransferObjects\HotelShowData;
use Domain\Hotel\Models\Hotel;
use Domain\PageDescription\Models\PageDescription;
use Domain\Room\Actions\FilterRoomsInHotelPaginateAction;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomCardData;
use Domain\Search\DataTransferObjects\ParamsData;
use Exception;
use Illuminate\Console\Command;
use Str;
use Support\DataProcessing\Traits\ResultsCaching;
use Support\DataProcessing\Traits\UrlDecodeFilter;

class WarmUp extends Command
{
    use UrlDecodeFilter;
    use ResultsCaching;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'caching:warm-up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up SEO pages data';

    /**
     * Execute the console command. 
     * @return int
     */
    public function handle(): int
    {
        $this->info('Process started at '.date("Y-m-d H:i:s"));
        $this->output->progressStart(PageDescription::count());

        $this->cacheAddressPages();
        $this->cacheHotelPages();
        $this->cacheCustomPages();

        $this->output->progressFinish();
        $this->info('Process completed at '.date("Y-m-d H:i:s"));
        return 0;
    }

    private function cacheAddressPages() 
    {
        $pages = PageDescription::where('url', 'like', '/address%')
            ->orWhere('url', '/hotels')
            ->get();

        foreach ($pages as $page) {           
            try {
                $params = ParamsData::getEmptyData();
                $params->hotels = $this->decodeUrl($page->url);               
               
                $this->getCahchedData(
                    $params,
                    1,
                    'hotels',
                    fn() => HotelCardData::collection(FilterHotelsPaginateAction::run($params->hotels))
                );
                
                $this->getCahchedData(
                    $params, 
                    'all', 
                    'map', 
                    fn() => HotelMapData::fromCollectionWithFilters(FilterHotelsOnMapAction::run($params->hotels, $params->rooms), $params)
                );
            }
            catch (Exception $e) {}          
            
            $this->output->progressAdvance();
        }
    }

    private function cacheHotelPages() 
    {
        $pages = PageDescription::where('url', 'like', '/hotels/%')->get();

        foreach ($pages as $page) {           
            try {
                $hotel = Hotel::where('slug',  Str::afterLast($page->url, '/'))->first(); 
                $params = ParamsData::getEmptyData();

                Cache::remember(
                    'hotel-'.$hotel->id, 
                    now()->addDays(7), 
                    fn() => HotelShowData::fromModel($hotel->load('attrs'))
                );

                $this->getCahchedData(
                    $params,
                    1,
                    'rooms-hotel-'.$hotel->id.'-',
                    fn() => RoomCardData::collection(FilterRoomsInHotelPaginateAction::run($hotel->id, $params->rooms))
                );
            }
            catch (Exception $e) {}          
            
            $this->output->progressAdvance();
        }
    }

    private function cacheCustomPages() 
    {
        $params = ParamsData::getEmptyData();
        $params->hotels->city = 'Москва';
        $page = 1;
        
        //Rooms
        $this->getCahchedData($params, $page, 'rooms', fn() => RoomCardData::collection(FilterRoomsPaginateAction::run($params))); 
        $this->output->progressAdvance();

        //jacuzzi
        $params->room_filter = true;
        $params->rooms->attrs = [
            optional(Attribute::forRooms()->where('name', 'Джакузи')->first())->id ?? 0
        ];
        $this->getCahchedData($params, $page, 'rooms', fn() => RoomCardData::collection(FilterRoomsPaginateAction::run($params))); 
        $this->output->progressAdvance();
        
        //centre
        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = 'Москва';
        $params->hotels->area = 'Центральный';
        $this->getCahchedData($params, $page, 'hotels', fn() => HotelCardData::collection(FilterHotelsPaginateAction::run($params->hotels))); 
        $this->output->progressAdvance();

        //fiveMinut
        $params = ParamsData::getEmptyData();
        $params->room_filter = false;
        $params->hotels->city = 'Москва';
        $params->hotels->attrs = [
            optional(Attribute::forHotels()->where('name', '5 минут до метро')->first())->id ?? 0
        ];
        $this->getCahchedData($params, $page, 'hotels', fn() => HotelCardData::collection(FilterHotelsPaginateAction::run($params->hotels))); 
        $this->output->progressAdvance();

        //lowcost
        $params = ParamsData::getEmptyData();
        $params->room_filter = true;
        $params->hotels->city = 'Москва';
        $params->rooms->low_cost = true;
        $this->getCahchedData($params, $page, 'rooms', fn() => RoomCardData::collection(FilterRoomsPaginateAction::run($params))); 
        $this->output->progressAdvance();     
    }

}
