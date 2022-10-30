<?php

declare(strict_types=1);

namespace Domain\Feedback\Jobs;

use App\Settings;
use Domain\Feedback\DataTransferObjects\FeedbackData;
use Domain\Feedback\Mail\FeedbackSentMail;
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
        $email = Settings::option('notify') ?? Settings::option('notify', 'gorooms@walfter.ru');
        Mail::to(config('app.admin_email', $email))->send(new FeedbackSentMail($this->feedbackData));
    }
}
