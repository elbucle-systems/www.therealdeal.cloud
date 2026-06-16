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

    public function test_known_scores_are_seeded(): void
    {
        $scores = collect(WcMatches::all())
            ->filter(fn (array $match): bool => $match['teamAGoals'] !== null && $match['teamBGoals'] !== null)
            ->mapWithKeys(fn (array $match): array => [
                $match['id'] => [$match['teamAGoals'], $match['teamBGoals']],
            ])
            ->all();

        $this->assertSame([
            'A1' => [2, 0],
            'A2' => [2, 1],
            'B1' => [1, 1],
            'D1' => [4, 1],
            'C2' => [0, 1],
            'D2' => [2, 0],
            'C1' => [1, 1],
            'B2' => [1, 1],
            'E2' => [1, 0],
            'E1' => [7, 1],
            'F1' => [2, 2],
            'F2' => [1, 5],
        ], $scores);
    }
}
