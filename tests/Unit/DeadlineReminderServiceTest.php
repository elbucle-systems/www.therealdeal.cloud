<?php

namespace Tests\Unit;

use App\Models\League;
use App\Models\User;
use App\Services\DeadlineReminderService;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class DeadlineReminderServiceTest extends TestCase
{
    private function migrateDatabaseOrSkip(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is required for database-backed deadline reminder service tests.');
        }

        $this->artisan('migrate:fresh');
    }

    public function test_grouped_deadline_reminders_include_the_group_stage(): void
    {
        $this->migrateDatabaseOrSkip();

        $user = User::factory()->create(['username' => 'player_one']);
        $manager = User::factory()->create(['username' => 'manager_one']);
        $league = League::create([
            'name' => 'Office Pool',
            'manager_id' => $manager->id,
            'points_per_score' => 3,
            'points_per_result' => 1,
            'predictions_visible_before_game' => false,
            'grouped_deadline' => true,
            'deadline_days' => 1,
            'unique_code' => 'ABC123',
        ]);
        $league->members()->create([
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        $deadlines = app(DeadlineReminderService::class)->upcomingForUser(
            $user,
            2,
            CarbonImmutable::parse('2026-06-11T18:00:00Z')
        );

        $deadline = collect($deadlines)->firstWhere('stage', 'Group B');

        $this->assertNotNull($deadline);
        $this->assertSame('Group B', $deadline['label']);
        $this->assertSame('Group B', $deadline['stage']);
    }

    public function test_per_match_deadline_reminders_include_the_match_group_stage(): void
    {
        $this->migrateDatabaseOrSkip();

        $user = User::factory()->create(['username' => 'player_two']);
        $manager = User::factory()->create(['username' => 'manager_two']);
        $league = League::create([
            'name' => 'Friends Pool',
            'manager_id' => $manager->id,
            'points_per_score' => 3,
            'points_per_result' => 1,
            'predictions_visible_before_game' => false,
            'grouped_deadline' => false,
            'deadline_days' => 0,
            'unique_code' => 'DEF456',
        ]);
        $league->members()->create([
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        $deadlines = app(DeadlineReminderService::class)->upcomingForUser(
            $user,
            2,
            CarbonImmutable::parse('2026-06-11T18:00:00Z')
        );

        $deadline = collect($deadlines)->firstWhere('match_ids', ['A1']);

        $this->assertNotNull($deadline);
        $this->assertSame('Mexico vs South Africa', $deadline['label']);
        $this->assertSame('Group A', $deadline['stage']);
    }
}
