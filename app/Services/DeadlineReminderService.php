<?php

namespace App\Services;

use App\Data\WcMatches;
use App\Models\League;
use App\Models\MatchPrediction;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class DeadlineReminderService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function upcomingForUser(User $user, ?int $windowHours = null, ?CarbonImmutable $now = null): array
    {
        $now ??= CarbonImmutable::now('UTC');
        $windowEnd = $windowHours === null ? null : $now->addHours($windowHours);

        return $user->leagueMembers()
            ->where('status', 'approved')
            ->with('league')
            ->get()
            ->flatMap(fn ($membership) => $this->upcomingForLeague($membership->league, $user, $now, $windowEnd))
            ->sortBy('deadline')
            ->values()
            ->all();
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    private function upcomingForLeague(League $league, User $user, CarbonImmutable $now, ?CarbonImmutable $windowEnd): Collection
    {
        $predictedMatchIds = MatchPrediction::query()
            ->where('league_id', $league->id)
            ->where('username', $user->username)
            ->pluck('match_id')
            ->all();

        $predictedLookup = array_fill_keys($predictedMatchIds, true);
        $matches = collect(WcMatches::deadlineReminderMatches());

        if ($league->grouped_deadline) {
            return $matches
                ->groupBy('group')
                ->map(fn (Collection $groupMatches, string $group) => $this->groupDeadline($league, $group, $groupMatches, $predictedLookup, $now, $windowEnd))
                ->filter()
                ->values();
        }

        return $matches
            ->map(fn (array $match) => $this->matchDeadline($league, $match, $predictedLookup, $now, $windowEnd))
            ->filter()
            ->values();
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $matches
     * @param  array<string, bool>  $predictedLookup
     * @return array<string, mixed>|null
     */
    private function groupDeadline(League $league, string $group, Collection $matches, array $predictedLookup, CarbonImmutable $now, ?CarbonImmutable $windowEnd): ?array
    {
        $deadline = $matches
            ->map(fn (array $match) => WcMatches::kickoff($match))
            ->sortBy(fn (CarbonImmutable $kickoff) => $kickoff->timestamp)
            ->first()
            ->subDays($league->deadline_days);

        if ($this->outsideWindow($deadline, $now, $windowEnd)) {
            return null;
        }

        $missingMatches = $matches
            ->reject(fn (array $match) => isset($predictedLookup[$match['id']]))
            ->values();

        if ($missingMatches->isEmpty()) {
            return null;
        }

        return [
            'key' => "league:{$league->id}:group:{$group}:{$deadline->toIso8601ZuluString()}",
            'type' => 'group',
            'league_id' => $league->id,
            'league_name' => $league->name,
            'label' => $group,
            'deadline' => $deadline->toIso8601ZuluString(),
            'deadline_utc' => $deadline,
            'missing_count' => $missingMatches->count(),
            'match_ids' => $missingMatches->pluck('id')->all(),
            'match_numbers' => $missingMatches->pluck('matchNumber')->all(),
        ];
    }

    /**
     * @param  array<string, bool>  $predictedLookup
     * @return array<string, mixed>|null
     */
    private function matchDeadline(League $league, array $match, array $predictedLookup, CarbonImmutable $now, ?CarbonImmutable $windowEnd): ?array
    {
        if (isset($predictedLookup[$match['id']])) {
            return null;
        }

        $deadline = WcMatches::deadline($match, $league->deadline_days);

        if ($this->outsideWindow($deadline, $now, $windowEnd)) {
            return null;
        }

        return [
            'key' => "league:{$league->id}:match:{$match['id']}:{$deadline->toIso8601ZuluString()}",
            'type' => 'match',
            'league_id' => $league->id,
            'league_name' => $league->name,
            'label' => "{$match['teamA']} vs {$match['teamB']}",
            'deadline' => $deadline->toIso8601ZuluString(),
            'deadline_utc' => $deadline,
            'missing_count' => 1,
            'match_ids' => [$match['id']],
            'match_numbers' => [$match['matchNumber']],
        ];
    }

    private function outsideWindow(CarbonImmutable $deadline, CarbonImmutable $now, ?CarbonImmutable $windowEnd): bool
    {
        if ($deadline->lte($now)) {
            return true;
        }

        return $windowEnd !== null && $deadline->gt($windowEnd);
    }
}
