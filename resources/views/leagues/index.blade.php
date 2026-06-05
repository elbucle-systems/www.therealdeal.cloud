<x-layout>
    <main class="leagues">

        <div class="leagues__header">
            <h1 class="leagues__title">{{ __('app.nav.my_leagues') }}</h1>
            <div class="leagues__actions">
                <a class="btn btn--primary" href="{{ route('leagues.join') }}">
                    <x-lucide-key-round width="16" height="16" />
                    {{ __('app.actions.join_league') }}
                </a>
                <a class="btn btn--secondary" href="{{ route('leagues.create') }}">
                    <x-lucide-plus width="16" height="16" />
                    {{ __('app.actions.create_league') }}
                </a>
            </div>
        </div>

        @if (session('success'))
            <p class="leagues__empty" style="color:var(--primary-green)">{{ session('success') }}</p>
        @endif

        {{-- Leagues I manage --}}
        <section>
            <h2 class="leagues__section-title">{{ __('app.league.leagues_i_manage') }}</h2>
            @if ($managing->isEmpty())
                <p class="leagues__empty">{{ __('app.league.managing_empty') }}</p>
            @else
                <div class="league-cards">
                    @foreach ($managing as $league)
                        <div class="league-card">
                            <a class="league-card__link" href="{{ route('leagues.show', $league->id) }}"
                                aria-label="{{ $league->name }}"></a>
                            <div class="league-card__info">
                                <h3 class="league-card__name">{{ $league->name }}</h3>
                                <div class="league-card__meta">
                                    <span>{{ trans_choice('app.league.approved_members_count', $league->member_count, ['count' => $league->member_count]) }}</span>
                                    <span>{!! __('app.league.points_summary', ['exact' => $league->points_per_score, 'result' => $league->points_per_result]) !!}</span>
                                </div>
                            </div>
                            <div class="league-card__badges">
                                <span class="league-card__code">{{ $league->unique_code }}</span>
                                <span class="league-card__manager-badge">{{ __('app.league.manager') }}</span>
                                <form method="POST" action="{{ route('leagues.destroy', $league->id) }}"
                                    onsubmit="return confirm(@js(__('app.league.delete_confirm', ['league' => $league->name])))">
                                    @csrf
                                    <button type="submit" class="btn btn--danger" aria-label="{{ __('app.league.delete_label') }}">
                                        <x-lucide-trash-2 width="14" height="14" />
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- Leagues I'm in --}}
        <section>
            <h2 class="leagues__section-title">{{ __('app.league.leagues_im_in') }}</h2>
            @if ($memberOf->isEmpty())
                <p class="leagues__empty">{{ __('app.league.members_empty') }}</p>
            @else
                <div class="league-cards">
                    @foreach ($memberOf as $league)
                        <div
                            class="league-card {{ $league->member_status !== 'approved' ? 'league-card--pending' : '' }}">
                            @if ($league->member_status === 'approved')
                                <a class="league-card__link" href="{{ route('leagues.show', $league->id) }}"
                                    aria-label="{{ $league->name }}"></a>
                            @endif
                            <div class="league-card__info">
                                <h3 class="league-card__name">{{ $league->name }}</h3>
                                <div class="league-card__meta">
                                    <span>{{ trans_choice('app.league.approved_members_count', $league->member_count, ['count' => $league->member_count]) }}</span>
                                    <span>{!! __('app.league.points_summary', ['exact' => $league->points_per_score, 'result' => $league->points_per_result]) !!}</span>
                                </div>
                            </div>
                            <div class="league-card__badges">
                                <span class="league-card__code">{{ $league->unique_code }}</span>
                                @if ($league->member_status === 'pending')
                                    <span class="league-card__status">{{ __('app.league.pending') }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </main>
</x-layout>
