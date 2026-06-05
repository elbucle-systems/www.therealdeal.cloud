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

        {{-- What to expect --}}
        <section class="landing__features">
            <div class="landing__section-heading">
                <h2 class="landing__section-title">{{ __('app.landing.expect_title') }}</h2>
                <p class="landing__section-sub">{{ __('app.landing.expect_subtitle') }}</p>
            </div>

            <div class="landing__feature-grid">
                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-users width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.expect.private_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.expect.private_body') }}</p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-clipboard-check width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.expect.rules_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.expect.rules_body') }}</p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-clock width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.expect.deadlines_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.expect.deadlines_body') }}</p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-bell-ring width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">{{ __('app.landing.expect.notifications_title') }}</h3>
                    <p class="landing__feature-body">{{ __('app.landing.expect.notifications_body') }}</p>
                </div>
            </div>
        </section>

        {{-- Steps --}}
        <section class="landing__steps">
            <div class="landing__section-heading">
                <h2 class="landing__section-title">{{ __('app.landing.steps_title') }}</h2>
                <p class="landing__section-sub">{{ __('app.landing.steps_subtitle') }}</p>
            </div>

            <div class="landing__step-list">
                @foreach (__('app.landing.steps') as $index => $step)
                    <div class="landing__step">
                        <span class="landing__step-number">{{ $index + 1 }}</span>
                        <div>
                            <h3 class="landing__step-title">{{ $step['title'] }}</h3>
                            <p class="landing__step-body">{{ $step['body'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- League rules --}}
        <section class="landing__rules">
            <div class="landing__section-heading">
                <h2 class="landing__section-title">{{ __('app.landing.rules_title') }}</h2>
                <p class="landing__section-sub">{{ __('app.landing.rules_subtitle') }}</p>
            </div>

            <div class="landing__rule-list">
                @foreach (__('app.landing.rule_details') as $rule)
                    <div class="landing__rule">
                        <div>
                            <h3 class="landing__rule-title">{{ $rule['title'] }}</h3>
                            <p class="landing__rule-body">{{ $rule['body'] }}</p>
                        </div>
                    </div>
                @endforeach
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
