<?php

namespace Tests\Unit;

use App\Services\GoogleOAuthAccessToken;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class GoogleOAuthAccessTokenTest extends TestCase
{
    public function test_it_refreshes_a_google_access_token(): void
    {
        config()->set('services.google.client_id', 'client-id');
        config()->set('services.google.client_secret', 'client-secret');
        config()->set('services.google.refresh_token', 'refresh-token');

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response([
                'access_token' => 'access-token',
                'expires_in' => 3599,
                'token_type' => 'Bearer',
            ]),
        ]);

        $token = app(GoogleOAuthAccessToken::class)->get();

        $this->assertSame('access-token', $token);
        Http::assertSent(fn ($request) => $request->url() === 'https://oauth2.googleapis.com/token'
            && $request['client_id'] === 'client-id'
            && $request['client_secret'] === 'client-secret'
            && $request['refresh_token'] === 'refresh-token'
            && $request['grant_type'] === 'refresh_token');
    }

    public function test_it_fails_when_google_rejects_the_refresh_request(): void
    {
        config()->set('services.google.client_id', 'client-id');
        config()->set('services.google.client_secret', 'client-secret');
        config()->set('services.google.refresh_token', 'refresh-token');

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response(['error' => 'invalid_grant'], 400),
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unable to refresh Google OAuth access token.');

        app(GoogleOAuthAccessToken::class)->get();
    }

    public function test_it_fails_when_google_omits_the_access_token(): void
    {
        config()->set('services.google.client_id', 'client-id');
        config()->set('services.google.client_secret', 'client-secret');
        config()->set('services.google.refresh_token', 'refresh-token');

        Http::fake([
            'https://oauth2.googleapis.com/token' => Http::response(['token_type' => 'Bearer']),
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Google OAuth token response did not include an access token.');

        app(GoogleOAuthAccessToken::class)->get();
    }
}
