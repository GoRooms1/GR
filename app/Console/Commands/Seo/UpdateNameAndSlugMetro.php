<?php

namespace App\Console\Commands\Seo;

use App\Helpers\CreateSeoUrls;
use App\Models\Metro;
use DB;
use Domain\Address\Models\Address;
use Domain\PageDescription\Models\PageDescription;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Illuminate\Console\Command;
use Str;

class UpdateNameAndSlugMetro extends Command
{
    protected $signature = 'seo:update-name-and-slug-metro';

    public function handle(): int
    {
        $metros = Metro::where('name', 'like', '%(%')->get();

        foreach ($metros as $metro) {
            $result = DadataSuggest::suggest('metro', [
                'query' => $metro->name,
                'filters' => [
                    'city' => optional($metro->hotel()->withoutGlobalScope('moderation'))->address->city ?? null,
                ],
            ]);
            if (! isset($result['value'])) {
                $result = $result[0];
            }
            $metro->name = $result['data']['name'];
            $metro->api_value = $result['unrestricted_value'];
            $metro->color = $result['data']['color'];
            $metro->save();
        }

        $this->warn('Call php artisan seo:reset-address-slug');
        PageDescription::where('type', 'metro')->delete();
        $csu = new CreateSeoUrls();
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
            $csu->createSeoFromMetro($metro);
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
        $this->warn('End will be generated slug and SEO');

        $this->info('End will be generated new name Metros');

        return 0;
    }
}
