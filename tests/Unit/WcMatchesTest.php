<?php

namespace Tests\Unit;

use App\Data\WcMatches;
use App\Http\Controllers\LeagueController;
use ReflectionMethod;
use Tests\TestCase;

class WcMatchesTest extends TestCase
{
    public function test_it_contains_all_world_cup_matches(): void
    {
        $this->assertCount(104, WcMatches::all());
    }

    public function test_match_ids_are_unique(): void
    {
        $ids = array_column(WcMatches::all(), 'id');

        $this->assertCount(104, array_unique($ids));
    }

    public function test_match_order_follows_the_stable_fixture_order(): void
    {
        $this->assertSame(
            array_column(WcMatches::STABLE_FIXTURES, 'id'),
            array_column(WcMatches::all(), 'id')
        );
    }

    public function test_match_rows_keep_the_stable_fixture_orientation(): void
    {
        foreach (WcMatches::all() as $match) {
            $fixture = WcMatches::STABLE_FIXTURES[$match['matchNumber']];

            $this->assertSame($fixture['id'], $match['id']);
            $this->assertSame($fixture['group'], $match['group']);
            $this->assertSame($fixture['teamA'], $match['teamA']);
            $this->assertSame($fixture['teamB'], $match['teamB']);
        }
    }

    public function test_f2_keeps_the_existing_prediction_orientation(): void
    {
        $match = WcMatches::find('F2');

        $this->assertNotNull($match);
        $this->assertSame('Tunisia', $match['teamA']);
        $this->assertSame(1, $match['teamAGoals']);
        $this->assertSame(5, $match['teamBGoals']);
        $this->assertSame('Sweden', $match['teamB']);
    }

    public function test_stage_display_order_uses_the_match_schedule(): void
    {
        $controller = new LeagueController;
        $method = new ReflectionMethod($controller, 'orderedMatchesForStage');
        $method->setAccessible(true);

        $groupC = array_values(array_filter(WcMatches::all(), fn (array $match): bool => $match['group'] === 'Group C'));
        $groupD = array_values(array_filter(WcMatches::all(), fn (array $match): bool => $match['group'] === 'Group D'));
        $groupH = array_values(array_filter(WcMatches::all(), fn (array $match): bool => $match['group'] === 'Group H'));

        $this->assertSame(
            ['C1', 'C2', 'C3', 'C4', 'C5', 'C6'],
            array_column($method->invoke($controller, $groupC), 'id')
        );
        $this->assertSame(
            ['D1', 'D2', 'D4', 'D3', 'D5', 'D6'],
            array_column($method->invoke($controller, $groupD), 'id')
        );
        $this->assertSame(
            ['H1', 'H2', 'H4', 'H3', 'H5', 'H6'],
            array_column($method->invoke($controller, $groupH), 'id')
        );
    }


    public function test_scores_are_entered_as_complete_pairs(): void
    {
        foreach (WcMatches::all() as $match) {
            $bothPending = $match['teamAGoals'] === null && $match['teamBGoals'] === null;
            $bothScored = is_int($match['teamAGoals']) && is_int($match['teamBGoals']);

            $this->assertTrue($bothPending || $bothScored, "Match {$match['id']} must have both scores filled or both null.");
        }
    }
}
