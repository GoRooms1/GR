<?php

declare(strict_types=1);

namespace Domain\Feedback\Jobs;

use Domain\Feedback\DataTransferObjects\FeedbackData;
use Domain\Feedback\Mail\FeedbackSentMail;
use Domain\Settings\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

final class SendFeedbackMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected FeedbackData $feedbackData
    ) {
    }

    public function handle(): void
    {
        $email = Settings::option('notify', 'gorooms@walfter.ru');       
        Mail::to($email)->send(new FeedbackSentMail($this->feedbackData));
    }
}
