<?php

namespace App\Console\Commands\Images;

use Domain\Hotel\Models\Hotel;
use Domain\Image\Models\Image;
use Domain\Room\Models\Room;
use Illuminate\Console\Command;
use Str;

class ConvertToMedialibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:convert-to-medialibrary {--force} {--hotel=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert images to Spatie Medialibrary';

    /**
     * Execute the console command. 
     * @return int
     */
    public function handle(): int
    {        
        $hotel_id = $this->option('hotel');
        
        $hotels = Hotel::withoutGlobalScopes()
            ->when($hotel_id, function($q) use ($hotel_id){
                $q->where('id', $hotel_id);
            })           
            ->get();
        
        $this->info('Images сonversion started at '.date("Y-m-d H:i:s"));
        $this->output->progressStart($hotels->count());

        foreach ($hotels as $hotel) {
            $images = Image::where('model_id', $hotel->id)->where('model_type', Hotel::class)->orderBy('order')->get();

            if ($hotel->getMedia('images')->count() !== $images->count() || $this->option('force') == true) {
                $hotel->clearMediaCollection('images');

                foreach ($images as $image) {
                    try {
                        $hotel
                            ->addMedia(str_replace('/image', 'storage/app/public', $image->path))
                            ->withCustomProperties(['moderate' => $image->moderate])
                            ->preservingOriginal()
                            ->toMediaCollection('images');
                    } catch (\Throwable $th) {                        
                    }               
                }
            }

            $this->convertRoomsImages($hotel);
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
        $this->info('Images conversion completed at '.date("Y-m-d H:i:s"));
        return 0;
    }
   
    private function convertRoomsImages(Hotel $hotel) {       
        $rooms = Room::withoutGlobalScopes()->where('hotel_id', $hotel->id)->get(); 

        foreach ($rooms as $room) {
            $images = Image::where('model_id', $room->id)->where('model_type', Room::class)->orderBy('order')->get();

            if ($room->getMedia('images')->count() !== $images->count() || $this->option('force') == true) {
                $room->clearMediaCollection('images');        
            
                foreach ($images as $image) {
                    try {
                        $room
                            ->addMedia(str_replace('/image', 'storage/app/public', $image->path))
                            ->withCustomProperties(['moderate' => $image->moderate])
                            ->preservingOriginal()
                            ->toMediaCollection('images');
                    } catch (\Throwable $th) {

                    }               
                } 
            }          
        }
    }
}
