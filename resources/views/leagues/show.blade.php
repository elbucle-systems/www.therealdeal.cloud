<x-layout>
    <main class="league-detail">

        <a class="back-link" href="{{ route('leagues.index') }}">
            <x-lucide-chevron-left width="16" height="16" />
            Back to Leagues
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
                    <span class="league-detail__code-label">Invite code:</span>
                    <button class="league-detail__code" id="copy-code" data-code="{{ $league->unique_code }}"
                        title="Click to copy">
                        {{ $league->unique_code }}
                        <span id="copy-icon">
                            <x-lucide-clipboard-copy width="14" height="14"
                                style="margin-left:6px;vertical-align:middle" />
                        </span>
                    </button>
                    <span class="league-detail__code-hint">click to copy</span>
                </div>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-start">
                @if ($isManager)
                    <a class="btn btn--ghost" href="{{ route('leagues.members', $league->id) }}">
                        <x-lucide-users width="15" height="15" />
                        Members
                    </a>
                    <a class="btn btn--secondary" href="{{ route('leagues.edit', $league->id) }}">
                        <x-lucide-pencil width="15" height="15" />
                        Edit
                    </a>
                @endif
                @if ($league->member_status === 'approved')
                    <a class="btn btn--primary" href="{{ route('leagues.matches', $league->id) }}">
                        <x-lucide-calendar width="15" height="15" />
                        Matches
                    </a>
                @endif
            </div>
        </div>

        @if ($league->member_status === 'pending')
            <div class="league-detail__pending-notice">
                Your membership is pending approval from the league manager. You'll be able to view standings once
                approved.
            </div>
        @endif

        {{-- Settings summary --}}
        <div class="league-settings">
            <div class="league-settings__item">
                <span class="league-settings__label">Points — Exact Score</span>
                <span class="league-settings__value">{{ $league->points_per_score }}</span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">Points — Correct Result</span>
                <span class="league-settings__value">{{ $league->points_per_result }}</span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">Deadline</span>
                <span class="league-settings__value">
                    {{ $league->deadline_days }} day{{ $league->deadline_days !== 1 ? 's' : '' }} before
                    {{ $league->grouped_deadline ? '(grouped)' : '(per match)' }}
                </span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">Show Predictions Early</span>
                <span class="league-settings__value">
                    {{ $league->predictions_visible_before_game ? 'Yes — visible before kickoff' : 'No — hidden until kickoff' }}
                </span>
            </div>
            <div class="league-settings__item">
                <span class="league-settings__label">Max Members</span>
                <span class="league-settings__value">
                    {{ $league->members_size_limit ?? 'Unlimited' }}
                </span>
            </div>
        </div>

        {{-- Standings --}}
        @if ($league->member_status === 'approved')
            <div>
                <h2 class="standings__section-title">STANDINGS</h2>
                <div class="standings">
                    <div class="standings__header">
                        <span>#</span>
                        <span>Player</span>
                        <span style="text-align:center">Points</span>
                        <span style="text-align:center">Exact</span>
                        <span style="text-align:center">Result</span>
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
                        <div class="standings__empty">No predictions yet, or no matches have been played.</div>
                    @endforelse
                </div>
            </div>
        @endif

    </main>

    @push('scripts')
        @vite(['resources/js/league-show.js'])
    @endpush
</x-layout>
