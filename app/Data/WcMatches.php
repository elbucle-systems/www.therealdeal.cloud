<?php

namespace App\Data;

use Carbon\CarbonImmutable;

final class WcMatches
{
    public const TOURNAMENT_TIMEZONE = 'America/New_York';

    /**
     * This is the canonical fixture map. Keep this order and teamA/teamB orientation stable:
     * existing predictions store score A/B against these exact slots.
     */
    public const STABLE_FIXTURES = [
        1 => ['id' => 'A1', 'group' => 'Group A', 'teamA' => 'Mexico', 'teamB' => 'South Africa'],
        2 => ['id' => 'A2', 'group' => 'Group A', 'teamA' => 'South Korea', 'teamB' => 'Czech Republic'],
        3 => ['id' => 'B1', 'group' => 'Group B', 'teamA' => 'Canada', 'teamB' => 'Bosnia and Herzegovina'],
        4 => ['id' => 'D1', 'group' => 'Group D', 'teamA' => 'United States', 'teamB' => 'Paraguay'],
        6 => ['id' => 'D2', 'group' => 'Group D', 'teamA' => 'Australia', 'teamB' => 'Turkey'],
        8 => ['id' => 'B2', 'group' => 'Group B', 'teamA' => 'Qatar', 'teamB' => 'Switzerland'],
        7 => ['id' => 'C1', 'group' => 'Group C', 'teamA' => 'Brazil', 'teamB' => 'Morocco'],
        5 => ['id' => 'C2', 'group' => 'Group C', 'teamA' => 'Haiti', 'teamB' => 'Scotland'],
        10 => ['id' => 'E1', 'group' => 'Group E', 'teamA' => 'Germany', 'teamB' => 'Curacao'],
        11 => ['id' => 'F1', 'group' => 'Group F', 'teamA' => 'Netherlands', 'teamB' => 'Japan'],
        9 => ['id' => 'E2', 'group' => 'Group E', 'teamA' => 'Ivory Coast', 'teamB' => 'Ecuador'],
        12 => ['id' => 'F2', 'group' => 'Group F', 'teamA' => 'Tunisia', 'teamB' => 'Sweden'],
        14 => ['id' => 'H1', 'group' => 'Group H', 'teamA' => 'Spain', 'teamB' => 'Cape Verde'],
        16 => ['id' => 'G1', 'group' => 'Group G', 'teamA' => 'Belgium', 'teamB' => 'Egypt'],
        13 => ['id' => 'H2', 'group' => 'Group H', 'teamA' => 'Saudi Arabia', 'teamB' => 'Uruguay'],
        15 => ['id' => 'G2', 'group' => 'Group G', 'teamA' => 'Iran', 'teamB' => 'New Zealand'],
        20 => ['id' => 'J2', 'group' => 'Group J', 'teamA' => 'Austria', 'teamB' => 'Jordan'],
        17 => ['id' => 'I1', 'group' => 'Group I', 'teamA' => 'France', 'teamB' => 'Senegal'],
        18 => ['id' => 'I2', 'group' => 'Group I', 'teamA' => 'Norway', 'teamB' => 'Iraq'],
        19 => ['id' => 'J1', 'group' => 'Group J', 'teamA' => 'Argentina', 'teamB' => 'Algeria'],
        23 => ['id' => 'K1', 'group' => 'Group K', 'teamA' => 'Portugal', 'teamB' => 'DR Congo'],
        22 => ['id' => 'L1', 'group' => 'Group L', 'teamA' => 'England', 'teamB' => 'Croatia'],
        21 => ['id' => 'L2', 'group' => 'Group L', 'teamA' => 'Ghana', 'teamB' => 'Panama'],
        24 => ['id' => 'K2', 'group' => 'Group K', 'teamA' => 'Uzbekistan', 'teamB' => 'Colombia'],
        25 => ['id' => 'A3', 'group' => 'Group A', 'teamA' => 'South Africa', 'teamB' => 'Czech Republic'],
        26 => ['id' => 'B3', 'group' => 'Group B', 'teamA' => 'Switzerland', 'teamB' => 'Bosnia and Herzegovina'],
        28 => ['id' => 'B4', 'group' => 'Group B', 'teamA' => 'Canada', 'teamB' => 'Qatar'],
        27 => ['id' => 'A4', 'group' => 'Group A', 'teamA' => 'Mexico', 'teamB' => 'South Korea'],
        31 => ['id' => 'D4', 'group' => 'Group D', 'teamA' => 'Paraguay', 'teamB' => 'Turkey'],
        30 => ['id' => 'C3', 'group' => 'Group C', 'teamA' => 'Scotland', 'teamB' => 'Morocco'],
        32 => ['id' => 'D3', 'group' => 'Group D', 'teamA' => 'United States', 'teamB' => 'Australia'],
        29 => ['id' => 'C4', 'group' => 'Group C', 'teamA' => 'Brazil', 'teamB' => 'Haiti'],
        36 => ['id' => 'F4', 'group' => 'Group F', 'teamA' => 'Tunisia', 'teamB' => 'Japan'],
        35 => ['id' => 'F3', 'group' => 'Group F', 'teamA' => 'Netherlands', 'teamB' => 'Sweden'],
        33 => ['id' => 'E3', 'group' => 'Group E', 'teamA' => 'Germany', 'teamB' => 'Ivory Coast'],
        34 => ['id' => 'E4', 'group' => 'Group E', 'teamA' => 'Ecuador', 'teamB' => 'Curacao'],
        39 => ['id' => 'H4', 'group' => 'Group H', 'teamA' => 'Spain', 'teamB' => 'Saudi Arabia'],
        38 => ['id' => 'G3', 'group' => 'Group G', 'teamA' => 'Belgium', 'teamB' => 'Iran'],
        40 => ['id' => 'H3', 'group' => 'Group H', 'teamA' => 'Uruguay', 'teamB' => 'Cape Verde'],
        37 => ['id' => 'G4', 'group' => 'Group G', 'teamA' => 'New Zealand', 'teamB' => 'Egypt'],
        43 => ['id' => 'J3', 'group' => 'Group J', 'teamA' => 'Argentina', 'teamB' => 'Austria'],
        41 => ['id' => 'I3', 'group' => 'Group I', 'teamA' => 'France', 'teamB' => 'Iraq'],
        42 => ['id' => 'I4', 'group' => 'Group I', 'teamA' => 'Norway', 'teamB' => 'Senegal'],
        44 => ['id' => 'J4', 'group' => 'Group J', 'teamA' => 'Jordan', 'teamB' => 'Algeria'],
        47 => ['id' => 'K3', 'group' => 'Group K', 'teamA' => 'Portugal', 'teamB' => 'Uzbekistan'],
        45 => ['id' => 'L4', 'group' => 'Group L', 'teamA' => 'England', 'teamB' => 'Ghana'],
        46 => ['id' => 'L3', 'group' => 'Group L', 'teamA' => 'Panama', 'teamB' => 'Croatia'],
        48 => ['id' => 'K4', 'group' => 'Group K', 'teamA' => 'Colombia', 'teamB' => 'DR Congo'],
        51 => ['id' => 'B5', 'group' => 'Group B', 'teamA' => 'Canada', 'teamB' => 'Switzerland'],
        52 => ['id' => 'B6', 'group' => 'Group B', 'teamA' => 'Qatar', 'teamB' => 'Bosnia and Herzegovina'],
        49 => ['id' => 'C5', 'group' => 'Group C', 'teamA' => 'Scotland', 'teamB' => 'Brazil'],
        50 => ['id' => 'C6', 'group' => 'Group C', 'teamA' => 'Morocco', 'teamB' => 'Haiti'],
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
        65 => ['id' => 'H5', 'group' => 'Group H', 'teamA' => 'Cape Verde', 'teamB' => 'Saudi Arabia'],
        66 => ['id' => 'H6', 'group' => 'Group H', 'teamA' => 'Uruguay', 'teamB' => 'Spain'],
        63 => ['id' => 'G5', 'group' => 'Group G', 'teamA' => 'Egypt', 'teamB' => 'Iran'],
        64 => ['id' => 'G6', 'group' => 'Group G', 'teamA' => 'New Zealand', 'teamB' => 'Belgium'],
        67 => ['id' => 'L5', 'group' => 'Group L', 'teamA' => 'Panama', 'teamB' => 'England'],
        68 => ['id' => 'L6', 'group' => 'Group L', 'teamA' => 'Croatia', 'teamB' => 'Ghana'],
        71 => ['id' => 'K5', 'group' => 'Group K', 'teamA' => 'Colombia', 'teamB' => 'Portugal'],
        72 => ['id' => 'K6', 'group' => 'Group K', 'teamA' => 'Uzbekistan', 'teamB' => 'DR Congo'],
        69 => ['id' => 'J5', 'group' => 'Group J', 'teamA' => 'Algeria', 'teamB' => 'Austria'],
        70 => ['id' => 'J6', 'group' => 'Group J', 'teamA' => 'Jordan', 'teamB' => 'Argentina'],
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

    /**
     * Update match results by editing teamAGoals and teamBGoals here.
     * Leave both values null until the match has a final score.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            ['id' => 'A1', 'group' => 'Group A', 'date' => '2026-06-11T19:00:00Z', 'matchNumber' => 1, 'teamA' => 'Mexico', 'teamAGoals' => 2, 'teamBGoals' => 0, 'teamB' => 'South Africa'],
            ['id' => 'A2', 'group' => 'Group A', 'date' => '2026-06-12T02:00:00Z', 'matchNumber' => 2, 'teamA' => 'South Korea', 'teamAGoals' => 2, 'teamBGoals' => 1, 'teamB' => 'Czech Republic'],
            ['id' => 'B1', 'group' => 'Group B', 'date' => '2026-06-12T19:00:00Z', 'matchNumber' => 3, 'teamA' => 'Canada', 'teamAGoals' => 1, 'teamBGoals' => 1, 'teamB' => 'Bosnia and Herzegovina'],
            ['id' => 'D1', 'group' => 'Group D', 'date' => '2026-06-13T01:00:00Z', 'matchNumber' => 4, 'teamA' => 'United States', 'teamAGoals' => 4, 'teamBGoals' => 1, 'teamB' => 'Paraguay'],
            ['id' => 'D2', 'group' => 'Group D', 'date' => '2026-06-13T04:00:00Z', 'matchNumber' => 6, 'teamA' => 'Australia', 'teamAGoals' => 2, 'teamBGoals' => 0, 'teamB' => 'Turkey'],
            ['id' => 'B2', 'group' => 'Group B', 'date' => '2026-06-13T19:00:00Z', 'matchNumber' => 8, 'teamA' => 'Qatar', 'teamAGoals' => 1, 'teamBGoals' => 1, 'teamB' => 'Switzerland'],
            ['id' => 'C1', 'group' => 'Group C', 'date' => '2026-06-13T22:00:00Z', 'matchNumber' => 7, 'teamA' => 'Brazil', 'teamAGoals' => 1, 'teamBGoals' => 1, 'teamB' => 'Morocco'],
            ['id' => 'C2', 'group' => 'Group C', 'date' => '2026-06-14T01:00:00Z', 'matchNumber' => 5, 'teamA' => 'Haiti', 'teamAGoals' => 0, 'teamBGoals' => 1, 'teamB' => 'Scotland'],
            ['id' => 'E1', 'group' => 'Group E', 'date' => '2026-06-14T17:00:00Z', 'matchNumber' => 10, 'teamA' => 'Germany', 'teamAGoals' => 7, 'teamBGoals' => 1, 'teamB' => 'Curacao'],
            ['id' => 'F1', 'group' => 'Group F', 'date' => '2026-06-14T20:00:00Z', 'matchNumber' => 11, 'teamA' => 'Netherlands', 'teamAGoals' => 2, 'teamBGoals' => 2, 'teamB' => 'Japan'],
            ['id' => 'E2', 'group' => 'Group E', 'date' => '2026-06-14T23:00:00Z', 'matchNumber' => 9, 'teamA' => 'Ivory Coast', 'teamAGoals' => 1, 'teamBGoals' => 0, 'teamB' => 'Ecuador'],
            ['id' => 'F2', 'group' => 'Group F', 'date' => '2026-06-15T02:00:00Z', 'matchNumber' => 12, 'teamA' => 'Tunisia', 'teamAGoals' => 1, 'teamBGoals' => 5, 'teamB' => 'Sweden'],
            ['id' => 'H1', 'group' => 'Group H', 'date' => '2026-06-15T16:00:00Z', 'matchNumber' => 14, 'teamA' => 'Spain', 'teamAGoals' => 0, 'teamBGoals' => 0, 'teamB' => 'Cape Verde'],
            ['id' => 'G1', 'group' => 'Group G', 'date' => '2026-06-15T19:00:00Z', 'matchNumber' => 16, 'teamA' => 'Belgium', 'teamAGoals' => 1, 'teamBGoals' => 1, 'teamB' => 'Egypt'],
            ['id' => 'H2', 'group' => 'Group H', 'date' => '2026-06-15T22:00:00Z', 'matchNumber' => 13, 'teamA' => 'Saudi Arabia', 'teamAGoals' => 1, 'teamBGoals' => 1, 'teamB' => 'Uruguay'],
            ['id' => 'G2', 'group' => 'Group G', 'date' => '2026-06-16T01:00:00Z', 'matchNumber' => 15, 'teamA' => 'Iran', 'teamAGoals' => 2, 'teamBGoals' => 2, 'teamB' => 'New Zealand'],
            ['id' => 'I1', 'group' => 'Group I', 'date' => '2026-06-16T19:00:00Z', 'matchNumber' => 17, 'teamA' => 'France', 'teamAGoals' => 3, 'teamBGoals' => 1, 'teamB' => 'Senegal'],
            ['id' => 'I2', 'group' => 'Group I', 'date' => '2026-06-16T22:00:00Z', 'matchNumber' => 18, 'teamA' => 'Norway', 'teamAGoals' => 4, 'teamBGoals' => 1, 'teamB' => 'Iraq'],
            ['id' => 'J1', 'group' => 'Group J', 'date' => '2026-06-17T01:00:00Z', 'matchNumber' => 19, 'teamA' => 'Argentina', 'teamAGoals' => 3, 'teamBGoals' => 0, 'teamB' => 'Algeria'],
            ['id' => 'J2', 'group' => 'Group J', 'date' => '2026-06-17T04:00:00Z', 'matchNumber' => 20, 'teamA' => 'Austria', 'teamAGoals' => 3, 'teamBGoals' => 1, 'teamB' => 'Jordan'],
            ['id' => 'K1', 'group' => 'Group K', 'date' => '2026-06-17T17:00:00Z', 'matchNumber' => 23, 'teamA' => 'Portugal', 'teamAGoals' => 1, 'teamBGoals' => 1, 'teamB' => 'DR Congo'],
            ['id' => 'L1', 'group' => 'Group L', 'date' => '2026-06-17T20:00:00Z', 'matchNumber' => 22, 'teamA' => 'England', 'teamAGoals' => 4, 'teamBGoals' => 2, 'teamB' => 'Croatia'],
            ['id' => 'L2', 'group' => 'Group L', 'date' => '2026-06-17T23:00:00Z', 'matchNumber' => 21, 'teamA' => 'Ghana', 'teamAGoals' => 1, 'teamBGoals' => 0, 'teamB' => 'Panama'],
            ['id' => 'K2', 'group' => 'Group K', 'date' => '2026-06-18T02:00:00Z', 'matchNumber' => 24, 'teamA' => 'Uzbekistan', 'teamAGoals' => 1, 'teamBGoals' => 3, 'teamB' => 'Colombia'],
            ['id' => 'A3', 'group' => 'Group A', 'date' => '2026-06-18T16:00:00Z', 'matchNumber' => 25, 'teamA' => 'South Africa', 'teamAGoals' => 1, 'teamBGoals' => 1, 'teamB' => 'Czech Republic'],
            ['id' => 'B3', 'group' => 'Group B', 'date' => '2026-06-18T19:00:00Z', 'matchNumber' => 26, 'teamA' => 'Switzerland', 'teamAGoals' => 4, 'teamBGoals' => 1, 'teamB' => 'Bosnia and Herzegovina'],
            ['id' => 'B4', 'group' => 'Group B', 'date' => '2026-06-18T22:00:00Z', 'matchNumber' => 28, 'teamA' => 'Canada', 'teamAGoals' => 6, 'teamBGoals' => 0, 'teamB' => 'Qatar'],
            ['id' => 'A4', 'group' => 'Group A', 'date' => '2026-06-19T01:00:00Z', 'matchNumber' => 27, 'teamA' => 'Mexico', 'teamAGoals' => 1, 'teamBGoals' => 0, 'teamB' => 'South Korea'],
            ['id' => 'D4', 'group' => 'Group D', 'date' => '2026-06-20T04:00:00Z', 'matchNumber' => 31, 'teamA' => 'Paraguay', 'teamAGoals' => 1, 'teamBGoals' => 0, 'teamB' => 'Turkey'],
            ['id' => 'C3', 'group' => 'Group C', 'date' => '2026-06-19T19:00:00Z', 'matchNumber' => 30, 'teamA' => 'Scotland', 'teamAGoals' => 0, 'teamBGoals' => 1, 'teamB' => 'Morocco'],
            ['id' => 'D3', 'group' => 'Group D', 'date' => '2026-06-19T19:00:00Z', 'matchNumber' => 32, 'teamA' => 'United States', 'teamAGoals' => 2, 'teamBGoals' => 0, 'teamB' => 'Australia'],
            ['id' => 'C4', 'group' => 'Group C', 'date' => '2026-06-20T00:30:00Z', 'matchNumber' => 29, 'teamA' => 'Brazil', 'teamAGoals' => 3, 'teamBGoals' => 0, 'teamB' => 'Haiti'],
            ['id' => 'F4', 'group' => 'Group F', 'date' => '2026-06-21T04:00:00Z', 'matchNumber' => 36, 'teamA' => 'Tunisia', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Japan'],
            ['id' => 'F3', 'group' => 'Group F', 'date' => '2026-06-20T17:00:00Z', 'matchNumber' => 35, 'teamA' => 'Netherlands', 'teamAGoals' => 5, 'teamBGoals' => 1, 'teamB' => 'Sweden'],
            ['id' => 'E3', 'group' => 'Group E', 'date' => '2026-06-20T20:00:00Z', 'matchNumber' => 33, 'teamA' => 'Germany', 'teamAGoals' => 2, 'teamBGoals' => 1, 'teamB' => 'Ivory Coast'],
            ['id' => 'E4', 'group' => 'Group E', 'date' => '2026-06-21T00:00:00Z', 'matchNumber' => 34, 'teamA' => 'Ecuador', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Curacao'],
            ['id' => 'H4', 'group' => 'Group H', 'date' => '2026-06-21T16:00:00Z', 'matchNumber' => 39, 'teamA' => 'Spain', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Saudi Arabia'],
            ['id' => 'G3', 'group' => 'Group G', 'date' => '2026-06-21T19:00:00Z', 'matchNumber' => 38, 'teamA' => 'Belgium', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iran'],
            ['id' => 'H3', 'group' => 'Group H', 'date' => '2026-06-21T22:00:00Z', 'matchNumber' => 40, 'teamA' => 'Uruguay', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Cape Verde'],
            ['id' => 'G4', 'group' => 'Group G', 'date' => '2026-06-22T01:00:00Z', 'matchNumber' => 37, 'teamA' => 'New Zealand', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Egypt'],
            ['id' => 'J3', 'group' => 'Group J', 'date' => '2026-06-22T17:00:00Z', 'matchNumber' => 43, 'teamA' => 'Argentina', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Austria'],
            ['id' => 'I3', 'group' => 'Group I', 'date' => '2026-06-22T21:00:00Z', 'matchNumber' => 41, 'teamA' => 'France', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iraq'],
            ['id' => 'I4', 'group' => 'Group I', 'date' => '2026-06-23T00:00:00Z', 'matchNumber' => 42, 'teamA' => 'Norway', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Senegal'],
            ['id' => 'J4', 'group' => 'Group J', 'date' => '2026-06-23T03:00:00Z', 'matchNumber' => 44, 'teamA' => 'Jordan', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Algeria'],
            ['id' => 'K3', 'group' => 'Group K', 'date' => '2026-06-23T17:00:00Z', 'matchNumber' => 47, 'teamA' => 'Portugal', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Uzbekistan'],
            ['id' => 'L4', 'group' => 'Group L', 'date' => '2026-06-23T20:00:00Z', 'matchNumber' => 45, 'teamA' => 'England', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ghana'],
            ['id' => 'L3', 'group' => 'Group L', 'date' => '2026-06-23T23:00:00Z', 'matchNumber' => 46, 'teamA' => 'Panama', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Croatia'],
            ['id' => 'K4', 'group' => 'Group K', 'date' => '2026-06-24T02:00:00Z', 'matchNumber' => 48, 'teamA' => 'Colombia', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'DR Congo'],
            ['id' => 'B5', 'group' => 'Group B', 'date' => '2026-06-24T19:00:00Z', 'matchNumber' => 51, 'teamA' => 'Canada', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Switzerland'],
            ['id' => 'B6', 'group' => 'Group B', 'date' => '2026-06-24T19:00:00Z', 'matchNumber' => 52, 'teamA' => 'Qatar', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Bosnia and Herzegovina'],
            ['id' => 'C5', 'group' => 'Group C', 'date' => '2026-06-24T22:00:00Z', 'matchNumber' => 49, 'teamA' => 'Scotland', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Brazil'],
            ['id' => 'C6', 'group' => 'Group C', 'date' => '2026-06-24T22:00:00Z', 'matchNumber' => 50, 'teamA' => 'Morocco', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Haiti'],
            ['id' => 'A5', 'group' => 'Group A', 'date' => '2026-06-25T01:00:00Z', 'matchNumber' => 53, 'teamA' => 'Mexico', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Czech Republic'],
            ['id' => 'A6', 'group' => 'Group A', 'date' => '2026-06-25T01:00:00Z', 'matchNumber' => 54, 'teamA' => 'South Korea', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Africa'],
            ['id' => 'E5', 'group' => 'Group E', 'date' => '2026-06-25T20:00:00Z', 'matchNumber' => 55, 'teamA' => 'Curacao', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ivory Coast'],
            ['id' => 'E6', 'group' => 'Group E', 'date' => '2026-06-25T20:00:00Z', 'matchNumber' => 56, 'teamA' => 'Ecuador', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Germany'],
            ['id' => 'F5', 'group' => 'Group F', 'date' => '2026-06-25T23:00:00Z', 'matchNumber' => 57, 'teamA' => 'Japan', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Sweden'],
            ['id' => 'F6', 'group' => 'Group F', 'date' => '2026-06-25T23:00:00Z', 'matchNumber' => 58, 'teamA' => 'Tunisia', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Netherlands'],
            ['id' => 'D5', 'group' => 'Group D', 'date' => '2026-06-26T02:00:00Z', 'matchNumber' => 59, 'teamA' => 'United States', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Turkey'],
            ['id' => 'D6', 'group' => 'Group D', 'date' => '2026-06-26T02:00:00Z', 'matchNumber' => 60, 'teamA' => 'Paraguay', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Australia'],
            ['id' => 'I5', 'group' => 'Group I', 'date' => '2026-06-26T19:00:00Z', 'matchNumber' => 61, 'teamA' => 'Norway', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'France'],
            ['id' => 'I6', 'group' => 'Group I', 'date' => '2026-06-26T19:00:00Z', 'matchNumber' => 62, 'teamA' => 'Senegal', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iraq'],
            ['id' => 'H5', 'group' => 'Group H', 'date' => '2026-06-27T00:00:00Z', 'matchNumber' => 65, 'teamA' => 'Cape Verde', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Saudi Arabia'],
            ['id' => 'H6', 'group' => 'Group H', 'date' => '2026-06-27T00:00:00Z', 'matchNumber' => 66, 'teamA' => 'Uruguay', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Spain'],
            ['id' => 'G5', 'group' => 'Group G', 'date' => '2026-06-27T03:00:00Z', 'matchNumber' => 63, 'teamA' => 'Egypt', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iran'],
            ['id' => 'G6', 'group' => 'Group G', 'date' => '2026-06-27T03:00:00Z', 'matchNumber' => 64, 'teamA' => 'New Zealand', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Belgium'],
            ['id' => 'L5', 'group' => 'Group L', 'date' => '2026-06-27T21:00:00Z', 'matchNumber' => 67, 'teamA' => 'Panama', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'England'],
            ['id' => 'L6', 'group' => 'Group L', 'date' => '2026-06-27T21:00:00Z', 'matchNumber' => 68, 'teamA' => 'Croatia', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ghana'],
            ['id' => 'K5', 'group' => 'Group K', 'date' => '2026-06-27T23:30:00Z', 'matchNumber' => 71, 'teamA' => 'Colombia', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Portugal'],
            ['id' => 'K6', 'group' => 'Group K', 'date' => '2026-06-27T23:30:00Z', 'matchNumber' => 72, 'teamA' => 'Uzbekistan', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'DR Congo'],
            ['id' => 'J5', 'group' => 'Group J', 'date' => '2026-06-28T02:00:00Z', 'matchNumber' => 69, 'teamA' => 'Algeria', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Austria'],
            ['id' => 'J6', 'group' => 'Group J', 'date' => '2026-06-28T02:00:00Z', 'matchNumber' => 70, 'teamA' => 'Jordan', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Argentina'],
            ['id' => 'R32_1', 'group' => 'Round of 32', 'date' => '2026-06-28T19:00:00Z', 'matchNumber' => 73, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_2', 'group' => 'Round of 32', 'date' => '2026-06-29T17:00:00Z', 'matchNumber' => 74, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_3', 'group' => 'Round of 32', 'date' => '2026-06-29T20:30:00Z', 'matchNumber' => 75, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_4', 'group' => 'Round of 32', 'date' => '2026-06-30T01:00:00Z', 'matchNumber' => 76, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_5', 'group' => 'Round of 32', 'date' => '2026-06-30T17:00:00Z', 'matchNumber' => 77, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_6', 'group' => 'Round of 32', 'date' => '2026-06-30T21:00:00Z', 'matchNumber' => 78, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_7', 'group' => 'Round of 32', 'date' => '2026-07-01T01:00:00Z', 'matchNumber' => 79, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_8', 'group' => 'Round of 32', 'date' => '2026-07-01T16:00:00Z', 'matchNumber' => 80, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_9', 'group' => 'Round of 32', 'date' => '2026-07-01T20:00:00Z', 'matchNumber' => 81, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_10', 'group' => 'Round of 32', 'date' => '2026-07-02T00:00:00Z', 'matchNumber' => 82, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_11', 'group' => 'Round of 32', 'date' => '2026-07-02T19:00:00Z', 'matchNumber' => 83, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_12', 'group' => 'Round of 32', 'date' => '2026-07-02T23:00:00Z', 'matchNumber' => 84, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_13', 'group' => 'Round of 32', 'date' => '2026-07-03T03:00:00Z', 'matchNumber' => 85, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_14', 'group' => 'Round of 32', 'date' => '2026-07-03T18:00:00Z', 'matchNumber' => 86, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_15', 'group' => 'Round of 32', 'date' => '2026-07-03T22:00:00Z', 'matchNumber' => 87, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_16', 'group' => 'Round of 32', 'date' => '2026-07-04T01:30:00Z', 'matchNumber' => 88, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_1', 'group' => 'Round of 16', 'date' => '2026-07-04T17:00:00Z', 'matchNumber' => 89, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_2', 'group' => 'Round of 16', 'date' => '2026-07-04T21:00:00Z', 'matchNumber' => 90, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_3', 'group' => 'Round of 16', 'date' => '2026-07-05T20:00:00Z', 'matchNumber' => 91, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_4', 'group' => 'Round of 16', 'date' => '2026-07-06T00:00:00Z', 'matchNumber' => 92, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_5', 'group' => 'Round of 16', 'date' => '2026-07-06T19:00:00Z', 'matchNumber' => 93, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_6', 'group' => 'Round of 16', 'date' => '2026-07-07T00:00:00Z', 'matchNumber' => 94, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_7', 'group' => 'Round of 16', 'date' => '2026-07-07T16:00:00Z', 'matchNumber' => 95, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_8', 'group' => 'Round of 16', 'date' => '2026-07-07T20:00:00Z', 'matchNumber' => 96, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF1', 'group' => 'Quarterfinals', 'date' => '2026-07-09T20:00:00Z', 'matchNumber' => 97, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF2', 'group' => 'Quarterfinals', 'date' => '2026-07-10T19:00:00Z', 'matchNumber' => 98, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF3', 'group' => 'Quarterfinals', 'date' => '2026-07-11T21:00:00Z', 'matchNumber' => 99, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF4', 'group' => 'Quarterfinals', 'date' => '2026-07-12T01:00:00Z', 'matchNumber' => 100, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'SF1', 'group' => 'Semifinals', 'date' => '2026-07-14T19:00:00Z', 'matchNumber' => 101, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'SF2', 'group' => 'Semifinals', 'date' => '2026-07-15T19:00:00Z', 'matchNumber' => 102, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'TP1', 'group' => 'Third Place', 'date' => '2026-07-18T21:00:00Z', 'matchNumber' => 103, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'FINAL', 'group' => 'Final', 'date' => '2026-07-19T19:00:00Z', 'matchNumber' => 104, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
        ];
    }

    public static function find(string $id): ?array
    {
        foreach (self::all() as $match) {
            if ($match['id'] === $id) {
                return $match;
            }
        }

        return null;
    }

    public static function kickoff(string|array $match): CarbonImmutable
    {
        $date = is_array($match) ? $match['date'] : $match;

        return CarbonImmutable::parse($date)->utc();
    }

    public static function deadline(string|array $match, int $deadlineDays): CarbonImmutable
    {
        return self::kickoff($match)->subDays($deadlineDays);
    }

    public static function receivesDeadlineReminders(array $match): bool
    {
        return str_starts_with($match['group'], 'Group ');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function deadlineReminderMatches(): array
    {
        return array_values(array_filter(self::all(), fn(array $match): bool => self::receivesDeadlineReminders($match)));
    }
}
