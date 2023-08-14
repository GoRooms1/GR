<?php

namespace Domain\Bot\Commands;

use Domain\Bot\DataTransferObjects\SubscribeData;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class SubCommand extends Command
{
    protected string $name = '1'; 
    protected string $description = 'Подписаться на уведомления нового отеля';

    public function handle()
    {
        $telegram_id = intval($this->getUpdate()->getMessage()->from->id);

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => "Пожалуйста, укажите ID отеля :".PHP_EOL."Вы можете увидеть его в шапке Вашего отеля в ЛК GoRooms.",            
        ]);

        Redis::set('bot:'.$telegram_id.':sub', (new SubscribeData(null, null, null))->toJson());
    }
}