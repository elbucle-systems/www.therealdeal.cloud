<?php

namespace Tests\Unit;

use App\Services\StandingsCalculator;
use PHPUnit\Framework\TestCase;

class StandingsCalculatorTest extends TestCase
{
    public function test_competition_ranks_share_numbers_for_equal_scores(): void
    {
        $rows = [
            ['username' => 'ana', 'total_points' => 9],
            ['username' => 'ben', 'total_points' => 7],
            ['username' => 'cam', 'total_points' => 7],
            ['username' => 'dia', 'total_points' => 3],
        ];

        $ranked = (new StandingsCalculator)->withCompetitionRanks(
            $rows,
            fn (array $row): int => $row['total_points']
        );

        $this->assertSame([1, 2, 2, 4], array_column($ranked, 'rank'));
    }

    public function test_team_standings_compute_record_goals_and_points(): void
    {
        $matches = [
            [
                'id' => 'A1',
                'teamA' => 'Mexico',
                'teamB' => 'South Africa',
                'teamAGoals' => 2,
                'teamBGoals' => 1,
            ],
            [
                'id' => 'A2',
                'teamA' => 'South Korea',
                'teamB' => 'Czech Republic',
                'teamAGoals' => 0,
                'teamBGoals' => 0,
            ],
        ];

        $standings = (new StandingsCalculator)->teamStandings($matches);

        $this->assertSame('Mexico', $standings[0]['team']);
        $this->assertSame(1, $standings[0]['played']);
        $this->assertSame(1, $standings[0]['wins']);
        $this->assertSame(0, $standings[0]['draws']);
        $this->assertSame(0, $standings[0]['losses']);
        $this->assertSame(2, $standings[0]['goals_for']);
        $this->assertSame(1, $standings[0]['goals_against']);
        $this->assertSame(1, $standings[0]['goal_difference']);
        $this->assertSame(3, $standings[0]['points']);

        $this->assertSame('Czech Republic', $standings[1]['team']);
        $this->assertSame(1, $standings[1]['points']);
        $this->assertSame('South Korea', $standings[2]['team']);
        $this->assertSame(1, $standings[2]['points']);
    }

    public function test_team_standings_share_rank_when_ranking_stats_are_equal(): void
    {
        $matches = [
            [
                'id' => 'A1',
                'teamA' => 'Mexico',
                'teamB' => 'South Africa',
                'teamAGoals' => 1,
                'teamBGoals' => 1,
            ],
            [
                'id' => 'A2',
                'teamA' => 'South Korea',
                'teamB' => 'Czech Republic',
                'teamAGoals' => 1,
                'teamBGoals' => 1,
            ],
        ];

        $standings = (new StandingsCalculator)->teamStandings($matches);

        $this->assertSame([1, 1, 1, 1], array_column($standings, 'rank'));
    }

    public function test_team_standings_can_use_predictions_instead_of_real_scores(): void
    {
        $matches = [
            [
                'id' => 'A1',
                'teamA' => 'Mexico',
                'teamB' => 'South Africa',
                'teamAGoals' => null,
                'teamBGoals' => null,
            ],
        ];

        $standings = (new StandingsCalculator)->teamStandings($matches, [
            'A1' => [
                'predicted_score_a' => 0,
                'predicted_score_b' => 2,
            ],
        ]);

        $this->assertSame('South Africa', $standings[0]['team']);
        $this->assertSame(3, $standings[0]['points']);
    }

    public function test_prediction_points_awards_exact_score_points(): void
    {
        $match = [
            'teamAGoals' => 2,
            'teamBGoals' => 1,
        ];

        $points = (new StandingsCalculator)->predictionPoints($match, 2, 1, 5, 2);

        $this->assertSame(5, $points);
    }

    public function test_prediction_points_awards_correct_result_points(): void
    {
        $match = [
            'teamAGoals' => 2,
            'teamBGoals' => 1,
        ];

        $points = (new StandingsCalculator)->predictionPoints($match, 3, 0, 5, 2);

        $this->assertSame(2, $points);
    }

    public function test_prediction_points_returns_zero_for_incorrect_result(): void
    {
        $match = [
            'teamAGoals' => 2,
            'teamBGoals' => 1,
        ];

        $points = (new StandingsCalculator)->predictionPoints($match, 0, 1, 5, 2);

        $this->assertSame(0, $points);
    }

    public function test_prediction_points_returns_null_before_real_score_exists(): void
    {
        $match = [
            'teamAGoals' => null,
            'teamBGoals' => null,
        ];

        $points = (new StandingsCalculator)->predictionPoints($match, 2, 1, 5, 2);

        $this->assertNull($points);
    }
}
