<?php

namespace Tests\Feature;

use App\Models\League;
use App\Models\MatchPrediction;
use App\Models\User;
use App\Services\ActiveLeagueResolver;
use Tests\TestCase;

class ActiveLeagueAccessTest extends TestCase
{
    private User $user;
    private League $inactiveLeague;
    private League $activeLeague;

    private function migrateDatabaseOrSkip(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('The pdo_sqlite extension is required for database-backed active league tests.');
        }

        $this->artisan('migrate:fresh');
    }

    private function seedLeagues(): void
    {
        $this->user = User::factory()->create(['username' => 'active_player']);
        $manager = User::factory()->create(['username' => 'manager']);
        $otherOne = User::factory()->create(['username' => 'other_one']);
        $otherTwo = User::factory()->create(['username' => 'other_two']);

        $this->inactiveLeague = League::create([
            'name' => 'Unused League',
            'manager_id' => $manager->id,
            'points_per_score' => 3,
            'points_per_result' => 1,
            'predictions_visible_before_game' => false,
            'grouped_deadline' => false,
            'deadline_days' => 0,
            'unique_code' => 'UNUSED',
        ]);

        $this->inactiveLeague->members()->create([
            'user_id' => $manager->id,
            'status' => 'approved',
        ]);

        $this->activeLeague = League::create([
            'name' => 'Active League',
            'manager_id' => $manager->id,
            'points_per_score' => 3,
            'points_per_result' => 1,
            'predictions_visible_before_game' => false,
            'grouped_deadline' => false,
            'deadline_days' => 0,
            'unique_code' => 'ACTIVE',
        ]);

        foreach ([$this->user, $otherOne, $otherTwo] as $member) {
            $this->activeLeague->members()->create([
                'user_id' => $member->id,
                'status' => 'approved',
            ]);
        }
    }

    public function test_active_league_resolver_selects_the_league_with_multiple_approved_members(): void
    {
        $this->migrateDatabaseOrSkip();
        $this->seedLeagues();

        $this->assertSame($this->activeLeague->id, app(ActiveLeagueResolver::class)->activeId());
    }

    public function test_league_index_and_inactive_league_redirect_to_the_active_league(): void
    {
        $this->migrateDatabaseOrSkip();
        $this->seedLeagues();

        $this->actingAs($this->user)
            ->get('/')
            ->assertRedirect(route('leagues.show', $this->activeLeague->id));

        $this->actingAs($this->user)
            ->get('/leagues')
            ->assertRedirect(route('leagues.show', $this->activeLeague->id));

        $this->actingAs($this->user)
            ->get(route('leagues.show', $this->inactiveLeague->id))
            ->assertRedirect(route('leagues.show', $this->activeLeague->id));
    }

    public function test_league_page_shows_group_and_knockout_standings(): void
    {
        $this->migrateDatabaseOrSkip();
        $this->seedLeagues();

        $this->actingAs($this->user)
            ->get(route('leagues.show', $this->activeLeague->id))
            ->assertOk()
            ->assertSee('GROUP STAGE STANDINGS')
            ->assertSee('KNOCKOUT STANDINGS');
    }

    public function test_disabled_league_creation_and_join_routes_redirect_to_active_league_entry(): void
    {
        $this->migrateDatabaseOrSkip();
        $this->seedLeagues();

        $this->actingAs($this->user)
            ->get('/leagues/create')
            ->assertRedirect('/leagues');

        $this->actingAs($this->user)
            ->get('/leagues/join')
            ->assertRedirect('/leagues');
    }

    public function test_prediction_api_only_accepts_the_active_league_and_preserves_score_a_b_columns(): void
    {
        $this->migrateDatabaseOrSkip();
        $this->seedLeagues();

        $this->actingAs($this->user)
            ->putJson("/api/leagues/{$this->inactiveLeague->id}/matches/FINAL/prediction", [
                'predicted_score_a' => 2,
                'predicted_score_b' => 1,
            ])
            ->assertNotFound();

        $this->actingAs($this->user)
            ->putJson("/api/leagues/{$this->activeLeague->id}/matches/FINAL/prediction", [
                'predicted_score_a' => 3,
                'predicted_score_b' => 2,
            ])
            ->assertOk();

        $prediction = MatchPrediction::where('league_id', $this->activeLeague->id)
            ->where('username', $this->user->username)
            ->where('match_id', 'FINAL')
            ->firstOrFail();

        $this->assertSame(3, $prediction->predicted_score_a);
        $this->assertSame(2, $prediction->predicted_score_b);
    }
}
