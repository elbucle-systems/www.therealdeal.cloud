<?php

namespace App\Services;

use App\Data\WcMatches;
use Carbon\CarbonImmutable;

class WorldCupMatchRepository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        return WcMatches::all();
    }

    public function find(string $id): ?array
    {
        return WcMatches::find($id);
    }

    public function kickoff(string|array $match): CarbonImmutable
    {
        $date = is_array($match) ? $match['date'] : $match;

        return CarbonImmutable::parse($date)->utc();
    }

    public function deadline(string|array $match, int $deadlineDays): CarbonImmutable
    {
        return $this->kickoff($match)->subDays($deadlineDays);
    }

    public function receivesDeadlineReminders(array $match): bool
    {
        return str_starts_with($match['group'], 'Group ');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function deadlineReminderMatches(): array
    {
        return WcMatches::deadlineReminderMatches();
    }
}
