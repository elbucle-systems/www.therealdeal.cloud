<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

class FifaWorldCupResultNormalizer
{
    /**
     * @param  array<int, array<string, mixed>>  $payloads
     * @return array<int, array<string, mixed>>
     */
    public function normalize(array $payloads): array
    {
        usort($payloads, fn (array $a, array $b): int => ((int) ($a['MatchNumber'] ?? 0)) <=> ((int) ($b['MatchNumber'] ?? 0)));

        $groupCounters = [];

        return collect($payloads)
            ->map(fn (array $payload): ?array => $this->normalizeMatch($payload, $groupCounters))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, int>  $groupCounters
     * @return array<string, mixed>|null
     */
    private function normalizeMatch(array $payload, array &$groupCounters): ?array
    {
        $matchNumber = isset($payload['MatchNumber']) ? (int) $payload['MatchNumber'] : null;
        $stage = $this->stage($payload, $matchNumber);
        $id = $this->matchId($matchNumber, $stage, $groupCounters);

        if ($matchNumber === null || $stage === null || $id === null || ! isset($payload['Date'])) {
            return null;
        }

        $homeTeam = $this->teamName($payload, 'Home', 'PlaceHolderA');
        $awayTeam = $this->teamName($payload, 'Away', 'PlaceHolderB');

        return [
            'id' => $id,
            'group' => $stage,
            'date' => CarbonImmutable::parse($payload['Date'])->utc()->toIso8601ZuluString(),
            'matchNumber' => $matchNumber,
            'teamA' => $homeTeam,
            'teamAGoals' => $this->score($payload['HomeTeamScore'] ?? $payload['Home']['Score'] ?? null),
            'teamBGoals' => $this->score($payload['AwayTeamScore'] ?? $payload['Away']['Score'] ?? null),
            'teamB' => $awayTeam,
            'fifa_match_id' => isset($payload['IdMatch']) ? (string) $payload['IdMatch'] : null,
            'fifa_status' => isset($payload['MatchStatus']) ? (string) $payload['MatchStatus'] : null,
        ];
    }

    private function stage(array $payload, ?int $matchNumber): ?string
    {
        $group = $this->localizedDescription($payload['GroupName'] ?? []);
        if ($group !== null) {
            return $group;
        }

        return match (true) {
            $matchNumber >= 73 && $matchNumber <= 88 => 'Round of 32',
            $matchNumber >= 89 && $matchNumber <= 96 => 'Round of 16',
            $matchNumber >= 97 && $matchNumber <= 100 => 'Quarterfinals',
            $matchNumber >= 101 && $matchNumber <= 102 => 'Semifinals',
            $matchNumber === 103 => 'Third Place',
            $matchNumber === 104 => 'Final',
            default => $this->localizedDescription($payload['StageName'] ?? []),
        };
    }

    /**
     * @param  array<string, int>  $groupCounters
     */
    private function matchId(?int $matchNumber, ?string $stage, array &$groupCounters): ?string
    {
        if ($matchNumber === null || $stage === null) {
            return null;
        }

        if (str_starts_with($stage, 'Group ')) {
            $letter = Str::after($stage, 'Group ');
            $groupCounters[$letter] = ($groupCounters[$letter] ?? 0) + 1;

            return "{$letter}{$groupCounters[$letter]}";
        }

        return match (true) {
            $matchNumber >= 73 && $matchNumber <= 88 => 'R32_'.($matchNumber - 72),
            $matchNumber >= 89 && $matchNumber <= 96 => 'R16_'.($matchNumber - 88),
            $matchNumber >= 97 && $matchNumber <= 100 => 'QF'.($matchNumber - 96),
            $matchNumber >= 101 && $matchNumber <= 102 => 'SF'.($matchNumber - 100),
            $matchNumber === 103 => 'TP1',
            $matchNumber === 104 => 'FINAL',
            default => null,
        };
    }

    private function teamName(array $payload, string $side, string $placeholderKey): string
    {
        $name = $this->localizedDescription($payload[$side]['TeamName'] ?? [])
            ?? ($payload[$side]['ShortClubName'] ?? null)
            ?? ($payload[$placeholderKey] ?? null)
            ?? 'TBD';

        return $this->displayTeamName((string) $name);
    }

    /**
     * @param  array<int, array<string, mixed>>  $values
     */
    private function localizedDescription(array $values): ?string
    {
        foreach ($values as $value) {
            if (($value['Locale'] ?? null) === 'en-GB' && isset($value['Description'])) {
                return $value['Description'];
            }
        }

        return $values[0]['Description'] ?? null;
    }

    private function score(mixed $score): ?int
    {
        return is_numeric($score) ? (int) $score : null;
    }

    private function displayTeamName(string $team): string
    {
        return match (Str::of($team)->lower()->toString()) {
            'korea republic' => 'South Korea',
            'czechia' => 'Czech Republic',
            'usa', 'united states of america' => 'United States',
            default => $team,
        };
    }
}
