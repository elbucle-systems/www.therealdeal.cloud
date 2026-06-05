<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeagueRulesNotification extends Notification
{
    use Queueable;

    /**
     * @param  array<string, mixed>  $rules
     * @param  array<int, string>  $changedFields
     */
    public function __construct(
        private readonly array $rules,
        private readonly string $event,
        private readonly array $changedFields = [],
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->subject())
            ->greeting(__('app.notifications.email_greeting', ['username' => $notifiable->username]))
            ->line($this->headline());

        foreach ($this->ruleLines() as $line) {
            $mail->line($line);
        }

        return $mail->action(__('app.rules.email_action'), route('leagues.show', $this->rules['league_id']));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event' => $this->event,
            'league_id' => $this->rules['league_id'],
            'league_name' => $this->rules['league_name'],
            'message' => $this->headline(),
            'rules' => [
                ...$this->rules,
                'lines' => $this->ruleLines(),
            ],
            'changed_fields' => $this->changedFields,
        ];
    }

    private function subject(): string
    {
        return match ($this->event) {
            'updated' => __('app.rules.email_subject_updated', ['league' => $this->rules['league_name']]),
            'approved' => __('app.rules.email_subject_approved', ['league' => $this->rules['league_name']]),
            default => __('app.rules.email_subject_joined', ['league' => $this->rules['league_name']]),
        };
    }

    private function headline(): string
    {
        return match ($this->event) {
            'updated' => __('app.rules.updated_headline', ['league' => $this->rules['league_name']]),
            'approved' => __('app.rules.approved_headline', ['league' => $this->rules['league_name']]),
            default => __('app.rules.joined_headline', ['league' => $this->rules['league_name']]),
        };
    }

    /**
     * @return array<int, string>
     */
    private function ruleLines(): array
    {
        return [
            __('app.rules.points', [
                'score' => $this->rules['points_per_score'],
                'result' => $this->rules['points_per_result'],
            ]),
            trans_choice('app.rules.deadline', $this->rules['deadline_days'], [
                'count' => $this->rules['deadline_days'],
                'mode' => $this->rules['deadline_mode'] === 'grouped'
                    ? __('app.league.grouped')
                    : __('app.league.per_match'),
            ]),
            $this->rules['predictions_visible_before_game']
                ? __('app.rules.predictions_visible')
                : __('app.rules.predictions_hidden'),
            __('app.rules.members_limit', [
                'limit' => $this->rules['members_size_limit'] ?? __('app.league.unlimited'),
            ]),
        ];
    }
}
