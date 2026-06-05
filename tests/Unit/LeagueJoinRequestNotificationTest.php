<?php

namespace Tests\Unit;

use App\Models\League;
use App\Models\User;
use App\Notifications\LeagueJoinRequestNotification;
use Tests\TestCase;

class LeagueJoinRequestNotificationTest extends TestCase
{
    public function test_it_stores_join_request_details_for_the_manager(): void
    {
        $league = new League([
            'name' => 'Office Pool',
        ]);
        $league->id = 42;

        $requestingUser = new User([
            'username' => 'player_one',
        ]);
        $requestingUser->id = 7;

        $notification = new LeagueJoinRequestNotification($league, $requestingUser);

        $payload = $notification->toArray(new User(['username' => 'manager']));

        $this->assertSame('league_join_request', $payload['event']);
        $this->assertSame(42, $payload['league_id']);
        $this->assertSame('Office Pool', $payload['league_name']);
        $this->assertSame(7, $payload['requesting_user_id']);
        $this->assertSame('player_one', $payload['requesting_username']);
        $this->assertSame(route('leagues.members', 42), $payload['action_url']);
    }
}
