<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $verificationUrl) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complete Your Registration – The Real Deal',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.registration',
        );
    }
}
