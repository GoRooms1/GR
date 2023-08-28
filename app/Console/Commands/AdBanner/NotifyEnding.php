<?php

namespace App\Console\Commands\AdBanner;

use Carbon\Carbon;
use Domain\AdBanner\DataTransferObjects\AdBannerData;
use Domain\AdBanner\Jobs\AdBanenrEndNotifyJob;
use Domain\AdBanner\Models\AdBanner;
use Illuminate\Console\Command;

class NotifyEnding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ad-banner:notify-ending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify customers about the end of the display of advertising banners';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $adBanners = AdBanner::where('is_show_always', false)
            ->where('show_to', '<=', Carbon::now()->addDays(5)->format('Y-m-d'))
            ->get();
    
        foreach ($adBanners as $adBanner) {  
            $days = $adBanner->show_to->startOfDay()->diffInDays(Carbon::now()->startOfDay());
            $data = AdBannerData::fromModel($adBanner);
            AdBanenrEndNotifyJob::dispatch($data, $days);
            $this->info('Banner ends '.$adBanner->id.' '.$adBanner->name.', days left'.$days);
        }
    }
}
