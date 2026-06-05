<x-layout>
    <main class="landing">

        {{-- Hero --}}
        <section class="landing__hero">
            <h1 class="landing__headline">
                {!! __('app.landing.headline') !!}
            </h1>
            <p class="landing__sub">
                {{ __('app.landing.subtitle') }}
            </p>
            <div class="landing__cta-row">
                @auth
                    <a class="btn btn--primary btn--lg" href="{{ route('leagues.index') }}">
                        {{ __('app.nav.my_leagues') }}
                        <x-lucide-arrow-right width="18" height="18" />
                    </a>
                    <a class="btn btn--secondary btn--lg" href="{{ route('leagues.join') }}">
                        {{ __('app.actions.join_a_league') }}
                    </a>
                @else
                    <a class="btn btn--primary btn--lg" href="{{ route('register') }}">
                        {{ __('app.actions.get_started') }}
                        <x-lucide-arrow-right width="18" height="18" />
                    </a>
                    <a class="btn btn--ghost btn--lg" href="{{ route('login') }}">
                        {{ __('app.actions.log_in') }}
                    </a>
                @endauth
            </div>
        </section>

        {{-- Features --}}
        <section class="landing__features">
            <h2 class="landing__section-title">{{ __('app.landing.how_it_works') }}</h2>
            <div class="landing__feature-grid">

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-users width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.features.private_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.features.private_body') }}</p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-key-round width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.features.invite_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.features.invite_body') }}</p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-calendar width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.features.predict_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.features.predict_body') }}</p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-bar-chart-2 width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.features.standings_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.features.standings_body') }}</p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-trophy width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.features.scoring_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.features.scoring_body') }}</p>
                </div>

            </div>
        </section>

        {{-- Steps --}}
        <section class="landing__steps">
            <h2 class="landing__section-title">{{ __('app.landing.steps_title') }}</h2>
            <div class="landing__step-list">

                <div class="landing__step">
                    <span class="landing__step-number">1</span>
                    <div>
                        <h3 class="landing__step-title">{{ __('app.landing.steps.register_title') }}</h3>
                        <p class="landing__step-body">{{ __('app.landing.steps.register_body') }}</p>
                    </div>
                </div>

                <div class="landing__step">
                    <span class="landing__step-number">2</span>
                    <div>
                        <h3 class="landing__step-title">{{ __('app.landing.steps.league_title') }}</h3>
                        <p class="landing__step-body">{{ __('app.landing.steps.league_body') }}</p>
                    </div>
                </div>

                <div class="landing__step">
                    <span class="landing__step-number">3</span>
                    <div>
                        <h3 class="landing__step-title">{{ __('app.landing.steps.compete_title') }}</h3>
                        <p class="landing__step-body">{{ __('app.landing.steps.compete_body') }}</p>
                    </div>
                </div>

            </div>
        </section>

        {{-- Bottom CTA (guests only) --}}
        @guest
            <section class="landing__bottom-cta">
                <h2 class="landing__headline landing__headline--sm">{{ __('app.landing.ready') }}</h2>
                <a class="btn btn--primary btn--lg" href="{{ route('register') }}">
                    {{ __('app.actions.create_account') }}
                    <x-lucide-arrow-right width="18" height="18" />
                </a>
            </section>
        @endguest

    </main>
</x-layout>
