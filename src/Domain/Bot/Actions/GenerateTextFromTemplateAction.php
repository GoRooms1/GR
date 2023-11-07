<?php

declare(strict_types=1);

namespace Domain\Bot\Actions;

use Domain\Bot\Models\BotMessageTemplate;
use Domain\Hotel\Models\Hotel;
use Lorisleiva\Actions\Action;

/**
 * @method static string run(BotMessageTemplate $template)
 */
final class GenerateTextFromTemplateAction extends Action
{
    public function handle(BotMessageTemplate $template): string
    {  
        $text = '';
        
        if (!empty($template->header)) {            
            $text .= '*'.$template->header.'*'.PHP_EOL;
            $text .= ''.PHP_EOL;
        }

        $body = $template->body;
        $text .= $body.PHP_EOL;
         
        $image = $template->getFirstMediaUrl('images');
        
        if(!empty($image)) {
            $text .= '['.($template->url ?? '..').']('.$image.')'.PHP_EOL;
        }

        if (!empty($template->url) && empty($image)) {
            $text .= ''.PHP_EOL;
            $text .= '['.$template->url.']('.$template->url.')'.PHP_EOL;
        }

        return $text;
    }
}
