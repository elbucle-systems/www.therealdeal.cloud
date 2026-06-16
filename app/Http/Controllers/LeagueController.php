<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\MatchPrediction;
use App\Notifications\LeagueRulesNotification;
use App\Services\ActiveLeagueResolver;
use App\Services\LeagueRulesSummary;
use App\Services\StandingsCalculator;
use App\Services\WorldCupMatchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{
    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function activeLeague(): ?League
    {
        return app(ActiveLeagueResolver::class)->active();
    }

    private function redirectToActiveLeague()
    {
        $activeLeague = $this->activeLeague();

        abort_unless($activeLeague, 404);

        return redirect()->route('leagues.show', $activeLeague->id);
    }

    private function outcomeSign(int $a, int $b): int
    {
        if ($a > $b) {
            return 1;
        }
        if ($a < $b) {
            return -1;
        }

        return 0;
    }

    private function computeStandings(League $league, $approvedMembers = null): array
    {
        $now = now();
        $matchRepository = app(WorldCupMatchRepository::class);

        if ($approvedMembers === null) {
            $approvedMembers = $league->members()
                ->where('status', 'approved')
                ->with('user:id,username')
                ->get();
        }

        if ($approvedMembers->isEmpty()) {
            return [];
        }

        // Scope to this league via FK — avoids cross-league contamination
        $predictions = MatchPrediction::where('league_id', $league->id)->get();

        // Build lookup: username → matchId → prediction
        $predMap = [];
        foreach ($predictions as $pred) {
            $predMap[$pred->username][$pred->match_id] = $pred;
        }

        $pointsPerScore = $league->points_per_score;
        $pointsPerResult = $league->points_per_result;

        $playedMatches = array_filter(
            $matchRepository->all(),
            fn ($m) => $matchRepository->kickoff($m)->lt($now)
                && $m['teamAGoals'] !== null
                && $m['teamBGoals'] !== null
        );

        $standings = [];
        foreach ($approvedMembers as $member) {
            $username = $member->user->username;
            $totalPoints = 0;
            $exactScoreCount = 0;
            $correctResultCount = 0;

            foreach ($playedMatches as $match) {
                $pred = $predMap[$username][$match['id']] ?? null;
                if (! $pred) {
                    continue;
                }

                $exactScore = $pred->predicted_score_a === $match['teamAGoals']
                    && $pred->predicted_score_b === $match['teamBGoals'];

                $correctResult = $this->outcomeSign($pred->predicted_score_a, $pred->predicted_score_b)
                    === $this->outcomeSign($match['teamAGoals'], $match['teamBGoals']);

                if ($exactScore) {
                    $totalPoints += $pointsPerScore;
                    $exactScoreCount++;
                } elseif ($correctResult) {
                    $totalPoints += $pointsPerResult;
                    $correctResultCount++;
                }
            }

            $standings[] = [
                'user_id' => $member->user_id,
                'username' => $username,
                'total_points' => $totalPoints,
                'exact_score_count' => $exactScoreCount,
                'correct_result_count' => $correctResultCount,
            ];
        }

        usort($standings, function (array $a, array $b): int {
            return ($b['total_points'] <=> $a['total_points'])
                ?: strcasecmp($a['username'], $b['username']);
        });

        return app(StandingsCalculator::class)->withCompetitionRanks(
            $standings,
            fn (array $row): int => $row['total_points']
        );
    }

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        return $this->redirectToActiveLeague();
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    // ─── Show ─────────────────────────────────────────────────────────────────

    public function show(int $id)
    {
        $userId = Auth::id();
        $activeLeague = $this->activeLeague();

        abort_unless($activeLeague, 404);

        if ($activeLeague->id !== $id) {
            return redirect()->route('leagues.show', $activeLeague->id);
        }

        $league = $activeLeague;

        $allMembers = $league->members()->with('user:id,username')->get();
        $membership = $allMembers->firstWhere('user_id', $userId);

        if (! $membership) {
            return redirect()->route('leagues.index')
                ->withErrors(['access' => __('app.flash.member_only')]);
        }

        $league->member_status = $membership->status;

        $approvedMembers = $allMembers->where('status', 'approved');
        $league->member_count = $approvedMembers->count();

        $standings = $membership->status === 'approved'
            ? $this->computeStandings($league, $approvedMembers)
            : [];

        $isManager = $league->manager_id === $userId;

        return view('leagues.show', compact('league', 'standings', 'isManager'));
    }

    // ─── Edit / Update ────────────────────────────────────────────────────────

    public function edit(int $id)
    {
        $league = $this->activeLeague();

        abort_unless($league, 404);

        if ($league->id !== $id) {
            return redirect()->route('leagues.edit', $league->id);
        }

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.show', $id);
        }

        return view('leagues.edit', compact('league'));
    }

    public function update(Request $request, int $id, LeagueRulesSummary $rules)
    {
        $league = $this->activeLeague();

        abort_unless($league, 404);

        if ($league->id !== $id) {
            return redirect()->route('leagues.edit', $league->id);
        }

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.show', $id);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', "unique:leagues,name,{$id}"],
            'points_per_score' => ['required', 'integer', 'min:0'],
            'points_per_result' => ['required', 'integer', 'min:0'],
            'predictions_visible_before_game' => ['sometimes', 'boolean'],
            'members_size_limit' => ['nullable', 'integer', 'min:2'],
        ]);

        $data['predictions_visible_before_game'] = $request->boolean('predictions_visible_before_game');
        $data['grouped_deadline'] = false;
        $data['deadline_days'] = 0;

        $trackedOriginal = $league->only($rules->trackedFields());

        $league->update($data);
        $league->refresh();

        $changedFields = array_values(array_filter(
            $rules->trackedFields(),
            fn (string $field) => $trackedOriginal[$field] != $league->{$field}
        ));

        if ($changedFields !== []) {
            $this->notifyMembersAboutRuleChange($league, $rules, $changedFields);
        }

        return redirect()->route('leagues.show', $id)
            ->with('success', __('app.flash.league_updated'));
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────

    // ─── Join ─────────────────────────────────────────────────────────────────

    // ─── Members ──────────────────────────────────────────────────────────────

    public function showMembers(int $id)
    {
        $league = $this->activeLeague();

        abort_unless($league, 404);

        if ($league->id !== $id) {
            return redirect()->route('leagues.members', $league->id);
        }

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.show', $id);
        }

        $members = $league->members()
            ->with('user:id,username')
            ->orderByRaw("FIELD(status,'pending','approved')")
            ->orderBy('joined_at')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'user_id' => $m->user_id,
                    'username' => $m->user->username,
                    'status' => $m->status,
                    'joined_at' => $m->joined_at,
                ];
            });

        $pending = $members->filter(fn ($m) => $m['status'] === 'pending')->values();
        $approved = $members->filter(fn ($m) => $m['status'] === 'approved')->values();

        return view('leagues.members', compact('league', 'pending', 'approved'));
    }

    /**
     * @param  array<int, string>  $changedFields
     */
    private function notifyMembersAboutRuleChange(League $league, LeagueRulesSummary $rules, array $changedFields): void
    {
        $ruleSummary = $rules->forLeague($league);

        $league->members()
            ->whereIn('status', ['pending', 'approved'])
            ->where('user_id', '!=', Auth::id())
            ->with('user')
            ->get()
            ->each(function ($membership) use ($ruleSummary, $changedFields): void {
                $membership->user->notify(
                    (new LeagueRulesNotification($ruleSummary, 'updated', $changedFields))
                        ->locale($membership->user->locale ?? config('app.locale'))
                );
            });
    }

    // ─── Matches ──────────────────────────────────────────────────────────────

    public function showMatches(Request $request, int $id)
    {
        $userId = Auth::id();
        $league = $this->activeLeague();

        abort_unless($league, 404);

        if ($league->id !== $id) {
            return redirect()->route('leagues.matches', ['id' => $league->id, 'stage' => $request->query('stage')]);
        }

        $matchRepository = app(WorldCupMatchRepository::class);

        $allMembers = $league->members()->with('user:id,username')->get();
        $membership = $allMembers->firstWhere('user_id', $userId);

        if (! $membership || $membership->status !== 'approved') {
            return redirect()->route('leagues.show', $id)
                ->withErrors(['access' => __('app.flash.must_be_approved')]);
        }

        $currentUsername = Auth::user()->username;

        // All stage keys in order (for the nav)
        $allMatches = $matchRepository->all();
        $allMatches = array_map(
            fn (array $match, int $index): array => $match + ['displayNumber' => $index + 1],
            $allMatches,
            array_keys($allMatches)
        );
        $allStages = $this->orderedStages(array_values(array_unique(array_column($allMatches, 'group'))));
        $groupStageKeys = array_values(array_filter($allStages, fn ($k) => str_starts_with($k, 'Group ')));
        $knockoutKeys = array_values(array_filter($allStages, fn ($k) => ! str_starts_with($k, 'Group ')));

        // Determine active stage from query string, default to first
        $activeStage = $request->query('stage', $allStages[0] ?? 'Group A');
        if (! in_array($activeStage, $allStages)) {
            $activeStage = $allStages[0];
        }

        $approvedUsernames = $allMembers->where('status', 'approved')
            ->pluck('user.username')->filter()->values()->all();

        $stageMatches = array_values(array_filter($allMatches, fn ($m) => $m['group'] === $activeStage));

        // Only fetch predictions for the active stage matches, scoped to this league via FK
        $stageMatchIds = array_column($stageMatches, 'id');

        $allPredictions = MatchPrediction::where('league_id', $league->id)
            ->whereIn('match_id', $stageMatchIds)
            ->get();

        // Build lookup: matchId → username → prediction
        $predMap = [];
        foreach ($allPredictions as $pred) {
            $predMap[$pred->match_id][$pred->username] = $pred;
        }

        $now = now();
        $isGroupStage = str_starts_with($activeStage, 'Group ');
        $realStandings = [];
        $predictedStandingsByUser = [];
        $currentUserPredictionsForStandings = [];
        $standingsCalculator = app(StandingsCalculator::class);

        if ($isGroupStage) {
            $realStandings = $standingsCalculator->teamStandings($stageMatches);
        }

        $matches = [];
        foreach ($stageMatches as $match) {
            $kickoff = $matchRepository->kickoff($match);
            $matchStarted = $kickoff->lte($now);

            $deadline = $kickoff;
            $locked = $now->gte($deadline);

            $matchPredMap = $predMap[$match['id']] ?? [];

            $userPred = isset($matchPredMap[$currentUsername])
                ? [
                    'predicted_score_a' => $matchPredMap[$currentUsername]->predicted_score_a,
                    'predicted_score_b' => $matchPredMap[$currentUsername]->predicted_score_b,
                    'points' => $standingsCalculator->predictionPoints(
                        $match,
                        $matchPredMap[$currentUsername]->predicted_score_a,
                        $matchPredMap[$currentUsername]->predicted_score_b,
                        $league->points_per_score,
                        $league->points_per_result
                    ),
                ]
                : null;

            if ($isGroupStage && $userPred !== null) {
                $currentUserPredictionsForStandings[$match['id']] = [
                    'predicted_score_a' => $userPred['predicted_score_a'],
                    'predicted_score_b' => $userPred['predicted_score_b'],
                ];
            }

            $memberPredictions = [];
            foreach ($matchPredMap as $uname => $pred) {
                if (
                    in_array($uname, $approvedUsernames) &&
                    (
                        $uname === $currentUsername
                        || $matchStarted
                    )
                ) {
                    $memberPredictions[] = [
                        'username' => $uname,
                        'predicted_score_a' => $pred->predicted_score_a,
                        'predicted_score_b' => $pred->predicted_score_b,
                        'points' => $standingsCalculator->predictionPoints(
                            $match,
                            $pred->predicted_score_a,
                            $pred->predicted_score_b,
                            $league->points_per_score,
                            $league->points_per_result
                        ),
                    ];
                }
            }

            $match['userPrediction'] = $userPred;
            $match['memberPredictions'] = $memberPredictions;
            $match['locked'] = $locked;
            $match['deadline'] = $deadline->toIso8601ZuluString();

            $matches[] = $match;
        }

        if ($isGroupStage) {
            $predictedStandingsByUser[] = [
                'username' => $currentUsername,
                'standings' => $standingsCalculator->teamStandings($stageMatches, $currentUserPredictionsForStandings),
            ];
        }

        return view('leagues.matches', compact(
            'league',
            'matches',
            'activeStage',
            'groupStageKeys',
            'knockoutKeys',
            'currentUsername',
            'realStandings',
            'predictedStandingsByUser'
        ));
    }

    /**
     * @param  array<int, string>  $stages
     * @return array<int, string>
     */
    private function orderedStages(array $stages): array
    {
        $order = array_flip([
            'Group A',
            'Group B',
            'Group C',
            'Group D',
            'Group E',
            'Group F',
            'Group G',
            'Group H',
            'Group I',
            'Group J',
            'Group K',
            'Group L',
            'Round of 32',
            'Round of 16',
            'Quarterfinals',
            'Semifinals',
            'Third Place',
            'Final',
        ]);

        usort($stages, function (string $a, string $b) use ($order): int {
            return ($order[$a] ?? PHP_INT_MAX) <=> ($order[$b] ?? PHP_INT_MAX)
                ?: strcasecmp($a, $b);
        });

        return $stages;
    }
}
