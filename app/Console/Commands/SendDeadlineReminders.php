<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\DeadlineReminderNotification;
use App\Services\DeadlineReminderService;
use Illuminate\Console\Command;

class SendDeadlineReminders extends Command
{
    protected $signature = 'deadlines:send-reminders {--window-hours=24 : Send reminders for deadlines within this many hours}';

    protected $description = 'Send in-app and email reminders for upcoming league prediction deadlines.';

    public function handle(DeadlineReminderService $deadlines): int
    {
        $windowHours = (int) $this->option('window-hours');
        $sent = 0;

        User::query()
            ->whereHas('leagueMembers', fn ($query) => $query->where('status', 'approved'))
            ->chunkById(100, function ($users) use ($deadlines, $windowHours, &$sent): void {
                foreach ($users as $user) {
                    foreach ($deadlines->upcomingForUser($user, $windowHours) as $deadline) {
                        if ($this->alreadySent($user, $deadline['key'])) {
                            continue;
                        }

                        $user->notify((new DeadlineReminderNotification($deadline))->locale($user->locale ?? config('app.locale')));
                        $sent++;
                    }
                }
            });

        $this->info("Sent {$sent} deadline reminder notification(s).");

        return self::SUCCESS;
    }

    private function alreadySent(User $user, string $deadlineKey): bool
    {
        return $user->notifications()
            ->where('type', DeadlineReminderNotification::class)
            ->where('data', 'like', '%"deadline_key":"'.$deadlineKey.'"%')
            ->exists();
    }
}
