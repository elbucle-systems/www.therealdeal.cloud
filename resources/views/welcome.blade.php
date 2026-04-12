<x-layout>
    <main class="landing">

        {{-- Hero --}}
        <section class="landing__hero">
            <h1 class="landing__headline">
                Predict. Compete. <span class="landing__accent">Win.</span>
            </h1>
            <p class="landing__sub">
                The Real Deal is a 2026 World Cup prediction game played inside
                private leagues with your friends, colleagues, or rivals. Predict
                every match result, earn points, and climb the standings.
            </p>
            <div class="landing__cta-row">
                @auth
                    <a class="btn btn--primary btn--lg" href="{{ route('leagues.index') }}">
                        My Leagues
                        <x-lucide-arrow-right width="18" height="18" />
                    </a>
                    <a class="btn btn--secondary btn--lg" href="{{ route('leagues.join') }}">
                        Join a League
                    </a>
                @else
                    <a class="btn btn--primary btn--lg" href="{{ route('register') }}">
                        Get Started
                        <x-lucide-arrow-right width="18" height="18" />
                    </a>
                    <a class="btn btn--ghost btn--lg" href="{{ route('login') }}">
                        Log In
                    </a>
                @endauth
            </div>
        </section>

        {{-- Features --}}
        <section class="landing__features">
            <h2 class="landing__section-title">How it works</h2>
            <div class="landing__feature-grid">

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-users width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">Create a private league</h3>
                    <p class="landing__feature-body">
                        Set up your own league with custom scoring — reward exact scores
                        more than just correct results. Share the 6-character invite code
                        with your group.
                    </p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-key-round width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">Invite &amp; approve members</h3>
                    <p class="landing__feature-body">
                        Friends join by entering your code. As manager you approve (or
                        discard) requests, set a member cap, and control whether
                        predictions are visible before kickoff.
                    </p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-calendar width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">Predict every match</h3>
                    <p class="landing__feature-body">
                        Open your league's match list and enter your scoreline for all 72
                        group-stage games. Predictions are saved on the spot — just blur
                        the input and you're done.
                    </p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-bar-chart-2 width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">Live standings</h3>
                    <p class="landing__feature-body">
                        Points are calculated automatically as matches are played. Check
                        the league standings at any time to see who's leading and by how
                        much.
                    </p>
                </div>

                <div class="landing__feature-card">
                    <span class="landing__feature-icon">
                        <x-lucide-trophy width="28" height="28" />
                    </span>
                    <h3 class="landing__feature-title">Custom scoring</h3>
                    <p class="landing__feature-body">
                        Each league sets its own points for an exact score and for a
                        correct result. Make the stakes as high (or as casual) as your
                        group wants.
                    </p>
                </div>

            </div>
        </section>

        {{-- Steps --}}
        <section class="landing__steps">
            <h2 class="landing__section-title">Getting started in 3 steps</h2>
            <div class="landing__step-list">

                <div class="landing__step">
                    <span class="landing__step-number">1</span>
                    <div>
                        <h3 class="landing__step-title">Register &amp; verify your email</h3>
                        <p class="landing__step-body">
                            Sign up with your email address. You'll receive a link to
                            complete registration and set your password.
                        </p>
                    </div>
                </div>

                <div class="landing__step">
                    <span class="landing__step-number">2</span>
                    <div>
                        <h3 class="landing__step-title">Create or join a league</h3>
                        <p class="landing__step-body">
                            Start your own league or enter the 6-character code your friend
                            shared. Once approved, you're in.
                        </p>
                    </div>
                </div>

                <div class="landing__step">
                    <span class="landing__step-number">3</span>
                    <div>
                        <h3 class="landing__step-title">Predict &amp; compete</h3>
                        <p class="landing__step-body">
                            Head to your league's match view, enter your predictions for
                            each game, and watch the leaderboard update in real time.
                        </p>
                    </div>
                </div>

            </div>
        </section>

        {{-- Bottom CTA (guests only) --}}
        @guest
            <section class="landing__bottom-cta">
                <h2 class="landing__headline landing__headline--sm">Ready to play?</h2>
                <a class="btn btn--primary btn--lg" href="{{ route('register') }}">
                    Create your account
                    <x-lucide-arrow-right width="18" height="18" />
                </a>
            </section>
        @endguest

    </main>
</x-layout>
