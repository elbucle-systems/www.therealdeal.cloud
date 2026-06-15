<?php

namespace Tests\Unit;

use App\Services\FifaWorldCupResultNormalizer;
use PHPUnit\Framework\TestCase;

class FifaWorldCupResultNormalizerTest extends TestCase
{
    public function test_it_normalizes_fifa_world_cup_matches(): void
    {
        $matches = (new FifaWorldCupResultNormalizer)->normalize([
            [
                'IdMatch' => '400021443',
                'MatchNumber' => 1,
                'Date' => '2026-06-11T19:00:00Z',
                'GroupName' => [
                    ['Locale' => 'en-GB', 'Description' => 'Group A'],
                ],
                'Home' => [
                    'Score' => 2,
                    'ShortClubName' => 'Mexico',
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Mexico'],
                    ],
                ],
                'Away' => [
                    'Score' => 0,
                    'ShortClubName' => 'South Africa',
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'South Africa'],
                    ],
                ],
                'HomeTeamScore' => 2,
                'AwayTeamScore' => 0,
                'MatchStatus' => 0,
            ],
        ]);

        $this->assertCount(1, $matches);
        $this->assertSame('A1', $matches[0]['id']);
        $this->assertSame('Group A', $matches[0]['group']);
        $this->assertSame('2026-06-11T19:00:00Z', $matches[0]['date']);
        $this->assertSame(1, $matches[0]['matchNumber']);
        $this->assertSame('400021443', $matches[0]['fifa_match_id']);
        $this->assertSame('Mexico', $matches[0]['teamA']);
        $this->assertSame('South Africa', $matches[0]['teamB']);
        $this->assertSame(2, $matches[0]['teamAGoals']);
        $this->assertSame(0, $matches[0]['teamBGoals']);
    }

    public function test_it_maps_common_fifa_team_names_to_local_names(): void
    {
        $matches = (new FifaWorldCupResultNormalizer)->normalize([
            [
                'IdMatch' => '400021441',
                'MatchNumber' => 2,
                'Date' => '2026-06-12T02:00:00Z',
                'GroupName' => [
                    ['Locale' => 'en-GB', 'Description' => 'Group A'],
                ],
                'Home' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Korea Republic'],
                    ],
                ],
                'Away' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Czechia'],
                    ],
                ],
                'HomeTeamScore' => 2,
                'AwayTeamScore' => 1,
            ],
        ]);

        $this->assertCount(1, $matches);
        $this->assertSame('A2', $matches[0]['id']);
        $this->assertSame('South Korea', $matches[0]['teamA']);
        $this->assertSame('Czech Republic', $matches[0]['teamB']);
    }

    public function test_it_generates_knockout_ids_from_match_numbers(): void
    {
        $matches = (new FifaWorldCupResultNormalizer)->normalize([
            [
                'IdMatch' => '400021500',
                'MatchNumber' => 97,
                'Date' => '2026-07-09T20:00:00Z',
                'StageName' => [
                    ['Locale' => 'en-GB', 'Description' => 'Quarterfinals'],
                ],
                'PlaceHolderA' => 'Winner 89',
                'PlaceHolderB' => 'Winner 90',
                'Home' => [],
                'Away' => [],
            ],
        ]);

        $this->assertSame('QF1', $matches[0]['id']);
        $this->assertSame('Quarterfinals', $matches[0]['group']);
        $this->assertSame('Winner 89', $matches[0]['teamA']);
        $this->assertSame('Winner 90', $matches[0]['teamB']);
    }

    public function test_it_preserves_legacy_match_order_for_existing_predictions(): void
    {
        $matches = (new FifaWorldCupResultNormalizer)->normalize([
            [
                'IdMatch' => '400021453',
                'MatchNumber' => 5,
                'Date' => '2026-06-14T01:00:00Z',
                'GroupName' => [
                    ['Locale' => 'en-GB', 'Description' => 'Group C'],
                ],
                'Home' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Haiti'],
                    ],
                ],
                'Away' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Scotland'],
                    ],
                ],
            ],
            [
                'IdMatch' => '400021456',
                'MatchNumber' => 7,
                'Date' => '2026-06-13T22:00:00Z',
                'GroupName' => [
                    ['Locale' => 'en-GB', 'Description' => 'Group C'],
                ],
                'Home' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Brazil'],
                    ],
                ],
                'Away' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Morocco'],
                    ],
                ],
            ],
        ]);

        $this->assertSame(['C1', 'C2'], array_column($matches, 'id'));
    }

    public function test_it_keeps_stable_team_orientation_when_fifa_swaps_home_and_away(): void
    {
        $matches = (new FifaWorldCupResultNormalizer)->normalize([
            [
                'IdMatch' => '400021456',
                'MatchNumber' => 7,
                'Date' => '2026-06-13T22:00:00Z',
                'GroupName' => [
                    ['Locale' => 'en-GB', 'Description' => 'Group C'],
                ],
                'Home' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Morocco'],
                    ],
                ],
                'Away' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Brazil'],
                    ],
                ],
                'HomeTeamScore' => 0,
                'AwayTeamScore' => 2,
            ],
        ]);

        $this->assertSame('C1', $matches[0]['id']);
        $this->assertSame('Brazil', $matches[0]['teamA']);
        $this->assertSame('Morocco', $matches[0]['teamB']);
        $this->assertSame(2, $matches[0]['teamAGoals']);
        $this->assertSame(0, $matches[0]['teamBGoals']);
        $this->assertSame('swapped', $matches[0]['fifa_orientation']);
    }

    public function test_it_refuses_scores_when_fifa_teams_do_not_match_stable_fixture(): void
    {
        $matches = (new FifaWorldCupResultNormalizer)->normalize([
            [
                'IdMatch' => '400021456',
                'MatchNumber' => 7,
                'Date' => '2026-06-13T22:00:00Z',
                'GroupName' => [
                    ['Locale' => 'en-GB', 'Description' => 'Group C'],
                ],
                'Home' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Brazil'],
                    ],
                ],
                'Away' => [
                    'TeamName' => [
                        ['Locale' => 'en-GB', 'Description' => 'Scotland'],
                    ],
                ],
                'HomeTeamScore' => 2,
                'AwayTeamScore' => 1,
            ],
        ]);

        $this->assertSame('C1', $matches[0]['id']);
        $this->assertSame('Brazil', $matches[0]['teamA']);
        $this->assertSame('Morocco', $matches[0]['teamB']);
        $this->assertNull($matches[0]['teamAGoals']);
        $this->assertNull($matches[0]['teamBGoals']);
        $this->assertSame('mismatch', $matches[0]['fifa_orientation']);
    }
}
