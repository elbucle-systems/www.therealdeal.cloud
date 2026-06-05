<?php

namespace App\Notifications;

use App\Models\League;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeagueJoinRequestNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly League $league,
        private readonly User $requestingUser,
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
        return (new MailMessage)
            ->subject(__('app.notifications.join_request_subject', ['league' => $this->league->name]))
            ->greeting(__('app.notifications.email_greeting', ['username' => $notifiable->username]))
            ->line($this->message())
            ->action(__('app.notifications.review_join_requests'), route('leagues.members', $this->league->id));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event' => 'league_join_request',
            'league_id' => $this->league->id,
            'league_name' => $this->league->name,
            'requesting_user_id' => $this->requestingUser->id,
            'requesting_username' => $this->requestingUser->username,
            'message' => $this->message(),
            'action_url' => route('leagues.members', $this->league->id),
            'action_label' => __('app.notifications.review_join_requests'),
        ];
    }

    private function message(): string
    {
        return __('app.notifications.join_request_message', [
            'username' => $this->requestingUser->username,
            'league' => $this->league->name,
        ]);
    }
}
