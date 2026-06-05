<?php

namespace App\Providers;

use App\Services\GoogleOAuthAccessToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mail::extend('gmail_oauth', function (array $config = []) {
            $host = $config['host'] ?? 'smtp.gmail.com';
            $port = (int) ($config['port'] ?? 587);
            $username = $config['username'] ?? config('mail.from.address');
            $tls = $config['tls'] ?? $port === 465;

            $transport = new EsmtpTransport($host, $port, $tls);
            $transport->setUsername((string) $username);
            $transport->setPassword(app(GoogleOAuthAccessToken::class)->get());

            return $transport;
        });

        // Developer time-travel: set TEST_NOW=2026-07-10T12:00:00 in .env to fake today's date.
        // Remove or leave blank to use real time.
        if (app()->isLocal() && ($testNow = env('TEST_NOW'))) {
            Carbon::setTestNow(Carbon::parse($testNow));
        }
    }
}
