<?php

namespace App\Data;

use Carbon\CarbonImmutable;

final class WcMatches
{
    public const TOURNAMENT_TIMEZONE = 'America/New_York';

    public static function all(): array
    {
        return [
            // ---------- GROUP A ----------
            ['id' => 'A1', 'group' => 'Group A', 'date' => '2026-06-11T19:00:00Z', 'matchNumber' => 1,  'teamA' => 'Mexico',              'teamAGoals' => 2, 'teamBGoals' => 0, 'teamB' => 'South Africa'],
            ['id' => 'A2', 'group' => 'Group A', 'date' => '2026-06-12T02:00:00Z', 'matchNumber' => 2,  'teamA' => 'South Korea',         'teamAGoals' => 2, 'teamBGoals' => 1, 'teamB' => 'Czech Republic'],
            ['id' => 'A3', 'group' => 'Group A', 'date' => '2026-06-18T16:00:00Z', 'matchNumber' => 25, 'teamA' => 'South Africa',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Czech Republic'],
            ['id' => 'A4', 'group' => 'Group A', 'date' => '2026-06-19T01:00:00Z', 'matchNumber' => 27, 'teamA' => 'Mexico',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Korea'],
            ['id' => 'A5', 'group' => 'Group A', 'date' => '2026-06-25T01:00:00Z', 'matchNumber' => 53, 'teamA' => 'Mexico',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Czech Republic'],
            ['id' => 'A6', 'group' => 'Group A', 'date' => '2026-06-25T01:00:00Z', 'matchNumber' => 54, 'teamA' => 'South Korea',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Africa'],

            // ---------- GROUP B ----------
            ['id' => 'B1', 'group' => 'Group B', 'date' => '2026-06-12T19:00:00Z', 'matchNumber' => 3,  'teamA' => 'Canada',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Bosnia and Herzegovina'],
            ['id' => 'B2', 'group' => 'Group B', 'date' => '2026-06-13T19:00:00Z', 'matchNumber' => 8,  'teamA' => 'Qatar',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Switzerland'],
            ['id' => 'B3', 'group' => 'Group B', 'date' => '2026-06-18T19:00:00Z', 'matchNumber' => 26, 'teamA' => 'Switzerland',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Bosnia and Herzegovina'],
            ['id' => 'B4', 'group' => 'Group B', 'date' => '2026-06-18T22:00:00Z', 'matchNumber' => 28, 'teamA' => 'Canada',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Qatar'],
            ['id' => 'B5', 'group' => 'Group B', 'date' => '2026-06-24T19:00:00Z', 'matchNumber' => 51, 'teamA' => 'Canada',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Switzerland'],
            ['id' => 'B6', 'group' => 'Group B', 'date' => '2026-06-24T19:00:00Z', 'matchNumber' => 52, 'teamA' => 'Qatar',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Bosnia and Herzegovina'],

            // ---------- GROUP C ----------
            ['id' => 'C1', 'group' => 'Group C', 'date' => '2026-06-13T22:00:00Z', 'matchNumber' => 7,  'teamA' => 'Brazil',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Morocco'],
            ['id' => 'C2', 'group' => 'Group C', 'date' => '2026-06-14T01:00:00Z', 'matchNumber' => 5,  'teamA' => 'Haiti',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Scotland'],
            ['id' => 'C3', 'group' => 'Group C', 'date' => '2026-06-19T19:00:00Z', 'matchNumber' => 30, 'teamA' => 'Scotland',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Morocco'],
            ['id' => 'C4', 'group' => 'Group C', 'date' => '2026-06-20T01:00:00Z', 'matchNumber' => 29, 'teamA' => 'Brazil',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Haiti'],
            ['id' => 'C5', 'group' => 'Group C', 'date' => '2026-06-24T22:00:00Z', 'matchNumber' => 49, 'teamA' => 'Scotland',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Brazil'],
            ['id' => 'C6', 'group' => 'Group C', 'date' => '2026-06-24T22:00:00Z', 'matchNumber' => 50, 'teamA' => 'Morocco',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Haiti'],

            // ---------- GROUP D ----------
            ['id' => 'D1', 'group' => 'Group D', 'date' => '2026-06-13T01:00:00Z', 'matchNumber' => 4,  'teamA' => 'United States',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Paraguay'],
            ['id' => 'D2', 'group' => 'Group D', 'date' => '2026-06-13T04:00:00Z', 'matchNumber' => 6,  'teamA' => 'Australia',           'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Turkey'],
            ['id' => 'D3', 'group' => 'Group D', 'date' => '2026-06-19T19:00:00Z', 'matchNumber' => 32, 'teamA' => 'United States',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Australia'],
            ['id' => 'D4', 'group' => 'Group D', 'date' => '2026-06-19T04:00:00Z', 'matchNumber' => 31, 'teamA' => 'Paraguay',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Turkey'],
            ['id' => 'D5', 'group' => 'Group D', 'date' => '2026-06-26T02:00:00Z', 'matchNumber' => 59, 'teamA' => 'United States',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Turkey'],
            ['id' => 'D6', 'group' => 'Group D', 'date' => '2026-06-26T02:00:00Z', 'matchNumber' => 60, 'teamA' => 'Paraguay',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Australia'],

            // ---------- GROUP E ----------
            ['id' => 'E1', 'group' => 'Group E', 'date' => '2026-06-14T17:00:00Z', 'matchNumber' => 10, 'teamA' => 'Germany',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Curacao'],
            ['id' => 'E2', 'group' => 'Group E', 'date' => '2026-06-14T23:00:00Z', 'matchNumber' => 9,  'teamA' => 'Ivory Coast',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ecuador'],
            ['id' => 'E3', 'group' => 'Group E', 'date' => '2026-06-20T20:00:00Z', 'matchNumber' => 33, 'teamA' => 'Germany',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ivory Coast'],
            ['id' => 'E4', 'group' => 'Group E', 'date' => '2026-06-21T00:00:00Z', 'matchNumber' => 34, 'teamA' => 'Ecuador',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Curacao'],
            ['id' => 'E5', 'group' => 'Group E', 'date' => '2026-06-25T20:00:00Z', 'matchNumber' => 55, 'teamA' => 'Curacao',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ivory Coast'],
            ['id' => 'E6', 'group' => 'Group E', 'date' => '2026-06-25T20:00:00Z', 'matchNumber' => 56, 'teamA' => 'Ecuador',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Germany'],

            // ---------- GROUP F ----------
            ['id' => 'F1', 'group' => 'Group F', 'date' => '2026-06-14T20:00:00Z', 'matchNumber' => 11, 'teamA' => 'Netherlands',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Japan'],
            ['id' => 'F2', 'group' => 'Group F', 'date' => '2026-06-15T02:00:00Z', 'matchNumber' => 12, 'teamA' => 'Tunisia',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Sweden'],
            ['id' => 'F3', 'group' => 'Group F', 'date' => '2026-06-20T17:00:00Z', 'matchNumber' => 35, 'teamA' => 'Netherlands',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Sweden'],
            ['id' => 'F4', 'group' => 'Group F', 'date' => '2026-06-20T04:00:00Z', 'matchNumber' => 36, 'teamA' => 'Tunisia',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Japan'],
            ['id' => 'F5', 'group' => 'Group F', 'date' => '2026-06-25T23:00:00Z', 'matchNumber' => 57, 'teamA' => 'Japan',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Sweden'],
            ['id' => 'F6', 'group' => 'Group F', 'date' => '2026-06-25T23:00:00Z', 'matchNumber' => 58, 'teamA' => 'Tunisia',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Netherlands'],

            // ---------- GROUP G ----------
            ['id' => 'G1', 'group' => 'Group G', 'date' => '2026-06-15T19:00:00Z', 'matchNumber' => 16, 'teamA' => 'Belgium',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Egypt'],
            ['id' => 'G2', 'group' => 'Group G', 'date' => '2026-06-16T01:00:00Z', 'matchNumber' => 15, 'teamA' => 'Iran',                'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'New Zealand'],
            ['id' => 'G3', 'group' => 'Group G', 'date' => '2026-06-21T19:00:00Z', 'matchNumber' => 38, 'teamA' => 'Belgium',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iran'],
            ['id' => 'G4', 'group' => 'Group G', 'date' => '2026-06-22T01:00:00Z', 'matchNumber' => 37, 'teamA' => 'New Zealand',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Egypt'],
            ['id' => 'G5', 'group' => 'Group G', 'date' => '2026-06-27T03:00:00Z', 'matchNumber' => 63, 'teamA' => 'Egypt',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iran'],
            ['id' => 'G6', 'group' => 'Group G', 'date' => '2026-06-27T03:00:00Z', 'matchNumber' => 64, 'teamA' => 'New Zealand',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Belgium'],

            // ---------- GROUP H ----------
            ['id' => 'H1', 'group' => 'Group H', 'date' => '2026-06-15T16:00:00Z', 'matchNumber' => 14, 'teamA' => 'Spain',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Cape Verde'],
            ['id' => 'H2', 'group' => 'Group H', 'date' => '2026-06-15T22:00:00Z', 'matchNumber' => 13, 'teamA' => 'Saudi Arabia',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Uruguay'],
            ['id' => 'H3', 'group' => 'Group H', 'date' => '2026-06-21T22:00:00Z', 'matchNumber' => 40, 'teamA' => 'Uruguay',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Cape Verde'],
            ['id' => 'H4', 'group' => 'Group H', 'date' => '2026-06-21T16:00:00Z', 'matchNumber' => 39, 'teamA' => 'Spain',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Saudi Arabia'],
            ['id' => 'H5', 'group' => 'Group H', 'date' => '2026-06-27T00:00:00Z', 'matchNumber' => 65, 'teamA' => 'Cape Verde',          'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Saudi Arabia'],
            ['id' => 'H6', 'group' => 'Group H', 'date' => '2026-06-27T00:00:00Z', 'matchNumber' => 66, 'teamA' => 'Uruguay',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Spain'],

            // ---------- GROUP I ----------
            ['id' => 'I1', 'group' => 'Group I', 'date' => '2026-06-16T19:00:00Z', 'matchNumber' => 17, 'teamA' => 'France',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Senegal'],
            ['id' => 'I2', 'group' => 'Group I', 'date' => '2026-06-16T22:00:00Z', 'matchNumber' => 18, 'teamA' => 'Norway',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iraq'],
            ['id' => 'I3', 'group' => 'Group I', 'date' => '2026-06-22T21:00:00Z', 'matchNumber' => 41, 'teamA' => 'France',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iraq'],
            ['id' => 'I4', 'group' => 'Group I', 'date' => '2026-06-23T00:00:00Z', 'matchNumber' => 42, 'teamA' => 'Norway',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Senegal'],
            ['id' => 'I5', 'group' => 'Group I', 'date' => '2026-06-26T19:00:00Z', 'matchNumber' => 61, 'teamA' => 'Norway',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'France'],
            ['id' => 'I6', 'group' => 'Group I', 'date' => '2026-06-26T19:00:00Z', 'matchNumber' => 62, 'teamA' => 'Senegal',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iraq'],

            // ---------- GROUP J ----------
            ['id' => 'J1', 'group' => 'Group J', 'date' => '2026-06-17T01:00:00Z', 'matchNumber' => 19, 'teamA' => 'Argentina',           'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Algeria'],
            ['id' => 'J2', 'group' => 'Group J', 'date' => '2026-06-16T04:00:00Z', 'matchNumber' => 20, 'teamA' => 'Austria',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Jordan'],
            ['id' => 'J3', 'group' => 'Group J', 'date' => '2026-06-22T17:00:00Z', 'matchNumber' => 43, 'teamA' => 'Argentina',           'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Austria'],
            ['id' => 'J4', 'group' => 'Group J', 'date' => '2026-06-23T03:00:00Z', 'matchNumber' => 44, 'teamA' => 'Jordan',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Algeria'],
            ['id' => 'J5', 'group' => 'Group J', 'date' => '2026-06-28T02:00:00Z', 'matchNumber' => 69, 'teamA' => 'Algeria',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Austria'],
            ['id' => 'J6', 'group' => 'Group J', 'date' => '2026-06-28T02:00:00Z', 'matchNumber' => 70, 'teamA' => 'Jordan',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Argentina'],

            // ---------- GROUP K ----------
            ['id' => 'K1', 'group' => 'Group K', 'date' => '2026-06-17T17:00:00Z', 'matchNumber' => 23, 'teamA' => 'Portugal',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'DR Congo'],
            ['id' => 'K2', 'group' => 'Group K', 'date' => '2026-06-18T02:00:00Z', 'matchNumber' => 24, 'teamA' => 'Uzbekistan',          'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Colombia'],
            ['id' => 'K3', 'group' => 'Group K', 'date' => '2026-06-23T17:00:00Z', 'matchNumber' => 47, 'teamA' => 'Portugal',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Uzbekistan'],
            ['id' => 'K4', 'group' => 'Group K', 'date' => '2026-06-24T02:00:00Z', 'matchNumber' => 48, 'teamA' => 'Colombia',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'DR Congo'],
            ['id' => 'K5', 'group' => 'Group K', 'date' => '2026-06-27T23:30:00Z', 'matchNumber' => 71, 'teamA' => 'Colombia',            'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Portugal'],
            ['id' => 'K6', 'group' => 'Group K', 'date' => '2026-06-27T23:30:00Z', 'matchNumber' => 72, 'teamA' => 'Uzbekistan',          'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'DR Congo'],

            // ---------- GROUP L ----------
            ['id' => 'L1', 'group' => 'Group L', 'date' => '2026-06-17T20:00:00Z', 'matchNumber' => 22, 'teamA' => 'England',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Croatia'],
            ['id' => 'L2', 'group' => 'Group L', 'date' => '2026-06-17T23:00:00Z', 'matchNumber' => 21, 'teamA' => 'Ghana',               'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Panama'],
            ['id' => 'L3', 'group' => 'Group L', 'date' => '2026-06-23T23:00:00Z', 'matchNumber' => 46, 'teamA' => 'Panama',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Croatia'],
            ['id' => 'L4', 'group' => 'Group L', 'date' => '2026-06-23T20:00:00Z', 'matchNumber' => 45, 'teamA' => 'England',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ghana'],
            ['id' => 'L5', 'group' => 'Group L', 'date' => '2026-06-27T21:00:00Z', 'matchNumber' => 67, 'teamA' => 'Panama',              'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'England'],
            ['id' => 'L6', 'group' => 'Group L', 'date' => '2026-06-27T21:00:00Z', 'matchNumber' => 68, 'teamA' => 'Croatia',             'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ghana'],

            // ---------- ROUND OF 32 ----------
            ['id' => 'R32_1',  'group' => 'Round of 32', 'date' => '2026-06-28T19:00:00Z', 'matchNumber' => 73,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_2',  'group' => 'Round of 32', 'date' => '2026-06-29T17:00:00Z', 'matchNumber' => 74,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_3',  'group' => 'Round of 32', 'date' => '2026-06-29T20:30:00Z', 'matchNumber' => 75,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_4',  'group' => 'Round of 32', 'date' => '2026-06-30T01:00:00Z', 'matchNumber' => 76,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_5',  'group' => 'Round of 32', 'date' => '2026-06-30T17:00:00Z', 'matchNumber' => 77,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_6',  'group' => 'Round of 32', 'date' => '2026-06-30T21:00:00Z', 'matchNumber' => 78,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_7',  'group' => 'Round of 32', 'date' => '2026-07-01T01:00:00Z', 'matchNumber' => 79,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_8',  'group' => 'Round of 32', 'date' => '2026-07-01T16:00:00Z', 'matchNumber' => 80,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_9',  'group' => 'Round of 32', 'date' => '2026-07-01T20:00:00Z', 'matchNumber' => 81,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_10', 'group' => 'Round of 32', 'date' => '2026-07-02T00:00:00Z', 'matchNumber' => 82,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_11', 'group' => 'Round of 32', 'date' => '2026-07-02T19:00:00Z', 'matchNumber' => 83,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_12', 'group' => 'Round of 32', 'date' => '2026-07-02T23:00:00Z', 'matchNumber' => 84,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_13', 'group' => 'Round of 32', 'date' => '2026-07-03T03:00:00Z', 'matchNumber' => 85,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_14', 'group' => 'Round of 32', 'date' => '2026-07-03T18:00:00Z', 'matchNumber' => 86,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_15', 'group' => 'Round of 32', 'date' => '2026-07-03T22:00:00Z', 'matchNumber' => 87,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_16', 'group' => 'Round of 32', 'date' => '2026-07-04T01:30:00Z', 'matchNumber' => 88,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- ROUND OF 16 ----------
            ['id' => 'R16_1', 'group' => 'Round of 16', 'date' => '2026-07-04T17:00:00Z', 'matchNumber' => 89, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_2', 'group' => 'Round of 16', 'date' => '2026-07-04T21:00:00Z', 'matchNumber' => 90, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_3', 'group' => 'Round of 16', 'date' => '2026-07-05T20:00:00Z', 'matchNumber' => 91, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_4', 'group' => 'Round of 16', 'date' => '2026-07-06T00:00:00Z', 'matchNumber' => 92, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_5', 'group' => 'Round of 16', 'date' => '2026-07-06T19:00:00Z', 'matchNumber' => 93, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_6', 'group' => 'Round of 16', 'date' => '2026-07-07T00:00:00Z', 'matchNumber' => 94, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_7', 'group' => 'Round of 16', 'date' => '2026-07-07T16:00:00Z', 'matchNumber' => 95, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_8', 'group' => 'Round of 16', 'date' => '2026-07-07T20:00:00Z', 'matchNumber' => 96, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- QUARTERFINALS ----------
            ['id' => 'QF1', 'group' => 'Quarterfinals', 'date' => '2026-07-09T20:00:00Z', 'matchNumber' => 97,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF2', 'group' => 'Quarterfinals', 'date' => '2026-07-10T19:00:00Z', 'matchNumber' => 98,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF3', 'group' => 'Quarterfinals', 'date' => '2026-07-11T21:00:00Z', 'matchNumber' => 99,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF4', 'group' => 'Quarterfinals', 'date' => '2026-07-12T01:00:00Z', 'matchNumber' => 100, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- SEMIFINALS ----------
            ['id' => 'SF1', 'group' => 'Semifinals', 'date' => '2026-07-14T19:00:00Z', 'matchNumber' => 101, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'SF2', 'group' => 'Semifinals', 'date' => '2026-07-15T19:00:00Z', 'matchNumber' => 102, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- THIRD PLACE ----------
            ['id' => 'TP1', 'group' => 'Third Place', 'date' => '2026-07-18T21:00:00Z', 'matchNumber' => 103, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- FINAL ----------
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

    public static function deadlineReminderMatches(): array
    {
        return array_values(array_filter(self::all(), fn(array $match) => self::receivesDeadlineReminders($match)));
    }

    public static function groupedByGroup(): array
    {
        $groups = [];
        foreach (self::all() as $match) {
            $groups[$match['group']][] = $match;
        }

        return $groups;
    }
}
