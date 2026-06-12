<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\MatchPrediction;
use App\Models\User;
use App\Notifications\LeagueJoinRequestNotification;
use App\Notifications\LeagueRulesNotification;
use App\Services\LeagueRulesSummary;
use App\Services\StandingsCalculator;
use App\Services\WorldCupMatchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{
    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function generateUniqueCode(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
            if (! League::where('unique_code', $code)->exists()) {
                return $code;
            }
        }
        throw new \RuntimeException('Could not generate a unique league code after 10 attempts');
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
        $userId = Auth::id();

        /** @var User $authUser */
        $authUser = Auth::user();
        $memberships = $authUser->leagueMembers()
            ->with(['league' => fn ($q) => $q->withCount(['members as member_count' => fn ($q) => $q->where('status', 'approved')])])
            ->get();

        $leagues = $memberships->map(function ($m) {
            $league = $m->league;
            $league->member_status = $m->status;

            return $league;
        });

        $managing = $leagues->filter(fn ($l) => $l->manager_id === $userId)->values();
        $memberOf = $leagues->filter(fn ($l) => $l->manager_id !== $userId)->values();

        return view('leagues.index', compact('managing', 'memberOf'));
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    public function create()
    {
        return view('leagues.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:leagues,name'],
            'points_per_score' => ['required', 'integer', 'min:0'],
            'points_per_result' => ['required', 'integer', 'min:0'],
            'predictions_visible_before_game' => ['sometimes', 'boolean'],
            'members_size_limit' => ['nullable', 'integer', 'min:2'],
            'grouped_deadline' => ['sometimes', 'boolean'],
            'deadline_days' => ['required', 'integer', 'min:0'],
        ]);

        $data['predictions_visible_before_game'] = $request->boolean('predictions_visible_before_game');
        $data['grouped_deadline'] = $request->boolean('grouped_deadline');
        $data['manager_id'] = Auth::id();
        $data['unique_code'] = $this->generateUniqueCode();

        $league = League::create($data);

        // Auto-approve manager as a member
        $league->members()->create([
            'user_id' => Auth::id(),
            'status' => 'approved',
        ]);

        return redirect()->route('leagues.show', $league->id)
            ->with('success', __('app.flash.league_created'));
    }

    // ─── Show ─────────────────────────────────────────────────────────────────

    public function show(int $id)
    {
        $userId = Auth::id();
        $league = League::findOrFail($id);

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
        $league = League::findOrFail($id);

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.show', $id);
        }

        return view('leagues.edit', compact('league'));
    }

    public function update(Request $request, int $id, LeagueRulesSummary $rules)
    {
        $league = League::findOrFail($id);

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.show', $id);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', "unique:leagues,name,{$id}"],
            'points_per_score' => ['required', 'integer', 'min:0'],
            'points_per_result' => ['required', 'integer', 'min:0'],
            'predictions_visible_before_game' => ['sometimes', 'boolean'],
            'members_size_limit' => ['nullable', 'integer', 'min:2'],
            'grouped_deadline' => ['sometimes', 'boolean'],
            'deadline_days' => ['required', 'integer', 'min:0'],
        ]);

        $data['predictions_visible_before_game'] = $request->boolean('predictions_visible_before_game');
        $data['grouped_deadline'] = $request->boolean('grouped_deadline');

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

    public function destroy(int $id)
    {
        $league = League::findOrFail($id);

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.index');
        }

        $league->delete();

        return redirect()->route('leagues.index')
            ->with('success', __('app.flash.league_deleted'));
    }

    // ─── Join ─────────────────────────────────────────────────────────────────

    public function join(Request $request, LeagueRulesSummary $rules)
    {
        $previewLeague = null;

        if ($request->filled('unique_code')) {
            $request->validate([
                'unique_code' => ['required', 'string', 'size:6', 'regex:/^[A-Z0-9]{6}$/'],
            ]);

            $previewLeague = League::where('unique_code', strtoupper($request->query('unique_code')))->first();

            if (! $previewLeague) {
                return redirect()->route('leagues.join')
                    ->withErrors(['unique_code' => __('app.flash.league_not_found')])
                    ->withInput();
            }
        }

        return view('leagues.join', [
            'previewLeague' => $previewLeague,
            'previewRules' => $previewLeague ? $rules->forLeague($previewLeague) : null,
        ]);
    }

    public function processJoin(Request $request, LeagueRulesSummary $rules)
    {
        $request->validate([
            'unique_code' => ['required', 'string', 'size:6', 'regex:/^[A-Z0-9]{6}$/'],
            'rules_confirmed' => ['accepted'],
        ]);

        $code = strtoupper($request->input('unique_code'));
        $userId = Auth::id();
        $league = League::where('unique_code', $code)->first();

        if (! $league) {
            return back()->withErrors(['unique_code' => __('app.flash.league_not_found')])->withInput();
        }

        $existing = $league->members()->where('user_id', $userId)->first();

        if ($existing) {
            $msg = $existing->status === 'approved'
                ? __('app.flash.you_are_member')
                : __('app.flash.join_request_pending');

            return back()->withErrors(['unique_code' => $msg])->withInput();
        }

        if ($league->members_size_limit !== null) {
            $count = $league->members()->where('status', 'approved')->count();
            if ($count >= $league->members_size_limit) {
                return back()->withErrors(['unique_code' => __('app.flash.league_full')])->withInput();
            }
        }

        $league->members()->create([
            'user_id' => $userId,
            'status' => 'pending',
        ]);

        Auth::user()->notify(
            (new LeagueRulesNotification($rules->forLeague($league), 'joined'))
                ->locale(Auth::user()->locale ?? config('app.locale'))
        );

        if ($league->manager) {
            $league->manager->notify(
                (new LeagueJoinRequestNotification($league, Auth::user()))
                    ->locale($league->manager->locale ?? config('app.locale'))
            );
        }

        return redirect()->route('leagues.show', $league->id)
            ->with('success', __('app.flash.join_request_sent'));
    }

    // ─── Members ──────────────────────────────────────────────────────────────

    public function showMembers(int $id)
    {
        $league = League::findOrFail($id);

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

    public function approveMember(Request $request, int $id, int $userId)
    {
        $league = League::findOrFail($id);

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.show', $id);
        }

        if ($league->members_size_limit !== null) {
            $count = $league->members()->where('status', 'approved')->count();
            if ($count >= $league->members_size_limit) {
                return redirect()->route('leagues.members', $id)
                    ->withErrors(['approve' => __('app.flash.league_full_approve')]);
            }
        }

        $league->members()
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->update(['status' => 'approved']);

        if ($user = User::find($userId)) {
            $rules = app(LeagueRulesSummary::class);
            $user->notify(
                (new LeagueRulesNotification($rules->forLeague($league), 'approved'))
                    ->locale($user->locale ?? config('app.locale'))
            );
        }

        return redirect()->route('leagues.members', $id);
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

    public function removeMember(Request $request, int $id, int $userId)
    {
        $league = League::findOrFail($id);

        if ($league->manager_id !== Auth::id()) {
            return redirect()->route('leagues.show', $id);
        }

        if ($userId === Auth::id()) {
            return redirect()->route('leagues.members', $id)
                ->withErrors(['remove' => __('app.flash.manager_cannot_remove_self')]);
        }

        $league->members()
            ->where('user_id', $userId)
            ->delete();

        return redirect()->route('leagues.members', $id);
    }

    // ─── Matches ──────────────────────────────────────────────────────────────

    public function showMatches(Request $request, int $id)
    {
        $userId = Auth::id();
        $league = League::findOrFail($id);
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
        $fifaResultsLastUpdated = $matchRepository->lastFetchedAt();
        $fifaResultsUnavailable = $fifaResultsLastUpdated === null || $allMatches === [];
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

        // Only fetch predictions for the active stage matches, scoped to this league via FK
        $stageMatchIds = array_column(
            array_filter($allMatches, fn ($m) => $m['group'] === $activeStage),
            'id'
        );

        $allPredictions = MatchPrediction::where('league_id', $league->id)
            ->whereIn('match_id', $stageMatchIds)
            ->get();

        // Build lookup: matchId → username → prediction
        $predMap = [];
        foreach ($allPredictions as $pred) {
            $predMap[$pred->match_id][$pred->username] = $pred;
        }

        $now = now();
        $predictionsVisibleBefore = $league->predictions_visible_before_game;
        $groupedDeadline = $league->grouped_deadline;
        $deadlineDays = $league->deadline_days;

        // Precompute first kickoff per group for grouped_deadline mode
        $groupFirstDate = [];
        if ($groupedDeadline) {
            foreach ($allMatches as $m) {
                $kickoff = $matchRepository->kickoff($m);
                if (! isset($groupFirstDate[$m['group']]) || $kickoff->lt($groupFirstDate[$m['group']])) {
                    $groupFirstDate[$m['group']] = $kickoff;
                }
            }
        }

        $stageMatches = array_values(array_filter($allMatches, fn ($m) => $m['group'] === $activeStage));
        $isGroupStage = str_starts_with($activeStage, 'Group ');
        $realStandings = [];
        $predictedStandingsByUser = [];
        $currentUserPredictionsForStandings = [];
        $standingsCalculator = app(StandingsCalculator::class);

        if ($isGroupStage) {
            $realStandings = $standingsCalculator->teamStandings($stageMatches);
        }

        $matches = [];
        foreach ($allMatches as $match) {
            if ($match['group'] !== $activeStage) {
                continue;
            }

            $kickoff = $matchRepository->kickoff($match);
            $matchStarted = $kickoff->lte($now);

            $reference = $groupedDeadline
                ? ($groupFirstDate[$match['group']] ?? $kickoff)
                : $kickoff;
            $deadline = $reference->subDays($deadlineDays);
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
                    ($uname === $currentUsername || $matchStarted || $predictionsVisibleBefore)
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
            'predictedStandingsByUser',
            'fifaResultsLastUpdated',
            'fifaResultsUnavailable'
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
