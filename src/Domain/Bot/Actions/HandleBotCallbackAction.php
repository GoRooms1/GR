<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use Lorisleiva\Actions\Action;
use Str;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

/**
 * @method static void run(Update|array $update)
 */
final class HandleBotCallbackAction extends Action
{
    const ALLOWED_COMMANDS = [ 'unsub' ];
    public function handle(Update|array $update)
    {  
        $query = $update->getCallbackQuery();
        $data = $query->getData();
        $start = strpos($data, ' ');

        $command = ($start !== false) ? substr($data, 0, $start) : substr($data, 0);
        $params = ($start !== false) ? substr($data, $start + 1) : '';
                    
        if (in_array($command, HandleBotCallbackAction::ALLOWED_COMMANDS)) {
            $update->put('message', collect([
                'text' =>  Str::start($command, '/').' '.$params,
                'from' => $query->getMessage()->getFrom(),
                'chat' => $query->getMessage()->getChat()
            ]));

            Telegram::triggerCommand($command, $update);
        }
    }
}
