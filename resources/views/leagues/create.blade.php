<x-layout>
    <main class="content content--centered-top">

        <a class="back-link" href="{{ route('leagues.index') }}">
            <x-lucide-chevron-left width="16" height="16" />
            {{ __('app.actions.back_to_leagues') }}
        </a>

        <form class="form form--wide" method="POST" action="{{ route('leagues.store') }}">
            @csrf

            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-trophy width="32" height="32" />
                    <h2 class="form__title">{{ __('app.league.create_title') }}</h2>
                </div>
                <p class="form__subtitle">{{ __('app.league.create_subtitle') }}</p>
            </header>

            <div class="form__content">

                <div class="form__field">
                    <label class="form__label" for="name">{{ __('app.league.league_name') }}</label>
                    <input class="form__input" id="name" name="name" type="text"
                        placeholder="{{ __('app.league.league_name_placeholder') }}" value="{{ old('name') }}">
                    @error('name')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="points_per_score">{{ __('app.league.points_exact') }}</label>
                        <input class="form__input" id="points_per_score" name="points_per_score" type="number"
                            min="0" value="{{ old('points_per_score', 3) }}">
                        @error('points_per_score')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label" for="points_per_result">{{ __('app.league.points_result') }}</label>
                        <input class="form__input" id="points_per_result" name="points_per_result" type="number"
                            min="0" value="{{ old('points_per_result', 1) }}">
                        @error('points_per_result')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form__field">
                    <label class="form__label" for="members_size_limit">{{ __('app.league.max_members_empty') }}</label>
                    <input class="form__input" id="members_size_limit" name="members_size_limit" type="number"
                        min="2" placeholder="{{ __('app.league.unlimited') }}" value="{{ old('members_size_limit') }}">
                    @error('members_size_limit')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="deadline_days">{{ __('app.league.deadline_days_match') }}</label>
                        <input class="form__input" id="deadline_days" name="deadline_days" type="number" min="0"
                            value="{{ old('deadline_days', 1) }}">
                        @error('deadline_days')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label">{{ __('app.league.deadline_mode') }}</label>
                        <label
                            style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                            <input type="checkbox" name="grouped_deadline" value="1"
                                {{ old('grouped_deadline') ? 'checked' : '' }}>
                            {{ __('app.league.group_deadline') }}
                        </label>
                    </div>
                </div>

                <div class="form__field">
                    <label
                        style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                        <input type="checkbox" name="predictions_visible_before_game" value="1"
                            {{ old('predictions_visible_before_game') ? 'checked' : '' }}>
                        {{ __('app.league.show_predictions') }}
                    </label>
                </div>

            </div>

            <div class="form__footer">
                <a class="form__link" href="{{ route('leagues.index') }}">{{ __('app.actions.cancel') }}</a>
                <button class="form__button" type="submit">{{ __('app.actions.create_league') }}</button>
            </div>

        </form>

    </main>
</x-layout>
