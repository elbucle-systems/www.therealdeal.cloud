<x-layout>
    <main class="content content--centered-top">

        <a class="back-link" href="{{ route('leagues.index') }}">
            <x-lucide-chevron-left width="16" height="16" />
            Back to Leagues
        </a>

        <form class="form form--wide" method="POST" action="{{ route('leagues.store') }}">
            @csrf

            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-trophy width="32" height="32" />
                    <h2 class="form__title">Create League</h2>
                </div>
                <p class="form__subtitle">Set up your private league and invite friends with a unique code.</p>
            </header>

            <div class="form__content">

                <div class="form__field">
                    <label class="form__label" for="name">League Name</label>
                    <input class="form__input" id="name" name="name" type="text"
                        placeholder="Enter a unique league name" value="{{ old('name') }}">
                    @error('name')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="points_per_score">Points — Exact Score</label>
                        <input class="form__input" id="points_per_score" name="points_per_score" type="number"
                            min="0" value="{{ old('points_per_score', 3) }}">
                        @error('points_per_score')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label" for="points_per_result">Points — Correct Result</label>
                        <input class="form__input" id="points_per_result" name="points_per_result" type="number"
                            min="0" value="{{ old('points_per_result', 1) }}">
                        @error('points_per_result')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form__field">
                    <label class="form__label" for="members_size_limit">Max Members (leave empty for unlimited)</label>
                    <input class="form__input" id="members_size_limit" name="members_size_limit" type="number"
                        min="2" placeholder="Unlimited" value="{{ old('members_size_limit') }}">
                    @error('members_size_limit')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="deadline_days">Deadline (days before match)</label>
                        <input class="form__input" id="deadline_days" name="deadline_days" type="number" min="0"
                            value="{{ old('deadline_days', 1) }}">
                        @error('deadline_days')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label">Deadline Mode</label>
                        <label
                            style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                            <input type="checkbox" name="grouped_deadline" value="1"
                                {{ old('grouped_deadline') ? 'checked' : '' }}>
                            Group deadline (first match of group)
                        </label>
                    </div>
                </div>

                <div class="form__field">
                    <label
                        style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                        <input type="checkbox" name="predictions_visible_before_game" value="1"
                            {{ old('predictions_visible_before_game') ? 'checked' : '' }}>
                        Show other members' predictions before kickoff
                    </label>
                </div>

            </div>

            <div class="form__footer">
                <a class="form__link" href="{{ route('leagues.index') }}">Cancel</a>
                <button class="form__button" type="submit">CREATE LEAGUE</button>
            </div>

        </form>

    </main>
</x-layout>
