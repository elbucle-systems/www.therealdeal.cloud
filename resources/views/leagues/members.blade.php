<x-layout>
    <main class="members-page">
        <a class="back-link" href="{{ route('leagues.show', $league->id) }}">
            <x-lucide-chevron-left width="16" height="16" />
            {{ __('app.league.back_to_league', ['league' => $league->name]) }}
        </a>

        <h1 class="members-page__title">{{ __('app.actions.members') }}</h1>

        @if (session('success'))
            <p style="color:var(--primary-green);font-family:'Montserrat',sans-serif;font-size:14px;margin-bottom:16px">
                {{ session('success') }}</p>
        @endif

        @if ($pending->isNotEmpty())
            <h2 class="members__section-title">{{ __('app.league.pending_requests') }}</h2>
            <div class="members__list">
                @foreach ($pending as $member)
                    <div class="members__row">
                        <div class="members__info">
                            <span class="members__username">{{ $member['username'] }}</span>
                            <span class="members__joined">{{ __('app.league.requested_at', ['time' => \Carbon\Carbon::parse($member['joined_at'])->diffForHumans()]) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Approved members --}}
        <h2 class="members__section-title">{{ __('app.league.approved_members') }}</h2>

        @if ($approved->isEmpty())
            <p style="font-family:'Montserrat',sans-serif;font-size:14px;color:var(--subtext-color)">{{ __('app.league.no_approved_members') }}</p>
        @else
            <div class="members__list">
                @foreach ($approved as $member)
                    <div class="members__row">
                        <div class="members__info">
                            <span class="members__username">{{ $member['username'] }}</span>
                            <span class="members__joined">{{ __('app.league.joined_at', ['time' => \Carbon\Carbon::parse($member['joined_at'])->diffForHumans()]) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </main>
</x-layout>
