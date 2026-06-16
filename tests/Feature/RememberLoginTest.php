<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RememberLoginTest extends TestCase
{
    private function migrateDatabaseOrSkip(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is required for database-backed login feature tests.');
        }

        $this->artisan('migrate:fresh');
    }

    public function test_login_with_remember_me_sets_recaller_cookie(): void
    {
        $this->migrateDatabaseOrSkip();

        $user = User::factory()->create([
            'email' => 'remember@example.com',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $response->assertRedirect('/');
        $response->assertCookie(Auth::guard()->getRecallerName());
    }

    public function test_login_without_remember_me_does_not_set_recaller_cookie(): void
    {
        $this->migrateDatabaseOrSkip();

        $user = User::factory()->create([
            'email' => 'session-only@example.com',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $response->assertCookieMissing(Auth::guard()->getRecallerName());
    }
}
