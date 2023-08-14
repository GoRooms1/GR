<?php

namespace Domain\Bot\Commands;

use Domain\Bot\Actions\GetSubscribedHotelsAction;
use Domain\Bot\Actions\UnSubscribeAction;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class UnsubCommand extends Command
{
    protected string $name = '2';
    protected string $pattern = '{hotel: \d+}';
    protected string $description = 'Отписаться от уведомлений';

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        
        $hotel_id = $this->argument('hotel');       
        $telegram_id = intval($this->getUpdate()->getMessage()->chat->id);
        
        if ($hotel_id) 
        {
            $text = UnSubscribeAction::run(intval($hotel_id), $telegram_id);
            $this->replyWithMessage([
                'text' => $text,
                'parse_mode' => 'html',       
            ]);

            return;
        }

        $hotels = GetSubscribedHotelsAction::run($telegram_id);
        $inlineLayout = [];

        foreach($hotels as $hotel) 
        {
            $inlineLayout[] = [
                Keyboard::inlineButton(['text' => $hotel->name, 'callback_data' => 'unsub '.$hotel->id]),
            ];
        }
        
        $reply_markup = Keyboard::make([
            'inline_keyboard' => $inlineLayout,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);       

        $this->replyWithMessage([
            'text' => 'Выберите отель',
            'reply_markup' => $reply_markup
        ]);
    }
}