<x-layout>
    <main class="content content--centered-top">
        <section class="notifications">
            <header class="notifications__header">
                <div>
                    <h1 class="notifications__title">{{ __('app.notifications.title') }}</h1>
                    <p class="notifications__subtitle">{{ __('app.notifications.subtitle') }}</p>
                </div>
            </header>

            <section class="notifications__section">
                <h2 class="notifications__section-title">{{ __('app.notifications.upcoming_deadlines') }}</h2>

                @forelse ($upcomingDeadlines as $deadline)
                    <article class="notification-card notification-card--deadline">
                        <div>
                            <h3 class="notification-card__title">
                                {{ $deadline['league_name'] }} - {{ $deadline['label'] }}
                            </h3>
                            <p class="notification-card__body">
                                {{ trans_choice('app.notifications.summary', $deadline['missing_count'], [
                                    'count' => $deadline['missing_count'],
                                    'label' => $deadline['label'],
                                ]) }}
                            </p>
                            <p class="notification-card__meta">
                                {{ __('app.notifications.deadline_at') }}
                                <time datetime="{{ $deadline['deadline'] }}"></time>
                            </p>
                        </div>
                        <a class="btn btn--primary btn--sm" href="{{ route('leagues.matches', $deadline['league_id']) }}">
                            {{ __('app.notifications.make_predictions') }}
                        </a>
                    </article>
                @empty
                    <p class="notifications__empty">{{ __('app.notifications.no_upcoming_deadlines') }}</p>
                @endforelse
            </section>

            <section class="notifications__section">
                <h2 class="notifications__section-title">{{ __('app.notifications.recent_notifications') }}</h2>

                @forelse ($notifications as $notification)
                    <article class="notification-card {{ $notification->read_at ? '' : 'notification-card--unread' }}">
                        <div>
                            <h3 class="notification-card__title">
                                {{ $notification->data['league_name'] ?? __('app.notifications.deadline_reminder') }}
                            </h3>
                            <p class="notification-card__body">
                                {{ $notification->data['message'] ?? __('app.notifications.deadline_reminder') }}
                            </p>
                            @if (!empty($notification->data['deadline']))
                                <p class="notification-card__meta">
                                    {{ __('app.notifications.deadline_at') }}
                                    <time datetime="{{ $notification->data['deadline'] }}"></time>
                                </p>
                            @endif
                        </div>

                        @if (!$notification->read_at)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button class="btn btn--ghost btn--sm" type="submit">
                                    {{ __('app.notifications.mark_read') }}
                                </button>
                            </form>
                        @endif
                    </article>
                @empty
                    <p class="notifications__empty">{{ __('app.notifications.no_notifications') }}</p>
                @endforelse
            </section>
        </section>
    </main>

    @push('scripts')
        <script>
            const notificationDateFormatter = new Intl.DateTimeFormat(document.documentElement.lang || undefined, {
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                hour: '2-digit',
                minute: '2-digit',
                timeZoneName: 'short',
            });

            document.querySelectorAll('time[datetime]').forEach(function (el) {
                el.textContent = notificationDateFormatter.format(new Date(el.getAttribute('datetime')));
            });
        </script>
    @endpush
</x-layout>
