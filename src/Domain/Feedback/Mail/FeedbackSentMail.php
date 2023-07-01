<?php

namespace Domain\Feedback\Mail;

use Domain\Feedback\DataTransferObjects\FeedbackData;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class FeedbackSentMail extends Mailable
{
    public function __construct(
        public FeedbackData $feedbackData
    ) {
    }
    
    public function content(): Content
    {
        return new Content(
            view: 'emails.feedback-sent'
        );
    }
}
