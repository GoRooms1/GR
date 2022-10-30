<?php

namespace App\Console\Commands\Seo;

use App\Models\Metro;
use DB;
use Domain\Address\Models\Address;
use Illuminate\Console\Command;
use Str;

class ResetAddressSlug extends Command
{
    protected $signature = 'seo:reset-address-slug';

    public function handle(): int
    {
        $metros = Metro::all();
        $addresses = Address::all();

        DB::table('address_slug')->delete();

        foreach ($metros as $metro) {
            if (! DB::table('address_slug')->where('address', $metro->name)->exists()) {
                DB::table('address_slug')->insert([
                    'address' => $metro->name,
                    'slug' => Str::slug($metro->name),
                ]);
            }
        }
        $options = ['city', 'city_district', 'city_area', 'street'];
        foreach ($addresses as $address) {
            foreach ($options as $option) {
                $attr = $address->getAttribute($option);
                if ($attr && ! DB::table('address_slug')->where('address', $attr)->exists()) {
                    DB::table('address_slug')->insert([
                        'address' => $attr,
                        'slug' => Str::slug($attr),
                    ]);
                }
            }
        }
        $this->info('End will be generated slug');

        return 0;
    }
}
