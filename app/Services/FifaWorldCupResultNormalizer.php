<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

class FifaWorldCupResultNormalizer
{
    private const STABLE_FIXTURES = [
        1 => ['id' => 'A1', 'group' => 'Group A', 'teamA' => 'Mexico', 'teamB' => 'South Africa'],
        2 => ['id' => 'A2', 'group' => 'Group A', 'teamA' => 'South Korea', 'teamB' => 'Czech Republic'],
        3 => ['id' => 'B1', 'group' => 'Group B', 'teamA' => 'Canada', 'teamB' => 'Bosnia and Herzegovina'],
        4 => ['id' => 'D1', 'group' => 'Group D', 'teamA' => 'United States', 'teamB' => 'Paraguay'],
        5 => ['id' => 'C2', 'group' => 'Group C', 'teamA' => 'Haiti', 'teamB' => 'Scotland'],
        6 => ['id' => 'D2', 'group' => 'Group D', 'teamA' => 'Australia', 'teamB' => 'Turkey'],
        7 => ['id' => 'C1', 'group' => 'Group C', 'teamA' => 'Brazil', 'teamB' => 'Morocco'],
        8 => ['id' => 'B2', 'group' => 'Group B', 'teamA' => 'Qatar', 'teamB' => 'Switzerland'],
        9 => ['id' => 'E2', 'group' => 'Group E', 'teamA' => 'Ivory Coast', 'teamB' => 'Ecuador'],
        10 => ['id' => 'E1', 'group' => 'Group E', 'teamA' => 'Germany', 'teamB' => 'Curacao'],
        11 => ['id' => 'F1', 'group' => 'Group F', 'teamA' => 'Netherlands', 'teamB' => 'Japan'],
        12 => ['id' => 'F2', 'group' => 'Group F', 'teamA' => 'Tunisia', 'teamB' => 'Sweden'],
        13 => ['id' => 'H2', 'group' => 'Group H', 'teamA' => 'Saudi Arabia', 'teamB' => 'Uruguay'],
        14 => ['id' => 'H1', 'group' => 'Group H', 'teamA' => 'Spain', 'teamB' => 'Cape Verde'],
        15 => ['id' => 'G2', 'group' => 'Group G', 'teamA' => 'Iran', 'teamB' => 'New Zealand'],
        16 => ['id' => 'G1', 'group' => 'Group G', 'teamA' => 'Belgium', 'teamB' => 'Egypt'],
        17 => ['id' => 'I1', 'group' => 'Group I', 'teamA' => 'France', 'teamB' => 'Senegal'],
        18 => ['id' => 'I2', 'group' => 'Group I', 'teamA' => 'Norway', 'teamB' => 'Iraq'],
        19 => ['id' => 'J1', 'group' => 'Group J', 'teamA' => 'Argentina', 'teamB' => 'Algeria'],
        20 => ['id' => 'J2', 'group' => 'Group J', 'teamA' => 'Austria', 'teamB' => 'Jordan'],
        21 => ['id' => 'L2', 'group' => 'Group L', 'teamA' => 'Ghana', 'teamB' => 'Panama'],
        22 => ['id' => 'L1', 'group' => 'Group L', 'teamA' => 'England', 'teamB' => 'Croatia'],
        23 => ['id' => 'K1', 'group' => 'Group K', 'teamA' => 'Portugal', 'teamB' => 'DR Congo'],
        24 => ['id' => 'K2', 'group' => 'Group K', 'teamA' => 'Uzbekistan', 'teamB' => 'Colombia'],
        25 => ['id' => 'A3', 'group' => 'Group A', 'teamA' => 'South Africa', 'teamB' => 'Czech Republic'],
        26 => ['id' => 'B3', 'group' => 'Group B', 'teamA' => 'Switzerland', 'teamB' => 'Bosnia and Herzegovina'],
        27 => ['id' => 'A4', 'group' => 'Group A', 'teamA' => 'Mexico', 'teamB' => 'South Korea'],
        28 => ['id' => 'B4', 'group' => 'Group B', 'teamA' => 'Canada', 'teamB' => 'Qatar'],
        29 => ['id' => 'C4', 'group' => 'Group C', 'teamA' => 'Brazil', 'teamB' => 'Haiti'],
        30 => ['id' => 'C3', 'group' => 'Group C', 'teamA' => 'Scotland', 'teamB' => 'Morocco'],
        31 => ['id' => 'D4', 'group' => 'Group D', 'teamA' => 'Paraguay', 'teamB' => 'Turkey'],
        32 => ['id' => 'D3', 'group' => 'Group D', 'teamA' => 'United States', 'teamB' => 'Australia'],
        33 => ['id' => 'E3', 'group' => 'Group E', 'teamA' => 'Germany', 'teamB' => 'Ivory Coast'],
        34 => ['id' => 'E4', 'group' => 'Group E', 'teamA' => 'Ecuador', 'teamB' => 'Curacao'],
        35 => ['id' => 'F3', 'group' => 'Group F', 'teamA' => 'Netherlands', 'teamB' => 'Sweden'],
        36 => ['id' => 'F4', 'group' => 'Group F', 'teamA' => 'Tunisia', 'teamB' => 'Japan'],
        37 => ['id' => 'G4', 'group' => 'Group G', 'teamA' => 'New Zealand', 'teamB' => 'Egypt'],
        38 => ['id' => 'G3', 'group' => 'Group G', 'teamA' => 'Belgium', 'teamB' => 'Iran'],
        39 => ['id' => 'H4', 'group' => 'Group H', 'teamA' => 'Spain', 'teamB' => 'Saudi Arabia'],
        40 => ['id' => 'H3', 'group' => 'Group H', 'teamA' => 'Uruguay', 'teamB' => 'Cape Verde'],
        41 => ['id' => 'I3', 'group' => 'Group I', 'teamA' => 'France', 'teamB' => 'Iraq'],
        42 => ['id' => 'I4', 'group' => 'Group I', 'teamA' => 'Norway', 'teamB' => 'Senegal'],
        43 => ['id' => 'J3', 'group' => 'Group J', 'teamA' => 'Argentina', 'teamB' => 'Austria'],
        44 => ['id' => 'J4', 'group' => 'Group J', 'teamA' => 'Jordan', 'teamB' => 'Algeria'],
        45 => ['id' => 'L4', 'group' => 'Group L', 'teamA' => 'England', 'teamB' => 'Ghana'],
        46 => ['id' => 'L3', 'group' => 'Group L', 'teamA' => 'Panama', 'teamB' => 'Croatia'],
        47 => ['id' => 'K3', 'group' => 'Group K', 'teamA' => 'Portugal', 'teamB' => 'Uzbekistan'],
        48 => ['id' => 'K4', 'group' => 'Group K', 'teamA' => 'Colombia', 'teamB' => 'DR Congo'],
        49 => ['id' => 'C5', 'group' => 'Group C', 'teamA' => 'Scotland', 'teamB' => 'Brazil'],
        50 => ['id' => 'C6', 'group' => 'Group C', 'teamA' => 'Morocco', 'teamB' => 'Haiti'],
        51 => ['id' => 'B5', 'group' => 'Group B', 'teamA' => 'Canada', 'teamB' => 'Switzerland'],
        52 => ['id' => 'B6', 'group' => 'Group B', 'teamA' => 'Qatar', 'teamB' => 'Bosnia and Herzegovina'],
        53 => ['id' => 'A5', 'group' => 'Group A', 'teamA' => 'Mexico', 'teamB' => 'Czech Republic'],
        54 => ['id' => 'A6', 'group' => 'Group A', 'teamA' => 'South Korea', 'teamB' => 'South Africa'],
        55 => ['id' => 'E5', 'group' => 'Group E', 'teamA' => 'Curacao', 'teamB' => 'Ivory Coast'],
        56 => ['id' => 'E6', 'group' => 'Group E', 'teamA' => 'Ecuador', 'teamB' => 'Germany'],
        57 => ['id' => 'F5', 'group' => 'Group F', 'teamA' => 'Japan', 'teamB' => 'Sweden'],
        58 => ['id' => 'F6', 'group' => 'Group F', 'teamA' => 'Tunisia', 'teamB' => 'Netherlands'],
        59 => ['id' => 'D5', 'group' => 'Group D', 'teamA' => 'United States', 'teamB' => 'Turkey'],
        60 => ['id' => 'D6', 'group' => 'Group D', 'teamA' => 'Paraguay', 'teamB' => 'Australia'],
        61 => ['id' => 'I5', 'group' => 'Group I', 'teamA' => 'Norway', 'teamB' => 'France'],
        62 => ['id' => 'I6', 'group' => 'Group I', 'teamA' => 'Senegal', 'teamB' => 'Iraq'],
        63 => ['id' => 'G5', 'group' => 'Group G', 'teamA' => 'Egypt', 'teamB' => 'Iran'],
        64 => ['id' => 'G6', 'group' => 'Group G', 'teamA' => 'New Zealand', 'teamB' => 'Belgium'],
        65 => ['id' => 'H5', 'group' => 'Group H', 'teamA' => 'Cape Verde', 'teamB' => 'Saudi Arabia'],
        66 => ['id' => 'H6', 'group' => 'Group H', 'teamA' => 'Uruguay', 'teamB' => 'Spain'],
        67 => ['id' => 'L5', 'group' => 'Group L', 'teamA' => 'Panama', 'teamB' => 'England'],
        68 => ['id' => 'L6', 'group' => 'Group L', 'teamA' => 'Croatia', 'teamB' => 'Ghana'],
        69 => ['id' => 'J5', 'group' => 'Group J', 'teamA' => 'Algeria', 'teamB' => 'Austria'],
        70 => ['id' => 'J6', 'group' => 'Group J', 'teamA' => 'Jordan', 'teamB' => 'Argentina'],
        71 => ['id' => 'K5', 'group' => 'Group K', 'teamA' => 'Colombia', 'teamB' => 'Portugal'],
        72 => ['id' => 'K6', 'group' => 'Group K', 'teamA' => 'Uzbekistan', 'teamB' => 'DR Congo'],
        73 => ['id' => 'R32_1', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        74 => ['id' => 'R32_2', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        75 => ['id' => 'R32_3', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        76 => ['id' => 'R32_4', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        77 => ['id' => 'R32_5', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        78 => ['id' => 'R32_6', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        79 => ['id' => 'R32_7', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        80 => ['id' => 'R32_8', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        81 => ['id' => 'R32_9', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        82 => ['id' => 'R32_10', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        83 => ['id' => 'R32_11', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        84 => ['id' => 'R32_12', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        85 => ['id' => 'R32_13', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        86 => ['id' => 'R32_14', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        87 => ['id' => 'R32_15', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        88 => ['id' => 'R32_16', 'group' => 'Round of 32', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        89 => ['id' => 'R16_1', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        90 => ['id' => 'R16_2', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        91 => ['id' => 'R16_3', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        92 => ['id' => 'R16_4', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        93 => ['id' => 'R16_5', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        94 => ['id' => 'R16_6', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        95 => ['id' => 'R16_7', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        96 => ['id' => 'R16_8', 'group' => 'Round of 16', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        97 => ['id' => 'QF1', 'group' => 'Quarterfinals', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        98 => ['id' => 'QF2', 'group' => 'Quarterfinals', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        99 => ['id' => 'QF3', 'group' => 'Quarterfinals', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        100 => ['id' => 'QF4', 'group' => 'Quarterfinals', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        101 => ['id' => 'SF1', 'group' => 'Semifinals', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        102 => ['id' => 'SF2', 'group' => 'Semifinals', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        103 => ['id' => 'TP1', 'group' => 'Third Place', 'teamA' => 'TBD', 'teamB' => 'TBD'],
        104 => ['id' => 'FINAL', 'group' => 'Final', 'teamA' => 'TBD', 'teamB' => 'TBD'],
    ];

    private const LEGACY_GROUP_ORDER = [
        'A1', 'A2', 'A3', 'A4', 'A5', 'A6',
        'B1', 'B2', 'B3', 'B4', 'B5', 'B6',
        'C1', 'C2', 'C3', 'C4', 'C5', 'C6',
        'D1', 'D2', 'D3', 'D4', 'D5', 'D6',
        'E1', 'E2', 'E3', 'E4', 'E5', 'E6',
        'F1', 'F2', 'F3', 'F4', 'F5', 'F6',
        'G1', 'G2', 'G3', 'G4', 'G5', 'G6',
        'H1', 'H2', 'H3', 'H4', 'H5', 'H6',
        'I1', 'I2', 'I3', 'I4', 'I5', 'I6',
        'J1', 'J2', 'J3', 'J4', 'J5', 'J6',
        'K1', 'K2', 'K3', 'K4', 'K5', 'K6',
        'L1', 'L2', 'L3', 'L4', 'L5', 'L6',
        'R32_1', 'R32_2', 'R32_3', 'R32_4', 'R32_5', 'R32_6', 'R32_7', 'R32_8',
        'R32_9', 'R32_10', 'R32_11', 'R32_12', 'R32_13', 'R32_14', 'R32_15', 'R32_16',
        'R16_1', 'R16_2', 'R16_3', 'R16_4', 'R16_5', 'R16_6', 'R16_7', 'R16_8',
        'QF1', 'QF2', 'QF3', 'QF4',
        'SF1', 'SF2',
        'TP1',
        'FINAL',
    ];

    /**
     * @param  array<int, array<string, mixed>>  $payloads
     * @return array<int, array<string, mixed>>
     */
    public function normalize(array $payloads): array
    {
        $matches = collect($payloads)
            ->map(fn (array $payload): ?array => $this->normalizeMatch($payload))
            ->filter()
            ->values()
            ->all();

        usort($matches, function (array $a, array $b): int {
            return $this->legacyOrder($a['id']) <=> $this->legacyOrder($b['id']);
        });

        return $matches;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>|null
     */
    private function normalizeMatch(array $payload): ?array
    {
        $matchNumber = isset($payload['MatchNumber']) ? (int) $payload['MatchNumber'] : null;
        $fixture = $matchNumber === null ? null : (self::STABLE_FIXTURES[$matchNumber] ?? null);

        if ($matchNumber === null || $fixture === null || ! isset($payload['Date'])) {
            return null;
        }

        $fifaHomeTeam = $this->teamName($payload, 'Home', 'PlaceHolderA');
        $fifaAwayTeam = $this->teamName($payload, 'Away', 'PlaceHolderB');
        $teamA = $fixture['teamA'] === 'TBD' ? $fifaHomeTeam : $fixture['teamA'];
        $teamB = $fixture['teamB'] === 'TBD' ? $fifaAwayTeam : $fixture['teamB'];
        [$teamAGoals, $teamBGoals, $orientation] = $this->orientedScores($payload, $teamA, $teamB, $fifaHomeTeam, $fifaAwayTeam);

        return [
            'id' => $fixture['id'],
            'group' => $fixture['group'],
            'date' => CarbonImmutable::parse($payload['Date'])->utc()->toIso8601ZuluString(),
            'matchNumber' => $matchNumber,
            'teamA' => $teamA,
            'teamAGoals' => $teamAGoals,
            'teamBGoals' => $teamBGoals,
            'teamB' => $teamB,
            'fifa_match_id' => isset($payload['IdMatch']) ? (string) $payload['IdMatch'] : null,
            'fifa_status' => isset($payload['MatchStatus']) ? (string) $payload['MatchStatus'] : null,
            'fifa_orientation' => $orientation,
        ];
    }

    private function legacyOrder(string $id): int
    {
        static $order = null;

        $order ??= array_flip(self::LEGACY_GROUP_ORDER);

        return $order[$id] ?? PHP_INT_MAX;
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

    /**
     * @return array{0: int|null, 1: int|null, 2: string}
     */
    private function orientedScores(array $payload, string $teamA, string $teamB, string $fifaHomeTeam, string $fifaAwayTeam): array
    {
        $homeScore = $this->score($payload['HomeTeamScore'] ?? $payload['Home']['Score'] ?? null);
        $awayScore = $this->score($payload['AwayTeamScore'] ?? $payload['Away']['Score'] ?? null);

        if ($homeScore === null || $awayScore === null) {
            return [null, null, 'pending'];
        }

        if ($teamA === 'TBD' || $teamB === 'TBD') {
            return [$homeScore, $awayScore, 'dynamic'];
        }

        $teamAKey = $this->teamKey($teamA);
        $teamBKey = $this->teamKey($teamB);
        $homeKey = $this->teamKey($fifaHomeTeam);
        $awayKey = $this->teamKey($fifaAwayTeam);

        if ($homeKey === $teamAKey && $awayKey === $teamBKey) {
            return [$homeScore, $awayScore, 'same'];
        }

        if ($homeKey === $teamBKey && $awayKey === $teamAKey) {
            return [$awayScore, $homeScore, 'swapped'];
        }

        return [null, null, 'mismatch'];
    }

    private function displayTeamName(string $team): string
    {
        return match (Str::of($team)->ascii()->lower()->toString()) {
            'congo dr' => 'DR Congo',
            'czechia' => 'Czech Republic',
            'cote d\'ivoire' => 'Ivory Coast',
            'curacao' => 'Curacao',
            'korea republic' => 'South Korea',
            'turkiye' => 'Turkey',
            'usa', 'united states of america' => 'United States',
            default => $team,
        };
    }

    private function teamKey(string $team): string
    {
        return Str::of($this->displayTeamName($team))
            ->ascii()
            ->lower()
            ->replace(['and'], [''])
            ->replaceMatches('/[^a-z0-9]+/', '')
            ->toString();
    }
}
