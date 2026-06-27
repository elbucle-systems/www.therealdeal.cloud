<?php

namespace Tests\Unit;

use App\Data\WcMatches;
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

    public function test_match_order_uses_the_match_schedule(): void
    {
        $matches = WcMatches::all();
        $sorted = $matches;

        usort($sorted, fn (array $a, array $b): int => strcmp($a['date'], $b['date'])
            ?: ($a['matchNumber'] <=> $b['matchNumber']));

        $this->assertSame(array_column($sorted, 'id'), array_column($matches, 'id'));
    }

    public function test_group_stage_filtering_keeps_the_natural_schedule_order(): void
    {
        $byGroup = fn (string $group): array => array_column(
            array_values(array_filter(WcMatches::all(), fn (array $match): bool => $match['group'] === $group)),
            'id'
        );

        $this->assertSame(['C1', 'C2', 'C3', 'C4', 'C5', 'C6'], $byGroup('Group C'));
        $this->assertSame(['D1', 'D2', 'D3', 'D4', 'D5', 'D6'], $byGroup('Group D'));
        $this->assertSame(['E1', 'E2', 'E3', 'E4', 'E5', 'E6'], $byGroup('Group E'));
        $this->assertSame(['H1', 'H2', 'H4', 'H3', 'H5', 'H6'], $byGroup('Group H'));
    }

    public function test_dates_match_fifa_schedule_for_corrected_rows(): void
    {
        $datesById = array_column(WcMatches::all(), 'date', 'id');

        $this->assertSame('2026-06-14T04:00:00Z', $datesById['D2']);
        $this->assertSame('2026-06-19T22:00:00Z', $datesById['C3']);
        $this->assertSame('2026-06-20T00:30:00Z', $datesById['C4']);
        $this->assertSame('2026-06-20T03:00:00Z', $datesById['D4']);
        $this->assertSame('2026-06-21T04:00:00Z', $datesById['F4']);
    }

    public function test_round_of_32_has_resolved_fifa_fixtures(): void
    {
        $matchesById = array_column(WcMatches::all(), null, 'id');

        $this->assertSame('South Africa', $matchesById['R32_1']['teamA']);
        $this->assertSame('Canada', $matchesById['R32_1']['teamB']);
        $this->assertSame('Brazil', $matchesById['R32_4']['teamA']);
        $this->assertSame('Japan', $matchesById['R32_4']['teamB']);
        $this->assertSame('United States', $matchesById['R32_9']['teamA']);
        $this->assertSame('Bosnia and Herzegovina', $matchesById['R32_9']['teamB']);
        $this->assertSame('Argentina', $matchesById['R32_14']['teamA']);
        $this->assertSame('Cape Verde', $matchesById['R32_14']['teamB']);
    }

    public function test_knockout_deadline_is_one_hour_before_the_round_starts(): void
    {
        $matchesById = array_column(WcMatches::all(), null, 'id');

        $this->assertSame(
            '2026-06-28T18:00:00Z',
            WcMatches::deadline($matchesById['R32_16'], 0)->toIso8601ZuluString()
        );

        $this->assertSame(
            '2026-07-04T16:00:00Z',
            WcMatches::deadline($matchesById['R16_1'], 0)->toIso8601ZuluString()
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
