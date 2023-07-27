<?php

namespace Domain\Bot\Commands;

use Domain\Bot\Actions\SubscribeAction;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class SubCommand extends Command
{
    protected string $name = 'sub';
    protected string $pattern = '{hotel: \d+} {phone: (?:\+7|7)\d{10}} {pass}';
    protected string $description = 'Подписаться на уведомления отеля';

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        
        $hotel_id = intval($this->argument('hotel'));
        $phone = trim(strval($this->argument('phone')));
        $pass = trim(strval($this->argument('pass')));
        $telegram_id = intval($this->getUpdate()->getMessage()->from->id);

        if (!$hotel_id && !$phone && !$pass) {
            $this->replyWithMessage([
                'text' => "Пожалуйста, укажите (без пробелов!) id отеля, номер телефона и пароль. Напр.: /sub 987 +79001231212 pass1234",
                'parse_mode' => 'html',
            ]);

            return;
        }

        if (!$hotel_id) {
            $this->replyWithMessage([
                'text' => "Пожалуйста, укажите id отеля! Напр.: /sub <b>987</b> +79001231212 pass1234",
                'parse_mode' => 'html',
            ]);

            return;
        }

        if (!$phone) {
            $this->replyWithMessage([
                'text' => "Пожалуйста, укажите номер телефона! Напр.: /sub 987 <b>+79001231212</b> pass1234",
                'parse_mode' => 'html',
            ]);

            return;
        }

        if (!$pass) {
            $this->replyWithMessage([
                'text' => "Пожалуйста, укажите пароль! Напр.: /sub 987 +79001231212 <b>pass1234</b>",
                'parse_mode' => 'html',
            ]);

            return;
        }        

        $this->replyWithMessage([
            'text' => SubscribeAction::run($hotel_id, $phone, $pass, $telegram_id),
            'parse_mode' => 'html',
        ]);        
    }
}