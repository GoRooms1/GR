<?php

namespace Domain\Bot\Commands;

use Domain\Bot\Actions\GetSubscribedHotelsAction;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class HotelsCommand extends Command
{
    protected string $name = '3';    
    protected string $description = 'Список отелей, на которые Вы подписаны';

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);  
        $telegram_id = intval($this->getUpdate()->getMessage()->from->id);

        $hotels = GetSubscribedHotelsAction::run($telegram_id);       

        if ($hotels->count() == 0) {
            $this->replyWithMessage([
                'text' => 'Нет подписок!',                
            ]);

            return;
        }

        $text = 'Вы подписаны на отели:'.PHP_EOL;
        $counter = 1;
        
        foreach ($hotels as $hotel) {
           $text .= sprintf('<b>%s) %s</b>'.PHP_EOL, $counter, $hotel->name);
           $counter++;
        }
        
        $this->replyWithMessage([
            'text' => $text,
            'parse_mode' => 'html',
        ]);
    }
}