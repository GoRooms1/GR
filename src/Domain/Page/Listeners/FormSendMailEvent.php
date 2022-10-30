<?php

declare(strict_types=1);

namespace Domain\Page\Listeners;

use App\Events\FormSend;
use App\Mail\FormSendMail;
use App\Settings;
use Illuminate\Support\Facades\Mail;

final class FormSendMailEvent
{
    public function handle(FormSend $event): void
    {
        $email = Settings::option('notify') ?? Settings::option('notify', 'gorooms@walfter.ru');
        Mail::to(config('app.admin_email', $email))
            ->send(new FormSendMail($event->form));
    }
}
