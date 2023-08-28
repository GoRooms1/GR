<?php

namespace Domain\AdBanner\Jobs;

use Domain\AdBanner\DataTransferObjects\AdBannerData;
use Domain\AdBanner\Mails\AdBannerEndMail;
use Domain\AdBanner\Models\AdBanner;
use Domain\Bot\Actions\BotMessageTeplatesDispatchAction;
use Domain\Bot\Actions\GetSubscribedUsersOnHotelAction;
use Domain\Bot\DataTransferObjects\BotMessageData;
use Domain\Bot\Jobs\BotNotificationJob;
use Domain\Room\Actions\GenerateBookingBotNotificationTextAction;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Mails\RoomBookingMail;
use Domain\Room\Models\Room;
use Domain\Settings\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AdBanenrEndNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected AdBannerData $data;
    protected int $days;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdBannerData $data, int $days)
    {
        $this->data = $data;
        $this->days = $days;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      Mail::to($this->data->email)
        ->send(new AdBannerEndMail($this->data, $this->days));
    }
}
