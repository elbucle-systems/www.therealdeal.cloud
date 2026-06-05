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

        @error('approve')
            <p style="color:var(--secondary-orange);font-family:'Montserrat',sans-serif;font-size:14px;margin-bottom:16px">
                {{ $message }}</p>
        @enderror
        @error('remove')
            <p style="color:var(--secondary-orange);font-family:'Montserrat',sans-serif;font-size:14px;margin-bottom:16px">
                {{ $message }}</p>
        @enderror

        {{-- Pending requests --}}
        @if ($pending->isNotEmpty())
            <h2 class="members__section-title">{{ __('app.league.pending_requests') }}</h2>
            <div class="members__list">
                @foreach ($pending as $member)
                    <div class="members__row">
                        <div class="members__info">
                            <span class="members__username">{{ $member['username'] }}</span>
                            <span class="members__joined">{{ __('app.league.requested_at', ['time' => \Carbon\Carbon::parse($member['joined_at'])->diffForHumans()]) }}</span>
                        </div>
                        <div class="members__actions">
                            <form method="POST"
                                action="{{ route('leagues.members.approve', [$league->id, $member['user_id']]) }}">
                                @csrf
                                <button class="btn btn--primary btn--sm" type="submit">
                                    <x-lucide-check width="14" height="14" />
                                    {{ __('app.actions.approve') }}
                                </button>
                            </form>
                            <form method="POST"
                                action="{{ route('leagues.members.remove', [$league->id, $member['user_id']]) }}"
                                onsubmit="return confirm(@js(__('app.league.remove_confirm', ['username' => $member['username']])))">
                                @csrf
                                <button class="btn btn--ghost btn--sm" type="submit">
                                    <x-lucide-x width="14" height="14" />
                                    {{ __('app.actions.decline') }}
                                </button>
                            </form>
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
                        @if ($member['user_id'] !== auth()->id())
                            <div class="members__actions">
                                <form method="POST"
                                    action="{{ route('leagues.members.remove', [$league->id, $member['user_id']]) }}"
                                    onsubmit="return confirm(@js(__('app.league.remove_from_league_confirm', ['username' => $member['username']])))">
                                    @csrf
                                    <button class="btn btn--ghost btn--sm" type="submit">
                                        <x-lucide-x width="14" height="14" />
                                        {{ __('app.actions.remove') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </main>
</x-layout>
