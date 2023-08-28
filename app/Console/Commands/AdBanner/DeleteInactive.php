<?php

namespace App\Console\Commands\AdBanner;

use Carbon\Carbon;
use Domain\AdBanner\Models\AdBanner;
use Illuminate\Console\Command;

class DeleteInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad-banner:delete-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete inactive ad banners';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $adBanners = AdBanner::where('is_show_always', false)
            ->where('show_to', '<=', Carbon::now()->subMonth()->format('Y-m-d'))
            ->get();
        
        foreach ($adBanners as $adBanner) {
            $adBanner->delete();
            $this->info('Deleted Ad Banner '.$adBanner->id.' '.$adBanner->name);
        }
    }
}
