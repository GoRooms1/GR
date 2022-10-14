<?php

namespace App\Listeners;

use App\Events\FormSend;
use App\Mail\FormSendMail;
use App\Settings;
use Illuminate\Support\Facades\Mail;

class FormSendMailEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(FormSend $event): void
    {
        $email = Settings::option('notify') ?? Settings::option('notify', 'gorooms@walfter.ru');
        Mail::to(config('app.admin_email', $email))
            ->send(new FormSendMail($event->form));
    }
}
