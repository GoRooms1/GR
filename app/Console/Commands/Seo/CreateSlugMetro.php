<?php

namespace App\Console\Commands\Seo;

use App\Models\Metro;
use Illuminate\Console\Command;

class CreateSlugMetro extends Command
{
    protected $signature = 'seo:create-slug-metro';

    public function handle(): int
    {
        $metros = Metro::all();

        foreach ($metros as $metro) {
            Metro::generateSlug($metro);
        }
        $this->info('End will be generated slug for metros');

        return 0;
    }
}
