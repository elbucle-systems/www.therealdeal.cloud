@props([
    'title',
    'standings' => [],
])

<section class="standings-block">
    <h2 class="standings__section-title">{{ $title }}</h2>
    <div class="standings">
        <div class="standings__header">
            <span>#</span>
            <span>{{ __('app.league.player') }}</span>
            <span style="text-align:center">{{ __('app.league.points') }}</span>
            <span style="text-align:center">{{ __('app.league.exact') }}</span>
            <span style="text-align:center">{{ __('app.league.result') }}</span>
        </div>

        @forelse ($standings as $entry)
            <div class="standings__row">
                <span class="standings__rank">{{ $entry['rank'] }}</span>
                <span class="standings__username">{{ $entry['username'] }}</span>
                <span class="standings__points">{{ $entry['total_points'] }}</span>
                <span class="standings__stat">{{ $entry['exact_score_count'] }}</span>
                <span class="standings__stat">{{ $entry['correct_result_count'] }}</span>
            </div>
        @empty
            <div class="standings__empty">{{ __('app.league.no_standings') }}</div>
        @endforelse
    </div>
</section>
