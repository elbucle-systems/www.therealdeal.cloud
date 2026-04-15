<x-layout>
    <main class="matches-page">

        <a class="back-link" href="{{ route('leagues.show', $league->id) }}">
            <x-lucide-chevron-left width="16" height="16" />
            Back to {{ $league->name }}
        </a>

        <h1 class="matches-page__title">Matches</h1>

        <nav class="match-tabs">
            @if (!empty($groupStageKeys))
                <div class="match-tabs__row">
                    <span class="match-tabs__label">Groups</span>
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
                    <span class="match-tabs__label">Knockout</span>
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

            <div class="matches">
                @foreach ($matches as $match)
                    @php
                        $locked = $match['locked'];
                        $predA = $match['userPrediction']['predicted_score_a'] ?? null;
                        $predB = $match['userPrediction']['predicted_score_b'] ?? null;
                        $scoreA = $match['teamAGoals'];
                        $scoreB = $match['teamBGoals'];
                        $played = $scoreA !== null && $scoreB !== null;
                    @endphp

                    <section class="match">

                        <header class="match__header">
                            <time class="match__date" datetime="{{ $match['date'] }}"></time>
                            <span class="match__number">Match #{{ $match['matchNumber'] }}</span>
                            @if (!$locked)
                                <span class="match__deadline-hint">Deadline:
                                    <time datetime="{{ $match['deadline'] }}"></time></span>
                            @else
                                <span class="match__locked-badge">Locked</span>
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
                            <h4 class="predictions__title">Predictions</h4>
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
                                            saved
                                        </span>
                                    </span>
                                    <span class="prediction__result">
                                        <span class="prediction__field">
                                            <input class="prediction__input prediction__input--a" type="number"
                                                min="0" max="50" placeholder="–"
                                                value="{{ $predA ?? '' }}"
                                                {{ $locked ? 'readonly disabled' : '' }} />
                                            <span class="prediction__error"></span>
                                        </span>
                                        <span class="prediction__separator">-</span>
                                        <span class="prediction__field">
                                            <input class="prediction__input prediction__input--b" type="number"
                                                min="0" max="50" placeholder="–"
                                                value="{{ $predB ?? '' }}"
                                                {{ $locked ? 'readonly disabled' : '' }} />
                                        </span>
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
        @vite(['resources/js/matches.js'])
    @endpush
</x-layout>
