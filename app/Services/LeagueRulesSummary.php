<?php

namespace App\Services;

use App\Models\League;

class LeagueRulesSummary
{
    /**
     * @return array<string, mixed>
     */
    public function forLeague(League $league): array
    {
        return [
            'league_id' => $league->id,
            'league_name' => $league->name,
            'points_per_score' => $league->points_per_score,
            'points_per_result' => $league->points_per_result,
            'deadline_days' => $league->deadline_days,
            'deadline_mode' => $league->grouped_deadline ? 'grouped' : 'per_match',
            'predictions_visible_before_game' => $league->predictions_visible_before_game,
            'members_size_limit' => $league->members_size_limit,
            'lines' => [
                __('app.rules.points', [
                    'score' => $league->points_per_score,
                    'result' => $league->points_per_result,
                ]),
                trans_choice('app.rules.deadline', $league->deadline_days, [
                    'count' => $league->deadline_days,
                    'mode' => $league->grouped_deadline ? __('app.league.grouped') : __('app.league.per_match'),
                ]),
                $league->predictions_visible_before_game
                    ? __('app.rules.predictions_visible')
                    : __('app.rules.predictions_hidden'),
                __('app.rules.members_limit', [
                    'limit' => $league->members_size_limit ?? __('app.league.unlimited'),
                ]),
            ],
        ];
    }

    /**
     * @return array<int, string>
     */
    public function trackedFields(): array
    {
        return [
            'points_per_score',
            'points_per_result',
            'predictions_visible_before_game',
            'members_size_limit',
            'grouped_deadline',
            'deadline_days',
        ];
    }
}
