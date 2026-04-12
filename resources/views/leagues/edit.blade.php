<x-layout>
    <main class="content content--centered-top">

        <a class="back-link" href="{{ route('leagues.show', $league->id) }}">
            <x-lucide-chevron-left width="16" height="16" />
            Back to {{ $league->name }}
        </a>

        <form class="form form--wide" method="POST" action="{{ route('leagues.update', $league->id) }}">
            @csrf
            @method('PUT')

            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-settings width="32" height="32" />
                    <h2 class="form__title">Edit League</h2>
                </div>
                <p class="form__subtitle">Update your league settings below.</p>
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
                    <label class="form__label" for="name">League Name</label>
                    <input class="form__input" type="text" id="name" name="name"
                        placeholder="Enter a unique league name" value="{{ old('name', $league->name) }}" required
                        maxlength="100" />
                    @error('name')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="points_per_score">Points — Exact Score</label>
                        <input class="form__input" type="number" id="points_per_score" name="points_per_score"
                            value="{{ old('points_per_score', $league->points_per_score) }}" min="0"
                            max="100" required />
                        @error('points_per_score')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label" for="points_per_result">Points — Correct Result</label>
                        <input class="form__input" type="number" id="points_per_result" name="points_per_result"
                            value="{{ old('points_per_result', $league->points_per_result) }}" min="0"
                            max="100" required />
                        @error('points_per_result')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form__field">
                    <label class="form__label" for="members_size_limit">Max Members <span
                            style="opacity:0.6;font-size:12px;">(leave blank for unlimited)</span></label>
                    <input class="form__input" type="number" id="members_size_limit" name="members_size_limit"
                        value="{{ old('members_size_limit', $league->members_size_limit) }}" min="2"
                        max="1000" placeholder="Unlimited" />
                    @error('members_size_limit')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form__field">
                        <label class="form__label" for="deadline_days">Deadline (days before kick-off)</label>
                        <input class="form__input" type="number" id="deadline_days" name="deadline_days"
                            value="{{ old('deadline_days', $league->deadline_days) }}" min="0" max="30"
                            required />
                        @error('deadline_days')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__field">
                        <label class="form__label">Deadline Mode</label>
                        <label
                            style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                            <input type="checkbox" name="grouped_deadline" value="1"
                                {{ old('grouped_deadline', $league->grouped_deadline) ? 'checked' : '' }}>
                            Group deadline (first match of group)
                        </label>
                    </div>
                </div>

                <div class="form__field">
                    <label
                        style="display:flex;align-items:center;gap:8px;font-family:'Saira Stencil',cursive;font-size:14px;cursor:pointer">
                        <input type="checkbox" name="predictions_visible_before_game" value="1"
                            {{ old('predictions_visible_before_game', $league->predictions_visible_before_game) ? 'checked' : '' }}>
                        Show other members' predictions before kickoff
                    </label>
                </div>

            </div>

            <div class="form__footer">
                <a class="form__link" href="{{ route('leagues.show', $league->id) }}">Cancel</a>
                <button class="form__button" type="submit">SAVE CHANGES</button>
            </div>

        </form>

    </main>
</x-layout>
