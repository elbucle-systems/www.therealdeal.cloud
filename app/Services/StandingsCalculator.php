<?php

namespace App\Services;

final class StandingsCalculator
{
    /**
     * @param  array<int, array<string, mixed>>  $rows
     * @param  callable(array<string, mixed>): mixed  $rankSignature
     * @return array<int, array<string, mixed>>
     */
    public function withCompetitionRanks(array $rows, callable $rankSignature): array
    {
        $lastSignature = null;
        $rank = 0;

        foreach ($rows as $index => $row) {
            $signature = $rankSignature($row);

            if ($index === 0 || $signature !== $lastSignature) {
                $rank = $index + 1;
                $lastSignature = $signature;
            }

            $rows[$index]['rank'] = $rank;
        }

        return $rows;
    }

    /**
     * @param  array<int, array<string, mixed>>  $matches
     * @param  array<string, array{predicted_score_a: int, predicted_score_b: int}>|null  $predictionsByMatch
     * @return array<int, array<string, mixed>>
     */
    public function teamStandings(array $matches, ?array $predictionsByMatch = null): array
    {
        $standings = [];

        foreach ($matches as $match) {
            $this->ensureTeam($standings, $match['teamA']);
            $this->ensureTeam($standings, $match['teamB']);

            $scoreA = $predictionsByMatch === null
                ? $match['teamAGoals']
                : ($predictionsByMatch[$match['id']]['predicted_score_a'] ?? null);
            $scoreB = $predictionsByMatch === null
                ? $match['teamBGoals']
                : ($predictionsByMatch[$match['id']]['predicted_score_b'] ?? null);

            if ($scoreA === null || $scoreB === null) {
                continue;
            }

            $this->applyResult($standings, $match['teamA'], $match['teamB'], (int) $scoreA, (int) $scoreB);
        }

        $rows = array_values($standings);

        usort($rows, function (array $a, array $b): int {
            return ($b['points'] <=> $a['points'])
                ?: ($b['goal_difference'] <=> $a['goal_difference'])
                ?: ($b['goals_for'] <=> $a['goals_for'])
                ?: strcasecmp($a['team'], $b['team']);
        });

        return $this->withCompetitionRanks(
            $rows,
            fn (array $row): string => implode('|', [
                $row['points'],
                $row['goal_difference'],
                $row['goals_for'],
            ])
        );
    }

    /**
     * @param  array<string, array<string, mixed>>  $standings
     */
    private function ensureTeam(array &$standings, string $team): void
    {
        if (isset($standings[$team])) {
            return;
        }

        $standings[$team] = [
            'team' => $team,
            'played' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
            'goal_difference' => 0,
            'points' => 0,
        ];
    }

    /**
     * @param  array<string, array<string, mixed>>  $standings
     */
    private function applyResult(array &$standings, string $teamA, string $teamB, int $scoreA, int $scoreB): void
    {
        $standings[$teamA]['played']++;
        $standings[$teamB]['played']++;

        $standings[$teamA]['goals_for'] += $scoreA;
        $standings[$teamA]['goals_against'] += $scoreB;
        $standings[$teamB]['goals_for'] += $scoreB;
        $standings[$teamB]['goals_against'] += $scoreA;

        $standings[$teamA]['goal_difference'] = $standings[$teamA]['goals_for'] - $standings[$teamA]['goals_against'];
        $standings[$teamB]['goal_difference'] = $standings[$teamB]['goals_for'] - $standings[$teamB]['goals_against'];

        if ($scoreA > $scoreB) {
            $standings[$teamA]['wins']++;
            $standings[$teamB]['losses']++;
            $standings[$teamA]['points'] += 3;

            return;
        }

        if ($scoreA < $scoreB) {
            $standings[$teamB]['wins']++;
            $standings[$teamA]['losses']++;
            $standings[$teamB]['points'] += 3;

            return;
        }

        $standings[$teamA]['draws']++;
        $standings[$teamB]['draws']++;
        $standings[$teamA]['points']++;
        $standings[$teamB]['points']++;
    }
}
