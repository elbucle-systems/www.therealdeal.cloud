<?php

namespace App\Services;

use App\Models\League;
use App\Models\MatchPrediction;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class DeadlineReminderService
{
    public function __construct(private readonly WorldCupMatchRepository $matches) {}

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
        $matches = collect($this->matches->deadlineReminderMatches());

        return $matches
            ->map(fn (array $match) => $this->matchDeadline($league, $match, $predictedLookup, $now, $windowEnd))
            ->filter()
            ->values();
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

        $deadline = $this->matches->kickoff($match);

        if ($this->outsideWindow($deadline, $now, $windowEnd)) {
            return null;
        }

        return [
            'key' => "league:{$league->id}:match:{$match['id']}:{$deadline->toIso8601ZuluString()}",
            'type' => 'match',
            'league_id' => $league->id,
            'league_name' => $league->name,
            'label' => "{$match['teamA']} vs {$match['teamB']}",
            'stage' => $match['group'],
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
