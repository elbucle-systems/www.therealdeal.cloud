<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Tests\TestCase;

class GmailOAuthMailTransportTest extends TestCase
{
    public function test_gmail_oauth_mailer_can_build_a_symfony_smtp_transport(): void
    {
        config()->set('mail.default', 'gmail_oauth');
        config()->set('mail.from.address', 'sender@example.com');
        config()->set('mail.mailers.gmail_oauth', [
            'transport' => 'gmail_oauth',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => 'sender@example.com',
            'tls' => null,
        ]);
        config()->set('services.google.client_id', 'client-id');
        config()->set('services.google.client_secret', 'client-secret');
        config()->set('services.google.refresh_token', 'refresh-token');

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response(['access_token' => 'access-token']),
        ]);

        Mail::forgetMailers();

        $transport = Mail::mailer()->getSymfonyTransport();

        $this->assertInstanceOf(EsmtpTransport::class, $transport);
        $this->assertSame('smtp://smtp.gmail.com:587', (string) $transport);
        Http::assertSentCount(1);
    }

    public function test_gmail_oauth_mailer_uses_implicit_tls_on_port_465(): void
    {
        config()->set('mail.default', 'gmail_oauth');
        config()->set('mail.from.address', 'sender@example.com');
        config()->set('mail.mailers.gmail_oauth', [
            'transport' => 'gmail_oauth',
            'host' => 'smtp.gmail.com',
            'port' => 465,
            'username' => 'sender@example.com',
        ]);
        config()->set('services.google.client_id', 'client-id');
        config()->set('services.google.client_secret', 'client-secret');
        config()->set('services.google.refresh_token', 'refresh-token');

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response(['access_token' => 'access-token']),
        ]);

        Mail::forgetMailers();

        $transport = Mail::mailer()->getSymfonyTransport();

        $this->assertInstanceOf(EsmtpTransport::class, $transport);
        $this->assertSame('smtps://smtp.gmail.com', (string) $transport);
    }
}
