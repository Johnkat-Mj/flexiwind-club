<?php

namespace App\Mail;

use App\Models\LoginLink;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $url,
        public bool $isNewAccount = false,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->isNewAccount
                ? 'Create your Flexiwind account'
                : 'Your Flexiwind sign-in link',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.magic-link',
            with: [
                'minutes' => LoginLink::TTL_MINUTES,
            ],
        );
    }
}
