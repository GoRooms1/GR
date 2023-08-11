<?php

namespace Domain\Bot\Commands;

use App\User;
use Arr;
use Domain\Bot\DataTransferObjects\SubscribeData;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Команда для начала работы с ботом';

    public function handle()
    {
        $telegram_id = intval($this->getUpdate()->getMessage()->from->id);

        $this->replyWithMessage([
            'text' => 'Добро пожаловать в бот GoRooms!',
        ]);

        $user = User::withoutGlobalScopes()->where('telegram_id', $telegram_id)->first();
        
        if (!$user) {
            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage([
                'text' => "Пожалуйста, укажите ID отеля :".PHP_EOL."Вы можете увидеть его в шапке Вашего отеля в ЛК GoRooms.",            
            ]);

            Redis::set('bot:'.$telegram_id.':sub', (new SubscribeData(null, null, null))->toJson());

            return;
        }

        $this->replyWithMessage([
            'text' => 'Список доступных команд:',
        ]);

        $commands = Arr::only($this->telegram->getCommandBus()->getCommands(), ['sub', 'unsub', 'hotels']);

        $text = '';
        foreach ($commands as $name => $handler) {
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(['text' => $text]);
    }
}