<?php

declare(strict_types=1);

namespace App\Console\Commands\Seo;

use Domain\Address\Actions\GenerateAddressSlug;
use Domain\Address\Models\Address;
use Illuminate\Console\Command;

final class CreateSlugAddress extends Command
{
    protected $signature = 'seo:create-slug-address';

    public function handle(): int
    {
        $this->withProgressBar(Address::all(), function (Address $address) {            
            if (!(empty($address->city)))
                GenerateAddressSlug::run($address->city);
            
            if (!(empty($address->city_area)))    
                GenerateAddressSlug::run($address->city_area);

            if (!(empty($address->city_district)))
                GenerateAddressSlug::run($address->city_district);            
        });

        $this->info('End will be generated slug for address');

        return 0;
    }
}
