<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

class FifaWorldCupResultNormalizer
{
    private const LEGACY_MATCH_IDS = [
        1 => 'A1',
        2 => 'A2',
        3 => 'B1',
        4 => 'D1',
        5 => 'C2',
        6 => 'D2',
        7 => 'C1',
        8 => 'B2',
        9 => 'E2',
        10 => 'E1',
        11 => 'F1',
        12 => 'F2',
        13 => 'H2',
        14 => 'H1',
        15 => 'G2',
        16 => 'G1',
        17 => 'I1',
        18 => 'I2',
        19 => 'J1',
        20 => 'J2',
        21 => 'L2',
        22 => 'L1',
        23 => 'K1',
        24 => 'K2',
        25 => 'A3',
        26 => 'B3',
        27 => 'A4',
        28 => 'B4',
        29 => 'C4',
        30 => 'C3',
        31 => 'D4',
        32 => 'D3',
        33 => 'E3',
        34 => 'E4',
        35 => 'F3',
        36 => 'F4',
        37 => 'G4',
        38 => 'G3',
        39 => 'H4',
        40 => 'H3',
        41 => 'I3',
        42 => 'I4',
        43 => 'J3',
        44 => 'J4',
        45 => 'L4',
        46 => 'L3',
        47 => 'K3',
        48 => 'K4',
        49 => 'C5',
        50 => 'C6',
        51 => 'B5',
        52 => 'B6',
        53 => 'A5',
        54 => 'A6',
        55 => 'E5',
        56 => 'E6',
        57 => 'F5',
        58 => 'F6',
        59 => 'D5',
        60 => 'D6',
        61 => 'I5',
        62 => 'I6',
        63 => 'G5',
        64 => 'G6',
        65 => 'H5',
        66 => 'H6',
        67 => 'L5',
        68 => 'L6',
        69 => 'J5',
        70 => 'J6',
        71 => 'K5',
        72 => 'K6',
        73 => 'R32_1',
        74 => 'R32_2',
        75 => 'R32_3',
        76 => 'R32_4',
        77 => 'R32_5',
        78 => 'R32_6',
        79 => 'R32_7',
        80 => 'R32_8',
        81 => 'R32_9',
        82 => 'R32_10',
        83 => 'R32_11',
        84 => 'R32_12',
        85 => 'R32_13',
        86 => 'R32_14',
        87 => 'R32_15',
        88 => 'R32_16',
        89 => 'R16_1',
        90 => 'R16_2',
        91 => 'R16_3',
        92 => 'R16_4',
        93 => 'R16_5',
        94 => 'R16_6',
        95 => 'R16_7',
        96 => 'R16_8',
        97 => 'QF1',
        98 => 'QF2',
        99 => 'QF3',
        100 => 'QF4',
        101 => 'SF1',
        102 => 'SF2',
        103 => 'TP1',
        104 => 'FINAL',
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
        $stage = $this->stage($payload, $matchNumber);
        $id = $this->matchId($matchNumber);

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

    private function matchId(?int $matchNumber): ?string
    {
        return $matchNumber === null ? null : (self::LEGACY_MATCH_IDS[$matchNumber] ?? null);
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
