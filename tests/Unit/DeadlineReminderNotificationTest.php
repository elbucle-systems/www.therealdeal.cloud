<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\DeadlineReminderNotification;
use Tests\TestCase;

class DeadlineReminderNotificationTest extends TestCase
{
    public function test_it_stores_stage_and_action_url_for_prediction_group(): void
    {
        $notification = new DeadlineReminderNotification([
            'key' => 'league:42:group:Group B:2026-06-11T19:00:00Z',
            'type' => 'group',
            'league_id' => 42,
            'league_name' => 'Office Pool',
            'label' => 'Group B',
            'stage' => 'Group B',
            'deadline' => '2026-06-11T19:00:00Z',
            'missing_count' => 3,
            'match_ids' => ['B1', 'B2', 'B3'],
            'match_numbers' => [3, 8, 26],
        ]);

        $payload = $notification->toArray(new User(['username' => 'player_one']));

        $this->assertSame('Group B', $payload['stage']);
        $this->assertSame(route('leagues.matches', [42, 'stage' => 'Group B']), $payload['action_url']);
        $this->assertSame(__('app.notifications.make_predictions'), $payload['action_label']);
    }

    public function test_it_falls_back_to_matches_url_when_stage_is_missing(): void
    {
        $notification = new DeadlineReminderNotification([
            'key' => 'league:42:legacy',
            'type' => 'match',
            'league_id' => 42,
            'league_name' => 'Office Pool',
            'label' => 'Mexico vs South Africa',
            'deadline' => '2026-06-11T19:00:00Z',
            'missing_count' => 1,
            'match_ids' => ['A1'],
            'match_numbers' => [1],
        ]);

        $payload = $notification->toArray(new User(['username' => 'player_one']));

        $this->assertNull($payload['stage']);
        $this->assertSame(route('leagues.matches', 42), $payload['action_url']);
    }
}
