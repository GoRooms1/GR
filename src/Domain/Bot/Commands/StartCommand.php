<?php

namespace Domain\Bot\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Команда для начала работы с ботом';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => 'Добро пожаловать в бот GoRooms!',
        ]);

        $this->replyWithMessage([
            'text' => 'Список доступных команд:',
        ]);

        $commands = $this->telegram->getCommandBus()->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(['text' => $text]);
    }
}