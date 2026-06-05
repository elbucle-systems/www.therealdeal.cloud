<?php

namespace Tests\Feature;

use App\Mail\PasswordResetMail;
use App\Mail\RegistrationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthMailTest extends TestCase
{
    private function migrateDatabaseOrSkip(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is required for database-backed auth mail feature tests.');
        }

        $this->artisan('migrate:fresh');
    }

    public function test_registration_request_sends_registration_mail(): void
    {
        $this->migrateDatabaseOrSkip();

        Mail::fake();

        $response = $this->post('/register', [
            'email' => 'new-user@example.com',
        ]);

        $response->assertSessionHas('success');

        Mail::assertSent(RegistrationMail::class, fn (RegistrationMail $mail) => $mail->hasTo('new-user@example.com'));
    }

    public function test_forgot_password_sends_password_reset_mail_for_existing_user(): void
    {
        $this->migrateDatabaseOrSkip();

        Mail::fake();

        User::factory()->create([
            'email' => 'existing-user@example.com',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'existing-user@example.com',
        ]);

        $response->assertSessionHas('success');

        Mail::assertSent(PasswordResetMail::class, fn (PasswordResetMail $mail) => $mail->hasTo('existing-user@example.com'));
    }
}
