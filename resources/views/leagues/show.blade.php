<x-layout>
    <main class="league-detail">

        <a class="back-link" href="{{ route('leagues.index') }}">
            <x-lucide-chevron-left width="16" height="16" />
            {{ __('app.actions.back_to_leagues') }}
        </a>

        @if (session('success'))
            <p style="color:var(--primary-green);font-family:'Montserrat',sans-serif;font-size:14px">
                {{ session('success') }}</p>
        @endif
        @error('access')
            <p style="color:var(--secondary-orange);font-family:'Montserrat',sans-serif;font-size:14px">{{ $message }}
            </p>
        @enderror

        <div class="league-detail__header">
            <div class="league-detail__title-group">
                <h1 class="league-detail__title">{{ $league->name }}</h1>
                <div class="league-detail__code-row">
                    <span class="league-detail__code-label">{{ __('app.league.invite_code') }}</span>
                    <button class="league-detail__code" id="copy-code" data-code="{{ $league->unique_code }}"
                        title="{{ __('app.league.copy_title') }}">
                        {{ $league->unique_code }}
                        <span id="copy-icon">
                            <x-lucide-clipboard-copy width="14" height="14"
                                style="margin-left:6px;vertical-align:middle" />
                        </span>
                    </button>
                    <span class="league-detail__code-hint">{{ __('app.league.click_to_copy') }}</span>
                </div>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-start">
                @if ($isManager)
                    <a class="btn btn--ghost" href="{{ route('leagues.members', $league->id) }}">
                        <x-lucide-users width="15" height="15" />
                        {{ __('app.actions.members') }}
                    </a>
                    <a class="btn btn--secondary" href="{{ route('leagues.edit', $league->id) }}">
                        <x-lucide-pencil width="15" height="15" />
                        {{ __('app.actions.edit') }}
                    </a>
                @endif
                @if ($league->member_status === 'approved')
                    <a class="btn btn--primary" href="{{ route('leagues.matches', $league->id) }}">
                        <x-lucide-calendar width="15" height="15" />
                        {{ __('app.actions.matches') }}
                    </a>
                @endif
            </div>
        </div>

        @if ($league->member_status === 'pending')
            <div class="league-detail__pending-notice">
                {{ __('app.league.pending_notice') }}
            </div>
        @endif

        {{-- Settings summary --}}
        <div class="league-settings">
            <div class="league-settings__item">
                <span class="league-settings__label">{{ __('app.league.points_exact') }}</span>
                <span class="league-settings__value">{{ $league->points_per_score }}</span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">{{ __('app.league.points_result') }}</span>
                <span class="league-settings__value">{{ $league->points_per_result }}</span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">{{ __('app.league.deadline') }}</span>
                <span class="league-settings__value">
                    {{ trans_choice('app.league.deadline_summary', $league->deadline_days, [
                        'count' => $league->deadline_days,
                        'mode' => $league->grouped_deadline ? __('app.league.grouped') : __('app.league.per_match'),
                    ]) }}
                </span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">{{ __('app.league.show_predictions_early') }}</span>
                <span class="league-settings__value">
                    {{ $league->predictions_visible_before_game ? __('app.league.visible_before_kickoff') : __('app.league.hidden_until_kickoff') }}
                </span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">{{ __('app.league.max_members') }}</span>
                <span class="league-settings__value">
                    {{ $league->members_size_limit ?? __('app.league.unlimited') }}
                </span>
            </div>
        </div>

        {{-- Standings --}}
        @if ($league->member_status === 'approved')
            <div>
                <h2 class="standings__section-title">{{ __('app.league.standings') }}</h2>
                <div class="standings">
                    <div class="standings__header">
                        <span>#</span>
                        <span>{{ __('app.league.player') }}</span>
                        <span style="text-align:center">{{ __('app.league.points') }}</span>
                        <span style="text-align:center">{{ __('app.league.exact') }}</span>
                        <span style="text-align:center">{{ __('app.league.result') }}</span>
                    </div>

                    @forelse ($standings as $i => $entry)
                        <div class="standings__row">
                            <span class="standings__rank">{{ $i + 1 }}</span>
                            <span class="standings__username">{{ $entry['username'] }}</span>
                            <span class="standings__points">{{ $entry['total_points'] }}</span>
                            <span class="standings__stat">{{ $entry['exact_score_count'] }}</span>
                            <span class="standings__stat">{{ $entry['correct_result_count'] }}</span>
                        </div>
                    @empty
                        <div class="standings__empty">{{ __('app.league.no_standings') }}</div>
                    @endforelse
                </div>
            </div>
        @endif

    </main>

    @push('scripts')
        @vite(['resources/js/league-show.js'])
    @endpush
</x-layout>
