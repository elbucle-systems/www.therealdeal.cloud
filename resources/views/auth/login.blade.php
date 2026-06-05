<x-layout>
    <main class="content content--centered">
        @if (session('success'))
            <div class="form">
                <p class="form__subtitle">{{ session('success') }}</p>
            </div>
        @endif

        <form class="form" method="POST" action="{{ route('login') }}">
            @csrf
            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-circle-user width="32" height="32" />
                    <h2 class="form__title">{{ __('app.auth.login_title') }}</h2>
                </div>
                <p class="form__subtitle">{{ __('app.auth.login_subtitle') }}</p>
            </header>

            <div class="form__content">
                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-mail width="20" height="20" />
                        <label class="form__label" for="email">{{ __('app.auth.email') }}</label>
                    </span>
                    <input class="form__input" type="email" id="email" name="email"
                        placeholder="{{ __('app.auth.enter_email') }}" value="{{ old('email') }}" required />
                    @error('email')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-lock width="20" height="20" />
                        <label class="form__label" for="password">{{ __('app.auth.password') }}</label>
                    </span>
                    <input class="form__input" type="password" id="password" name="password"
                        placeholder="{{ __('app.auth.enter_password') }}" required />
                    @error('password')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <footer class="form__footer">
                <a class="form__link" href="{{ route('password.request') }}">{{ __('app.auth.forgot_password_link') }}</a>
                <button class="form__button" type="submit">{{ __('app.actions.login') }}</button>
            </footer>
        </form>
    </main>
</x-layout>
