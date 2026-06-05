<?php

namespace Tests\Unit;

use App\Data\WcMatches;
use PHPUnit\Framework\TestCase;

class WcMatchesTest extends TestCase
{
    public function test_schedule_has_104_unique_utc_matches(): void
    {
        $matches = WcMatches::all();

        $this->assertCount(104, $matches);
        $this->assertCount(104, array_unique(array_column($matches, 'id')));
        $matchNumbers = array_values(array_unique(array_column($matches, 'matchNumber')));
        sort($matchNumbers);
        $this->assertSame(range(1, 104), $matchNumbers);

        foreach ($matches as $match) {
            $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z$/', $match['date']);
            $this->assertSame($match['date'], WcMatches::kickoff($match)->toIso8601ZuluString());
        }
    }

    public function test_known_group_stage_kickoffs_match_current_schedule(): void
    {
        $knownMatches = [
            1 => ['Mexico', 'South Africa', '2026-06-11T19:00:00Z'],
            4 => ['United States', 'Paraguay', '2026-06-13T01:00:00Z'],
            20 => ['Austria', 'Jordan', '2026-06-16T04:00:00Z'],
            45 => ['England', 'Ghana', '2026-06-23T20:00:00Z'],
            59 => ['United States', 'Turkey', '2026-06-26T02:00:00Z'],
            104 => ['TBD', 'TBD', '2026-07-19T19:00:00Z'],
        ];

        foreach ($knownMatches as $matchNumber => [$teamA, $teamB, $date]) {
            $match = current(array_filter(
                WcMatches::all(),
                fn (array $match) => $match['matchNumber'] === $matchNumber
            ));

            $this->assertSame($teamA, $match['teamA']);
            $this->assertSame($teamB, $match['teamB']);
            $this->assertSame($date, $match['date']);
        }
    }

    public function test_deadline_days_are_exact_utc_24_hour_windows(): void
    {
        $match = WcMatches::find('A1');

        $this->assertSame('2026-06-10T19:00:00Z', WcMatches::deadline($match, 1)->toIso8601ZuluString());
        $this->assertSame('2026-06-11T19:00:00Z', WcMatches::deadline($match, 0)->toIso8601ZuluString());
    }

    public function test_deadline_reminders_only_include_group_stage_matches(): void
    {
        $matches = WcMatches::deadlineReminderMatches();

        $this->assertCount(72, $matches);
        $this->assertTrue(collect($matches)->every(
            fn (array $match) => str_starts_with($match['group'], 'Group ')
        ));
        $this->assertFalse(WcMatches::receivesDeadlineReminders(WcMatches::find('R32_1')));
        $this->assertFalse(WcMatches::receivesDeadlineReminders(WcMatches::find('FINAL')));
    }
}
