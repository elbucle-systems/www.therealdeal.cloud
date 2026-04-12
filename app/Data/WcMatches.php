<?php

namespace App\Data;

final class WcMatches
{
    public static function all(): array
    {
        return [
            // ---------- GROUP A ----------
            ['id' => 'A1', 'group' => 'Group A', 'date' => '2026-06-11T18:00:00Z', 'matchNumber' => 1,  'teamA' => 'Mexico',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Canada'],
            ['id' => 'A2', 'group' => 'Group A', 'date' => '2026-06-11T21:00:00Z', 'matchNumber' => 2,  'teamA' => 'USA',           'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'New Zealand'],
            ['id' => 'A3', 'group' => 'Group A', 'date' => '2026-06-16T18:00:00Z', 'matchNumber' => 3,  'teamA' => 'Mexico',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'USA'],
            ['id' => 'A4', 'group' => 'Group A', 'date' => '2026-06-16T21:00:00Z', 'matchNumber' => 4,  'teamA' => 'Canada',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'New Zealand'],
            ['id' => 'A5', 'group' => 'Group A', 'date' => '2026-06-21T18:00:00Z', 'matchNumber' => 5,  'teamA' => 'USA',           'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Canada'],
            ['id' => 'A6', 'group' => 'Group A', 'date' => '2026-06-21T21:00:00Z', 'matchNumber' => 6,  'teamA' => 'Mexico',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'New Zealand'],

            // ---------- GROUP B ----------
            ['id' => 'B1', 'group' => 'Group B', 'date' => '2026-06-12T18:00:00Z', 'matchNumber' => 7,  'teamA' => 'Argentina',     'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Netherlands'],
            ['id' => 'B2', 'group' => 'Group B', 'date' => '2026-06-12T21:00:00Z', 'matchNumber' => 8,  'teamA' => 'Japan',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Nigeria'],
            ['id' => 'B3', 'group' => 'Group B', 'date' => '2026-06-17T18:00:00Z', 'matchNumber' => 9,  'teamA' => 'Argentina',     'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Japan'],
            ['id' => 'B4', 'group' => 'Group B', 'date' => '2026-06-17T21:00:00Z', 'matchNumber' => 10, 'teamA' => 'Netherlands',   'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Nigeria'],
            ['id' => 'B5', 'group' => 'Group B', 'date' => '2026-06-22T18:00:00Z', 'matchNumber' => 11, 'teamA' => 'Argentina',     'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Nigeria'],
            ['id' => 'B6', 'group' => 'Group B', 'date' => '2026-06-22T21:00:00Z', 'matchNumber' => 12, 'teamA' => 'Netherlands',   'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Japan'],

            // ---------- GROUP C ----------
            ['id' => 'C1', 'group' => 'Group C', 'date' => '2026-06-13T18:00:00Z', 'matchNumber' => 13, 'teamA' => 'Brazil',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Korea'],
            ['id' => 'C2', 'group' => 'Group C', 'date' => '2026-06-13T21:00:00Z', 'matchNumber' => 14, 'teamA' => 'Germany',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Morocco'],
            ['id' => 'C3', 'group' => 'Group C', 'date' => '2026-06-18T18:00:00Z', 'matchNumber' => 15, 'teamA' => 'Brazil',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Germany'],
            ['id' => 'C4', 'group' => 'Group C', 'date' => '2026-06-18T21:00:00Z', 'matchNumber' => 16, 'teamA' => 'Morocco',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Korea'],
            ['id' => 'C5', 'group' => 'Group C', 'date' => '2026-06-23T18:00:00Z', 'matchNumber' => 17, 'teamA' => 'Germany',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Korea'],
            ['id' => 'C6', 'group' => 'Group C', 'date' => '2026-06-23T21:00:00Z', 'matchNumber' => 18, 'teamA' => 'Brazil',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Morocco'],

            // ---------- GROUP D ----------
            ['id' => 'D1', 'group' => 'Group D', 'date' => '2026-06-14T18:00:00Z', 'matchNumber' => 19, 'teamA' => 'France',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Chile'],
            ['id' => 'D2', 'group' => 'Group D', 'date' => '2026-06-14T21:00:00Z', 'matchNumber' => 20, 'teamA' => 'Spain',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Egypt'],
            ['id' => 'D3', 'group' => 'Group D', 'date' => '2026-06-19T18:00:00Z', 'matchNumber' => 21, 'teamA' => 'France',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Spain'],
            ['id' => 'D4', 'group' => 'Group D', 'date' => '2026-06-19T21:00:00Z', 'matchNumber' => 22, 'teamA' => 'Chile',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Egypt'],
            ['id' => 'D5', 'group' => 'Group D', 'date' => '2026-06-24T18:00:00Z', 'matchNumber' => 23, 'teamA' => 'Spain',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Chile'],
            ['id' => 'D6', 'group' => 'Group D', 'date' => '2026-06-24T21:00:00Z', 'matchNumber' => 24, 'teamA' => 'France',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Egypt'],

            // ---------- GROUP E ----------
            ['id' => 'E1', 'group' => 'Group E', 'date' => '2026-06-15T18:00:00Z', 'matchNumber' => 25, 'teamA' => 'England',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Australia'],
            ['id' => 'E2', 'group' => 'Group E', 'date' => '2026-06-15T21:00:00Z', 'matchNumber' => 26, 'teamA' => 'Denmark',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Peru'],
            ['id' => 'E3', 'group' => 'Group E', 'date' => '2026-06-20T18:00:00Z', 'matchNumber' => 27, 'teamA' => 'England',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Denmark'],
            ['id' => 'E4', 'group' => 'Group E', 'date' => '2026-06-20T21:00:00Z', 'matchNumber' => 28, 'teamA' => 'Australia',     'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Peru'],
            ['id' => 'E5', 'group' => 'Group E', 'date' => '2026-06-25T18:00:00Z', 'matchNumber' => 29, 'teamA' => 'England',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Peru'],
            ['id' => 'E6', 'group' => 'Group E', 'date' => '2026-06-25T21:00:00Z', 'matchNumber' => 30, 'teamA' => 'Denmark',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Australia'],

            // ---------- GROUP F ----------
            ['id' => 'F1', 'group' => 'Group F', 'date' => '2026-06-16T18:00:00Z', 'matchNumber' => 31, 'teamA' => 'Italy',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ghana'],
            ['id' => 'F2', 'group' => 'Group F', 'date' => '2026-06-16T21:00:00Z', 'matchNumber' => 32, 'teamA' => 'Colombia',      'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Switzerland'],
            ['id' => 'F3', 'group' => 'Group F', 'date' => '2026-06-21T18:00:00Z', 'matchNumber' => 33, 'teamA' => 'Italy',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Colombia'],
            ['id' => 'F4', 'group' => 'Group F', 'date' => '2026-06-21T21:00:00Z', 'matchNumber' => 34, 'teamA' => 'Ghana',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Switzerland'],
            ['id' => 'F5', 'group' => 'Group F', 'date' => '2026-06-26T18:00:00Z', 'matchNumber' => 35, 'teamA' => 'Italy',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Switzerland'],
            ['id' => 'F6', 'group' => 'Group F', 'date' => '2026-06-26T21:00:00Z', 'matchNumber' => 36, 'teamA' => 'Colombia',      'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ghana'],

            // ---------- GROUP G ----------
            ['id' => 'G1', 'group' => 'Group G', 'date' => '2026-06-17T18:00:00Z', 'matchNumber' => 37, 'teamA' => 'Portugal',      'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'USA'],
            ['id' => 'G2', 'group' => 'Group G', 'date' => '2026-06-17T21:00:00Z', 'matchNumber' => 38, 'teamA' => 'Croatia',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Senegal'],
            ['id' => 'G3', 'group' => 'Group G', 'date' => '2026-06-22T18:00:00Z', 'matchNumber' => 39, 'teamA' => 'Portugal',      'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Croatia'],
            ['id' => 'G4', 'group' => 'Group G', 'date' => '2026-06-22T21:00:00Z', 'matchNumber' => 40, 'teamA' => 'USA',           'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Senegal'],
            ['id' => 'G5', 'group' => 'Group G', 'date' => '2026-06-27T18:00:00Z', 'matchNumber' => 41, 'teamA' => 'Portugal',      'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Senegal'],
            ['id' => 'G6', 'group' => 'Group G', 'date' => '2026-06-27T21:00:00Z', 'matchNumber' => 42, 'teamA' => 'USA',           'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Croatia'],

            // ---------- GROUP H ----------
            ['id' => 'H1', 'group' => 'Group H', 'date' => '2026-06-18T18:00:00Z', 'matchNumber' => 43, 'teamA' => 'Belgium',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Uruguay'],
            ['id' => 'H2', 'group' => 'Group H', 'date' => '2026-06-18T21:00:00Z', 'matchNumber' => 44, 'teamA' => 'Poland',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iran'],
            ['id' => 'H3', 'group' => 'Group H', 'date' => '2026-06-23T18:00:00Z', 'matchNumber' => 45, 'teamA' => 'Belgium',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Poland'],
            ['id' => 'H4', 'group' => 'Group H', 'date' => '2026-06-23T21:00:00Z', 'matchNumber' => 46, 'teamA' => 'Uruguay',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iran'],
            ['id' => 'H5', 'group' => 'Group H', 'date' => '2026-06-28T18:00:00Z', 'matchNumber' => 47, 'teamA' => 'Belgium',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Iran'],
            ['id' => 'H6', 'group' => 'Group H', 'date' => '2026-06-28T21:00:00Z', 'matchNumber' => 48, 'teamA' => 'Poland',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Uruguay'],

            // ---------- GROUP I ----------
            ['id' => 'I1', 'group' => 'Group I', 'date' => '2026-06-19T18:00:00Z', 'matchNumber' => 49, 'teamA' => 'Sweden',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ecuador'],
            ['id' => 'I2', 'group' => 'Group I', 'date' => '2026-06-19T21:00:00Z', 'matchNumber' => 50, 'teamA' => 'Turkey',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Africa'],
            ['id' => 'I3', 'group' => 'Group I', 'date' => '2026-06-24T18:00:00Z', 'matchNumber' => 51, 'teamA' => 'Sweden',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Turkey'],
            ['id' => 'I4', 'group' => 'Group I', 'date' => '2026-06-24T21:00:00Z', 'matchNumber' => 52, 'teamA' => 'Ecuador',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Africa'],
            ['id' => 'I5', 'group' => 'Group I', 'date' => '2026-06-29T18:00:00Z', 'matchNumber' => 53, 'teamA' => 'Sweden',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'South Africa'],
            ['id' => 'I6', 'group' => 'Group I', 'date' => '2026-06-29T21:00:00Z', 'matchNumber' => 54, 'teamA' => 'Turkey',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Ecuador'],

            // ---------- GROUP J ----------
            ['id' => 'J1', 'group' => 'Group J', 'date' => '2026-06-20T18:00:00Z', 'matchNumber' => 55, 'teamA' => 'Austria',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Japan'],
            ['id' => 'J2', 'group' => 'Group J', 'date' => '2026-06-20T21:00:00Z', 'matchNumber' => 56, 'teamA' => 'Costa Rica',    'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Tunisia'],
            ['id' => 'J3', 'group' => 'Group J', 'date' => '2026-06-25T18:00:00Z', 'matchNumber' => 57, 'teamA' => 'Austria',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Costa Rica'],
            ['id' => 'J4', 'group' => 'Group J', 'date' => '2026-06-25T21:00:00Z', 'matchNumber' => 58, 'teamA' => 'Japan',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Tunisia'],
            ['id' => 'J5', 'group' => 'Group J', 'date' => '2026-06-30T18:00:00Z', 'matchNumber' => 59, 'teamA' => 'Austria',       'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Tunisia'],
            ['id' => 'J6', 'group' => 'Group J', 'date' => '2026-06-30T21:00:00Z', 'matchNumber' => 60, 'teamA' => 'Japan',         'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Costa Rica'],

            // ---------- GROUP K ----------
            ['id' => 'K1', 'group' => 'Group K', 'date' => '2026-06-21T18:00:00Z', 'matchNumber' => 61, 'teamA' => 'Serbia',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Cameroon'],
            ['id' => 'K2', 'group' => 'Group K', 'date' => '2026-06-21T21:00:00Z', 'matchNumber' => 62, 'teamA' => 'Korea Republic', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Paraguay'],
            ['id' => 'K3', 'group' => 'Group K', 'date' => '2026-06-26T18:00:00Z', 'matchNumber' => 63, 'teamA' => 'Serbia',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Korea Republic'],
            ['id' => 'K4', 'group' => 'Group K', 'date' => '2026-06-26T21:00:00Z', 'matchNumber' => 64, 'teamA' => 'Cameroon',      'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Paraguay'],
            ['id' => 'K5', 'group' => 'Group K', 'date' => '2026-07-01T18:00:00Z', 'matchNumber' => 65, 'teamA' => 'Serbia',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Paraguay'],
            ['id' => 'K6', 'group' => 'Group K', 'date' => '2026-07-01T21:00:00Z', 'matchNumber' => 66, 'teamA' => 'Korea Republic', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Cameroon'],

            // ---------- GROUP L ----------
            ['id' => 'L1', 'group' => 'Group L', 'date' => '2026-06-22T18:00:00Z', 'matchNumber' => 67, 'teamA' => 'Netherlands',   'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Greece'],
            ['id' => 'L2', 'group' => 'Group L', 'date' => '2026-06-22T21:00:00Z', 'matchNumber' => 68, 'teamA' => 'Scotland',      'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Algeria'],
            ['id' => 'L3', 'group' => 'Group L', 'date' => '2026-06-27T18:00:00Z', 'matchNumber' => 69, 'teamA' => 'Netherlands',   'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Scotland'],
            ['id' => 'L4', 'group' => 'Group L', 'date' => '2026-06-27T21:00:00Z', 'matchNumber' => 70, 'teamA' => 'Greece',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Algeria'],
            ['id' => 'L5', 'group' => 'Group L', 'date' => '2026-07-02T18:00:00Z', 'matchNumber' => 71, 'teamA' => 'Netherlands',   'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Algeria'],
            ['id' => 'L6', 'group' => 'Group L', 'date' => '2026-07-02T21:00:00Z', 'matchNumber' => 72, 'teamA' => 'Greece',        'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'Scotland'],

            // ---------- ROUND OF 32 ----------
            ['id' => 'R32_1',  'group' => 'Round of 32', 'date' => '2026-07-05T18:00:00Z', 'matchNumber' => 73,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_2',  'group' => 'Round of 32', 'date' => '2026-07-05T21:00:00Z', 'matchNumber' => 74,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_3',  'group' => 'Round of 32', 'date' => '2026-07-06T18:00:00Z', 'matchNumber' => 75,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_4',  'group' => 'Round of 32', 'date' => '2026-07-06T21:00:00Z', 'matchNumber' => 76,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_5',  'group' => 'Round of 32', 'date' => '2026-07-07T18:00:00Z', 'matchNumber' => 77,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_6',  'group' => 'Round of 32', 'date' => '2026-07-07T21:00:00Z', 'matchNumber' => 78,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_7',  'group' => 'Round of 32', 'date' => '2026-07-08T18:00:00Z', 'matchNumber' => 79,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_8',  'group' => 'Round of 32', 'date' => '2026-07-08T21:00:00Z', 'matchNumber' => 80,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_9',  'group' => 'Round of 32', 'date' => '2026-07-09T18:00:00Z', 'matchNumber' => 81,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_10', 'group' => 'Round of 32', 'date' => '2026-07-09T21:00:00Z', 'matchNumber' => 82,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_11', 'group' => 'Round of 32', 'date' => '2026-07-10T18:00:00Z', 'matchNumber' => 83,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_12', 'group' => 'Round of 32', 'date' => '2026-07-10T21:00:00Z', 'matchNumber' => 84,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_13', 'group' => 'Round of 32', 'date' => '2026-07-11T18:00:00Z', 'matchNumber' => 85,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_14', 'group' => 'Round of 32', 'date' => '2026-07-11T21:00:00Z', 'matchNumber' => 86,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_15', 'group' => 'Round of 32', 'date' => '2026-07-12T18:00:00Z', 'matchNumber' => 87,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R32_16', 'group' => 'Round of 32', 'date' => '2026-07-12T21:00:00Z', 'matchNumber' => 88,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- ROUND OF 16 ----------
            ['id' => 'R16_1', 'group' => 'Round of 16', 'date' => '2026-07-14T18:00:00Z', 'matchNumber' => 89,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_2', 'group' => 'Round of 16', 'date' => '2026-07-14T21:00:00Z', 'matchNumber' => 90,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_3', 'group' => 'Round of 16', 'date' => '2026-07-15T18:00:00Z', 'matchNumber' => 91,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_4', 'group' => 'Round of 16', 'date' => '2026-07-15T21:00:00Z', 'matchNumber' => 92,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_5', 'group' => 'Round of 16', 'date' => '2026-07-16T18:00:00Z', 'matchNumber' => 93,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_6', 'group' => 'Round of 16', 'date' => '2026-07-16T21:00:00Z', 'matchNumber' => 94,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_7', 'group' => 'Round of 16', 'date' => '2026-07-17T18:00:00Z', 'matchNumber' => 95,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'R16_8', 'group' => 'Round of 16', 'date' => '2026-07-17T21:00:00Z', 'matchNumber' => 96,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- QUARTERFINALS ----------
            ['id' => 'QF1', 'group' => 'Quarterfinals', 'date' => '2026-07-20T18:00:00Z', 'matchNumber' => 97,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF2', 'group' => 'Quarterfinals', 'date' => '2026-07-20T21:00:00Z', 'matchNumber' => 98,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF3', 'group' => 'Quarterfinals', 'date' => '2026-07-21T18:00:00Z', 'matchNumber' => 99,  'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'QF4', 'group' => 'Quarterfinals', 'date' => '2026-07-21T21:00:00Z', 'matchNumber' => 100, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- SEMIFINALS ----------
            ['id' => 'SF1', 'group' => 'Semifinals', 'date' => '2026-07-24T21:00:00Z', 'matchNumber' => 101, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
            ['id' => 'SF2', 'group' => 'Semifinals', 'date' => '2026-07-25T21:00:00Z', 'matchNumber' => 102, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- THIRD PLACE ----------
            ['id' => 'TP1', 'group' => 'Third Place', 'date' => '2026-07-28T18:00:00Z', 'matchNumber' => 103, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],

            // ---------- FINAL ----------
            ['id' => 'FINAL', 'group' => 'Final', 'date' => '2026-07-29T18:00:00Z', 'matchNumber' => 104, 'teamA' => 'TBD', 'teamAGoals' => null, 'teamBGoals' => null, 'teamB' => 'TBD'],
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

    public static function groupedByGroup(): array
    {
        $groups = [];
        foreach (self::all() as $match) {
            $groups[$match['group']][] = $match;
        }
        return $groups;
    }
}
