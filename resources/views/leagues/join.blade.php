<x-layout>
    <main class="content content--centered-top">

        <a class="back-link" href="{{ route('leagues.index') }}">
            <x-lucide-chevron-left width="16" height="16" />
            Back to Leagues
        </a>

        <form class="form" method="POST" action="{{ route('leagues.join.post') }}">
            @csrf

            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-key-round width="32" height="32" />
                    <h2 class="form__title">Join a League</h2>
                </div>
                <p class="form__subtitle">Enter the 6-character code shared by the league manager.</p>
            </header>

            <div class="form__content">
                <div class="form__field">
                    <label class="form__label" for="unique_code">Invite Code</label>
                    <input class="form__input" id="unique_code" name="unique_code" type="text" maxlength="6"
                        placeholder="XXXXXX" style="text-transform:uppercase;letter-spacing:0.2em"
                        value="{{ old('unique_code') }}" oninput="this.value=this.value.toUpperCase()">
                    @error('unique_code')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form__footer">
                <a class="form__link" href="{{ route('leagues.index') }}">Cancel</a>
                <button class="form__button" type="submit">JOIN LEAGUE</button>
            </div>

        </form>

    </main>
</x-layout>
