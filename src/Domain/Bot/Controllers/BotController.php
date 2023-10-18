<?php

namespace Domain\Bot\Controllers;

use Domain\Bot\Actions\HandleBotCallbackAction;
use Domain\Bot\Actions\HandleBotUpdateAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Parent\Controllers\Controller;
use Str;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{   
    public function index(Request $request): string
    { 
        $update = Telegram::getWebhookUpdate();

        //If update contains command - remove last actions data with chat
        $hasCommand = $update->hasCommand();        
        
        if ($hasCommand) {
            try {
                $keys = Redis::keys('bot:'.$update->getMessage()->from->id.'*');
                \Log::info($keys);
                foreach ($keys as $key) {
                    Redis::del(str_replace(config('database.redis.options.prefix'), '', $key));
                }                
            } catch (\Exception $e) {
                \Log::info($e);
            }           
        }
        
        //Handle Telegramm commands
        Telegram::commandsHandler(true);

        //Handle updates        
        if ($update->isType('callback_query')) {
            HandleBotCallbackAction::run($update);
        }
        else if ($update->isType('message') && !$hasCommand){
            HandleBotUpdateAction::run($update);
        }

        return 'ok';
    }
}
