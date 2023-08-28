<?php

namespace Domain\AdBanner\Mails;

use Domain\AdBanner\DataTransferObjects\AdBannerData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdBannerEndMail extends Mailable
{
    use Queueable, SerializesModels;
   
    public AdBannerData $data;
    public int $days;
   
    public function __construct(AdBannerData $data, int $days)
    {
        $this->data = $data;
        $this->days = $days;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): AdBannerEndMail
    {
        return $this->subject('Сервис GoRooms – завершение показа рекламного баннера')
            ->view('emails.ad-banner-end');
    }
}
