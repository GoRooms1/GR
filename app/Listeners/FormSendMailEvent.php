<?php

namespace App\Listeners;

use App\Events\FormSend;
use App\Mail\FormSendMail;
use App\Settings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FormSend $event)
    {
        $email = Settings::option('notify') ?? Settings::option('notify', 'gorooms@walfter.ru');
        Mail::to(config('app.admin_email', $email))
            ->send(new FormSendMail($event->form));
    }
}
