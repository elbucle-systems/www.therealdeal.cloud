<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Throwable;

class WorldCupMatchRepository
{
    private const CACHE_KEY = 'fifa_world_cup_2026_matches_v2';

    public function __construct(
        private readonly FifaWorldCupResultsClient $client,
        private readonly FifaWorldCupResultNormalizer $normalizer,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $snapshot = $this->cache()->get(self::CACHE_KEY);
        if (is_array($snapshot)) {
            return $snapshot['matches'] ?? [];
        }

        try {
            $matches = $this->normalizer->normalize($this->client->matches());
        } catch (Throwable) {
            return [];
        }

        $this->cache()->put(self::CACHE_KEY, [
            'matches' => $matches,
            'fetched_at' => CarbonImmutable::now('UTC')->toIso8601ZuluString(),
        ], (int) config('services.fifa.cache_ttl_seconds', 300));

        return $matches;
    }

    public function find(string $id): ?array
    {
        foreach ($this->all() as $match) {
            if ($match['id'] === $id) {
                return $match;
            }
        }

        return null;
    }

    public function lastFetchedAt(): ?CarbonImmutable
    {
        $snapshot = $this->cache()->get(self::CACHE_KEY);

        if (! is_array($snapshot) || empty($snapshot['fetched_at'])) {
            return null;
        }

        return CarbonImmutable::parse($snapshot['fetched_at'])->utc();
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
        return array_values(array_filter($this->all(), fn (array $match) => $this->receivesDeadlineReminders($match)));
    }

    private function cache(): \Illuminate\Contracts\Cache\Repository
    {
        return Cache::store((string) config('services.fifa.cache_store', 'file'));
    }
}
