<?php

namespace App\Console\Commands\OneTime;

use App\Models\Address;
use App\Models\Metro;
use App\Models\PageDescription;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateAddressesSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:addresses_slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->output->title('Update addresses slugs');
        $addresses = Address::all();
        foreach ($addresses as $address) {
            $title = "Номера города '{$address->city}'";
            $url = '/address';
            foreach (['city', 'city_area', 'city_district', 'street'] as $column) {
                $prefix = str_replace(['city', '_'], '', $column);
                $prefix = ! empty($prefix) ? $prefix.'-' : $prefix;
                $url .= '/'.$prefix.Str::slug($address->$column);
                PageDescription::updateOrCreate(['url' => $url], ['title' => $title]);
                if ($column == 'city') {
                    $metros = Metro::whereHas('hotel', function ($query) use ($address) {
                        return $query->whereHas('address', function ($cityQuery) use ($address) {
                            return $cityQuery->where('city', $address->city);
                        });
                    })->get();
                    foreach ($metros as $metro) {
                        $link = $url.'/metro-'.Str::slug($metro->name);
                        PageDescription::updateOrCreate(['url' => $link], ['title' => $title]);
                    }
                }
            }
        }

        return 0;
    }
}
