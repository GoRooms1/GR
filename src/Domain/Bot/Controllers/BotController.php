<?php

namespace Domain\Bot\Controllers;

use Illuminate\Http\Request;
use Parent\Controllers\Controller;
use Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{   
    public function index(Request $request): string
    { 
        //Handle Telegramm commands
        $update = Telegram::commandsHandler(true);        

        //Handle callbacks
        $commands = [ 'unsub' ];
        if ($update->isType('callback_query')) {
            $query = $update->getCallbackQuery();
            $data = $query->getData();
            $start = strpos($data, ' ');

            $command = ($start !== false) ? substr($data, 0, $start) : substr($data, 0);
            $params = ($start !== false) ? substr($data, $start + 1) : '';
                       
            if (in_array($command, $commands)) {
                $update->put('message', collect([
                    'text' =>  Str::start($command, '/').' '.$params,
                    'from' => $query->getMessage()->getFrom(),
                    'chat' => $query->getMessage()->getChat()
                ]));                
               Telegram::triggerCommand($command, $update);
            }
        }

        return 'ok';
    }
}
