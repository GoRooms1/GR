<?php

namespace Domain\Bot\Jobs;

use Domain\Bot\DataTransferObjects\BotMessageData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected BotMessageData $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BotMessageData $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Telegram::sendMessage($this->data->toArray());
    }
}
