<?php

namespace App\Notifications;

use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeadlineReminderNotification extends Notification
{
    use Queueable;

    /**
     * @param  array<string, mixed>  $deadline
     */
    public function __construct(private readonly array $deadline) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('app.notifications.email_subject', ['league' => $this->deadline['league_name']]))
            ->greeting(__('app.notifications.email_greeting', ['username' => $notifiable->username]))
            ->line(__('app.notifications.email_intro', ['league' => $this->deadline['league_name']]))
            ->line($this->summary())
            ->line(__('app.notifications.email_deadline', ['deadline' => $this->deadlineForHumans()]))
            ->action(__('app.notifications.email_action'), $this->actionUrl());
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'deadline_key' => $this->deadline['key'],
            'league_id' => $this->deadline['league_id'],
            'league_name' => $this->deadline['league_name'],
            'label' => $this->deadline['label'],
            'type' => $this->deadline['type'],
            'stage' => $this->deadline['stage'] ?? null,
            'deadline' => $this->deadline['deadline'],
            'missing_count' => $this->deadline['missing_count'],
            'match_ids' => $this->deadline['match_ids'],
            'match_numbers' => $this->deadline['match_numbers'],
            'message' => $this->summary(),
            'action_url' => $this->actionUrl(),
            'action_label' => __('app.notifications.make_predictions'),
        ];
    }

    private function actionUrl(): string
    {
        if (! empty($this->deadline['stage'])) {
            return route('leagues.matches', [$this->deadline['league_id'], 'stage' => $this->deadline['stage']]);
        }

        return route('leagues.matches', $this->deadline['league_id']);
    }

    private function summary(): string
    {
        return trans_choice('app.notifications.summary', $this->deadline['missing_count'], [
            'count' => $this->deadline['missing_count'],
            'label' => $this->deadline['label'],
        ]);
    }

    private function deadlineForHumans(): string
    {
        return CarbonImmutable::parse($this->deadline['deadline'])
            ->setTimezone(config('app.timezone'))
            ->translatedFormat('M j, Y g:i A T');
    }
}
