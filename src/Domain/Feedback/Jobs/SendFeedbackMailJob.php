<?php

declare(strict_types=1);

namespace Domain\Feedback\Jobs;

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
        Mail::to('Go@Gorooms.ru')->send(new FeedbackSentMail($this->feedbackData));
    }
}
