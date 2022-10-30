<?php

declare(strict_types=1);

namespace App\Console\Commands\Seo;

use Domain\Address\Actions\GenerateSlugForMetro;
use Domain\Address\Models\Metro;
use Illuminate\Console\Command;

final class CreateSlugMetro extends Command
{
    protected $signature = 'seo:create-slug-metro';

    public function handle(): int
    {
        $this->withProgressBar(Metro::all(), function (Metro $metro) {
            GenerateSlugForMetro::run($metro->name);
        });

        $this->info('End will be generated slug for metros');

        return 0;
    }
}
