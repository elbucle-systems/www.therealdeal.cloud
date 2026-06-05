<x-layout>
    <main class="content content--centered-top">

        <a class="back-link" href="{{ route('leagues.index') }}">
            <x-lucide-chevron-left width="16" height="16" />
            {{ __('app.actions.back_to_leagues') }}
        </a>

        <form class="form" method="GET" action="{{ route('leagues.join') }}">
            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-key-round width="32" height="32" />
                    <h2 class="form__title">{{ __('app.league.join_title') }}</h2>
                </div>
                <p class="form__subtitle">{{ __('app.league.join_subtitle') }}</p>
            </header>

            <div class="form__content">
                <div class="form__field">
                    <label class="form__label" for="unique_code">{{ __('app.league.invite_code_label') }}</label>
                    <input class="form__input" id="unique_code" name="unique_code" type="text" maxlength="6"
                        placeholder="XXXXXX" style="text-transform:uppercase;letter-spacing:0.2em"
                        value="{{ old('unique_code', request('unique_code')) }}" oninput="this.value=this.value.toUpperCase()">
                    @error('unique_code')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form__footer">
                <a class="form__link" href="{{ route('leagues.index') }}">{{ __('app.actions.cancel') }}</a>
                <button class="form__button" type="submit">{{ __('app.rules.preview_rules') }}</button>
            </div>
        </form>

        @if ($previewLeague && $previewRules)
            <form class="form" method="POST" action="{{ route('leagues.join.post') }}">
                @csrf
                <input type="hidden" name="unique_code" value="{{ $previewLeague->unique_code }}">

                <header class="form__header">
                    <div class="form__title-content">
                        <x-lucide-clipboard-list width="32" height="32" />
                        <h2 class="form__title">{{ __('app.rules.preview_title', ['league' => $previewLeague->name]) }}</h2>
                    </div>
                    <p class="form__subtitle">{{ __('app.rules.preview_subtitle') }}</p>
                </header>

                <div class="form__content">
                    <ul class="rules-list">
                        @foreach ($previewRules['lines'] as $line)
                            <li>{{ $line }}</li>
                        @endforeach
                    </ul>

                    <label class="rules-confirm">
                        <input type="checkbox" name="rules_confirmed" value="1" required>
                        {{ __('app.rules.confirm') }}
                    </label>
                    @error('rules_confirmed')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__footer">
                    <a class="form__link" href="{{ route('leagues.join') }}">{{ __('app.actions.cancel') }}</a>
                    <button class="form__button" type="submit">{{ __('app.actions.join_league') }}</button>
                </div>
            </form>
        @endif

    </main>
</x-layout>
