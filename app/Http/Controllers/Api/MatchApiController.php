<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeagueMember;
use App\Models\MatchPrediction;
use App\Services\ActiveLeagueResolver;
use App\Services\WorldCupMatchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchApiController extends Controller
{
    public function upsertPrediction(Request $request, int $leagueId, string $matchId)
    {
        $userId = Auth::id();
        $activeLeagueId = app(ActiveLeagueResolver::class)->activeId();

        if ($activeLeagueId !== $leagueId) {
            return response()->json(['error' => __('app.api.match_not_found')], 404);
        }

        // Gate: approved member of the league
        $membership = LeagueMember::where('league_id', $leagueId)
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->first();

        if (! $membership) {
            return response()->json(['error' => __('app.api.approved_member_required')], 403);
        }

        // Gate: match exists
        $matchRepository = app(WorldCupMatchRepository::class);
        $match = $matchRepository->find($matchId);
        if (! $match) {
            return response()->json(['error' => __('app.api.match_not_found')], 404);
        }

        // Gate: not locked (deadline has not passed)
        $league = $membership->league;
        $now = now();
        $kickoff = $matchRepository->kickoff($match);

        $deadline = $kickoff;

        if ($now->gte($deadline)) {
            return response()->json(['error' => __('app.api.prediction_locked')], 403);
        }

        $validated = $request->validate([
            'predicted_score_a' => ['required', 'integer', 'min:0', 'max:50'],
            'predicted_score_b' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        $username = Auth::user()->username;

        $prediction = MatchPrediction::where('match_id', $matchId)
            ->where('username', $username)
            ->first();

        if ($prediction && $prediction->league_id !== null && (int) $prediction->league_id !== $leagueId) {
            return response()->json(['error' => __('app.api.prediction_conflict')], 409);
        }

        MatchPrediction::updateOrCreate(
            ['match_id' => $matchId, 'username' => $username],
            [
                'predicted_score_a' => $validated['predicted_score_a'],
                'predicted_score_b' => $validated['predicted_score_b'],
                'league_id' => $leagueId,
            ]
        );

        return response()->json(['message' => __('app.api.prediction_saved')]);
    }
}
