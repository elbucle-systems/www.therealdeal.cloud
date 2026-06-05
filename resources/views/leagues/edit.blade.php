<x-layout>
    <main class="content content--centered-top">

        <a class="back-link" href="{{ route('leagues.show', $league->id) }}">
            <x-lucide-chevron-left width="16" height="16" />
            {{ __('app.league.back_to_league', ['league' => $league->name]) }}
        </a>

        <form class="form form--wide" method="POST" action="{{ route('leagues.update', $league->id) }}">
            @csrf
            @method('PUT')

            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-settings width="32" height="32" />
                    <h2 class="form__title">{{ __('app.league.edit_title') }}</h2>
                </div>
                <p class="form__subtitle">{{ __('app.league.edit_subtitle') }}</p>
            </header>

            @if ($errors->any())
                <ul
                    style="margin:0;padding-left:18px;color:var(--secondary-orange);font-family:'Saira Stencil',cursive;font-size:14px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="form__content">

                <div class="form__field">
                    <label class="form__label" for="name">{{ __('app.league.league_name') }}</label>
                    <input class="form__input" type="text" id="name" name="name"
                        placeholder="{{ __('app.league.league_name_placeholder') }}"
                        value="{{ old('name', $league->name) }}" required maxlength="100" />
                    @error('name')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="points_per_score">{{ __('app.league.points_exact') }}</label>
                        <input class="form__input" type="number" id="points_per_score" name="points_per_score"
                            value="{{ old('points_per_score', $league->points_per_score) }}" min="0"
                            max="100" required />
                        @error('points_per_score')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label" for="points_per_result">{{ __('app.league.points_result') }}</label>
                        <input class="form__input" type="number" id="points_per_result" name="points_per_result"
                            value="{{ old('points_per_result', $league->points_per_result) }}" min="0"
                            max="100" required />
                        @error('points_per_result')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form__field">
                    <label class="form__label" for="members_size_limit">{!! __('app.league.max_members_blank') !!}</label>
                    <input class="form__input" type="number" id="members_size_limit" name="members_size_limit"
                        value="{{ old('members_size_limit', $league->members_size_limit) }}" min="2"
                        max="1000" placeholder="{{ __('app.league.unlimited') }}" />
                    @error('members_size_limit')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="deadline_days">{{ __('app.league.deadline_days_kickoff') }}</label>
                        <input class="form__input" type="number" id="deadline_days" name="deadline_days"
                            value="{{ old('deadline_days', $league->deadline_days) }}" min="0" max="30"
                            required />
                        @error('deadline_days')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label">{{ __('app.league.deadline_mode') }}</label>
                        <label
                            style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                            <input type="checkbox" name="grouped_deadline" value="1"
                                {{ old('grouped_deadline', $league->grouped_deadline) ? 'checked' : '' }}>
                            {{ __('app.league.group_deadline') }}
                        </label>
                    </div>
                </div>

                <div class="form__field">
                    <label
                        style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                        <input type="checkbox" name="predictions_visible_before_game" value="1"
                            {{ old('predictions_visible_before_game', $league->predictions_visible_before_game) ? 'checked' : '' }}>
                        {{ __('app.league.show_predictions') }}
                    </label>
                </div>

            </div>

            <div class="form__footer">
                <a class="form__link" href="{{ route('leagues.show', $league->id) }}">{{ __('app.actions.cancel') }}</a>
                <button class="form__button" type="submit">{{ __('app.actions.save_changes') }}</button>
            </div>

        </form>

    </main>
</x-layout>
