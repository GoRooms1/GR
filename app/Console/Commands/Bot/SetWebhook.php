<?php

namespace App\Console\Commands\Bot;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:set-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Webhook URL for Telegram Bot';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $response = Telegram::setWebhook(['url' => config('telegram.bots.mybot.webhook_url')]);        
        $this->info($response == true ? 'Webhook is set' : 'Error');
    }
}
