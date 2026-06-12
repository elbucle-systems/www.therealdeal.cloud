<x-layout>
    <main class="matches-page">

        <a class="back-link" href="{{ route('leagues.show', $league->id) }}">
            <x-lucide-chevron-left width="16" height="16" />
            {{ __('app.league.back_to_league', ['league' => $league->name]) }}
        </a>

        <h1 class="matches-page__title">{{ __('app.actions.matches') }}</h1>

        <nav class="match-tabs">
            @if (!empty($groupStageKeys))
                <div class="match-tabs__row">
                    <span class="match-tabs__label">{{ __('app.league.groups') }}</span>
                    @foreach ($groupStageKeys as $gName)
                        <a class="match-tab {{ $gName === $activeStage ? 'match-tab--active' : '' }}"
                            href="{{ route('leagues.matches', [$league->id, 'stage' => $gName]) }}"
                            aria-current="{{ $gName === $activeStage ? 'page' : 'false' }}">
                            {{ \Illuminate\Support\Str::after($gName, 'Group ') }}
                        </a>
                    @endforeach
                </div>
            @endif
            @if (!empty($knockoutKeys))
                <div class="match-tabs__row">
                    <span class="match-tabs__label">{{ __('app.league.knockout') }}</span>
                    @foreach ($knockoutKeys as $gName)
                        <a class="match-tab {{ $gName === $activeStage ? 'match-tab--active' : '' }}"
                            href="{{ route('leagues.matches', [$league->id, 'stage' => $gName]) }}"
                            aria-current="{{ $gName === $activeStage ? 'page' : 'false' }}">
                            {{ $gName }}
                        </a>
                    @endforeach
                </div>
            @endif
        </nav>

        <div class="match-group">
            <h2 class="match-group__title">{{ $activeStage }}</h2>

            @if (!empty($realStandings))
                <section class="team-standings">
                    <article class="team-standings__panel">
                        <h3 class="team-standings__title">{{ __('app.league.real_standings') }}</h3>
                        <div class="team-table">
                            <div class="team-table__header">
                                <span>#</span>
                                <span>{{ __('app.league.team') }}</span>
                                <span>{{ __('app.league.played_short') }}</span>
                                <span>{{ __('app.league.wins_short') }}</span>
                                <span>{{ __('app.league.draws_short') }}</span>
                                <span>{{ __('app.league.losses_short') }}</span>
                                <span>{{ __('app.league.goals_for_short') }}</span>
                                <span>{{ __('app.league.goals_against_short') }}</span>
                                <span>{{ __('app.league.goal_difference_short') }}</span>
                                <span>{{ __('app.league.points_short') }}</span>
                            </div>
                            @foreach ($realStandings as $row)
                                <div class="team-table__row">
                                    <span class="team-table__rank">{{ $row['rank'] }}</span>
                                    <span class="team-table__team">{{ $row['team'] }}</span>
                                    <span>{{ $row['played'] }}</span>
                                    <span>{{ $row['wins'] }}</span>
                                    <span>{{ $row['draws'] }}</span>
                                    <span>{{ $row['losses'] }}</span>
                                    <span>{{ $row['goals_for'] }}</span>
                                    <span>{{ $row['goals_against'] }}</span>
                                    <span>{{ $row['goal_difference'] }}</span>
                                    <span class="team-table__points">{{ $row['points'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>

                    @foreach ($predictedStandingsByUser as $projection)
                        <article class="team-standings__panel">
                            <h3 class="team-standings__title">
                                {{ __('app.league.predicted_standings_for', ['username' => '@' . $projection['username']]) }}
                            </h3>
                            <div class="team-table">
                                <div class="team-table__header">
                                    <span>#</span>
                                    <span>{{ __('app.league.team') }}</span>
                                    <span>{{ __('app.league.played_short') }}</span>
                                    <span>{{ __('app.league.wins_short') }}</span>
                                    <span>{{ __('app.league.draws_short') }}</span>
                                    <span>{{ __('app.league.losses_short') }}</span>
                                    <span>{{ __('app.league.goals_for_short') }}</span>
                                    <span>{{ __('app.league.goals_against_short') }}</span>
                                    <span>{{ __('app.league.goal_difference_short') }}</span>
                                    <span>{{ __('app.league.points_short') }}</span>
                                </div>
                                @foreach ($projection['standings'] as $row)
                                    <div class="team-table__row">
                                        <span class="team-table__rank">{{ $row['rank'] }}</span>
                                        <span class="team-table__team">{{ $row['team'] }}</span>
                                        <span>{{ $row['played'] }}</span>
                                        <span>{{ $row['wins'] }}</span>
                                        <span>{{ $row['draws'] }}</span>
                                        <span>{{ $row['losses'] }}</span>
                                        <span>{{ $row['goals_for'] }}</span>
                                        <span>{{ $row['goals_against'] }}</span>
                                        <span>{{ $row['goal_difference'] }}</span>
                                        <span class="team-table__points">{{ $row['points'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </section>
            @endif

            <div class="matches">
                @foreach ($matches as $match)
                    @php
                        $locked = $match['locked'];
                        $predA = $match['userPrediction']['predicted_score_a'] ?? null;
                        $predB = $match['userPrediction']['predicted_score_b'] ?? null;
                        $predPoints = $match['userPrediction']['points'] ?? null;
                        $scoreA = $match['teamAGoals'];
                        $scoreB = $match['teamBGoals'];
                        $played = $scoreA !== null && $scoreB !== null;
                    @endphp

                    <section class="match">

                        <header class="match__header">
                            <time class="match__date" datetime="{{ $match['date'] }}"></time>
                            <span class="match__number">{{ __('app.league.match_number', ['number' => $match['matchNumber']]) }}</span>
                            @if (!$locked)
                                <span class="match__deadline-hint">{{ __('app.league.deadline') }}:
                                    <time datetime="{{ $match['deadline'] }}"></time></span>
                            @else
                                <span class="match__locked-badge">{{ __('app.league.locked') }}</span>
                            @endif
                        </header>

                        <main class="match__body">
                            <span class="match__team match__team--a">{{ $match['teamA'] }}</span>
                            <span class="match__result">
                                @if ($played)
                                    <span class="match__score">{{ $scoreA }}-{{ $scoreB }}</span>
                                @else
                                    <span class="match__vs">VS</span>
                                @endif
                            </span>
                            <span class="match__team match__team--b">{{ $match['teamB'] }}</span>
                        </main>

                        <footer class="match__footer">
                            <h4 class="predictions__title">{{ __('app.league.predictions') }}</h4>
                            <div class="predictions">

                                {{-- Own editable prediction --}}
                                <span class="prediction" data-match-id="{{ $match['id'] }}"
                                    data-league-id="{{ $league->id }}">
                                    <span class="prediction__user">
                                        {{ '@' . $currentUsername }}
                                        <span class="prediction__saved" style="display:none">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                            {{ __('app.league.saved') }}
                                        </span>
                                    </span>
                                    <span class="prediction__result">
                                        <span class="prediction__field">
                                            <input class="prediction__input prediction__input--a" type="number"
                                                min="0" max="50" placeholder="-"
                                                value="{{ $predA ?? '' }}"
                                                {{ $locked ? 'readonly disabled' : '' }} />
                                            <span class="prediction__error"></span>
                                        </span>
                                        <span class="prediction__separator">-</span>
                                        <span class="prediction__field">
                                            <input class="prediction__input prediction__input--b" type="number"
                                                min="0" max="50" placeholder="-"
                                            value="{{ $predB ?? '' }}"
                                            {{ $locked ? 'readonly disabled' : '' }} />
                                        </span>
                                    </span>
                                    <span class="prediction__points"
                                        title="{{ __('app.league.prediction_points') }}">
                                        {{ __('app.league.prediction_points_short') }}:
                                        {{ $predPoints ?? '-' }}
                                    </span>
                                </span>

                                {{-- Other members' readonly predictions --}}
                                @foreach ($match['memberPredictions'] as $mp)
                                    @if ($mp['username'] !== $currentUsername)
                                        <span class="prediction">
                                            <span class="prediction__user">{{ '@' . $mp['username'] }}</span>
                                            <span class="prediction__result">
                                                <input class="prediction__input" type="number"
                                                    value="{{ $mp['predicted_score_a'] }}" readonly />
                                                <span class="prediction__separator">-</span>
                                                <input class="prediction__input" type="number"
                                                    value="{{ $mp['predicted_score_b'] }}" readonly />
                                            </span>
                                            <span class="prediction__points"
                                                title="{{ __('app.league.prediction_points') }}">
                                                {{ __('app.league.prediction_points_short') }}:
                                                {{ $mp['points'] ?? '-' }}
                                            </span>
                                        </span>
                                    @endif
                                @endforeach

                            </div>
                        </footer>

                    </section>
                @endforeach
            </div>
        </div>

    </main>

    @push('scripts')
        <script>
            window.matchMessages = {
                scoreRange: @js(__('app.api.score_range')),
                saveError: @js(__('app.api.save_error')),
                saveFailed: @js(__('app.api.save_failed')),
            };
        </script>
        @vite(['resources/js/matches.js'])
    @endpush
</x-layout>
