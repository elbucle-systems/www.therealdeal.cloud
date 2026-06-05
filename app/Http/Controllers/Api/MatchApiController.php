<?php

namespace App\Http\Controllers\Api;

use App\Data\WcMatches;
use App\Http\Controllers\Controller;
use App\Models\LeagueMember;
use App\Models\MatchPrediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchApiController extends Controller
{
    public function upsertPrediction(Request $request, int $leagueId, string $matchId)
    {
        $userId = Auth::id();

        // Gate: approved member of the league
        $membership = LeagueMember::where('league_id', $leagueId)
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->first();

        if (! $membership) {
            return response()->json(['error' => __('app.api.approved_member_required')], 403);
        }

        // Gate: match exists
        $match = WcMatches::find($matchId);
        if (! $match) {
            return response()->json(['error' => __('app.api.match_not_found')], 404);
        }

        // Gate: not locked (deadline has not passed)
        $league = $membership->league;
        $now = now()->timestamp;
        $kickoff = strtotime($match['date']);

        if ($league->grouped_deadline) {
            $groupFirstDate = null;
            foreach (WcMatches::all() as $m) {
                if ($m['group'] === $match['group']) {
                    $d = strtotime($m['date']);
                    if ($groupFirstDate === null || $d < $groupFirstDate) {
                        $groupFirstDate = $d;
                    }
                }
            }
            $reference = $groupFirstDate ?? $kickoff;
        } else {
            $reference = $kickoff;
        }

        $deadlineTs = $reference - ($league->deadline_days * 86400);

        if ($now >= $deadlineTs) {
            return response()->json(['error' => __('app.api.prediction_locked')], 403);
        }

        $validated = $request->validate([
            'predicted_score_a' => ['required', 'integer', 'min:0', 'max:50'],
            'predicted_score_b' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        $username = Auth::user()->username;

        MatchPrediction::updateOrCreate(
            [
                'match_id' => $matchId,
                'username' => $username,
            ],
            [
                'predicted_score_a' => $validated['predicted_score_a'],
                'predicted_score_b' => $validated['predicted_score_b'],
                'league_id' => $leagueId,
            ]
        );

        return response()->json(['message' => __('app.api.prediction_saved')]);
    }
}
