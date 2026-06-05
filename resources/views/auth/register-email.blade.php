<x-layout>
    <main class="content content--centered">
        @if (session('success'))
            <div class="form">
                <header class="form__header">
                    <h2 class="form__title">{{ __('app.auth.check_inbox') }}</h2>
                </header>
                <p class="form__subtitle">{{ session('success') }}</p>
            </div>
        @else
            <form class="form" method="POST" action="{{ route('register') }}">
                @csrf
                <header class="form__header">
                    <div class="form__title-content">
                        <x-lucide-mail width="32" height="32" />
                        <h2 class="form__title">{{ __('app.auth.register_email') }}</h2>
                    </div>
                    <p class="form__subtitle">{{ __('app.auth.register_subtitle') }}</p>
                </header>

                <div class="form__content">
                    <div class="form__field">
                        <label class="form__label" for="email">{{ __('app.auth.email_address') }}</label>
                        <input class="form__input" type="email" id="email" name="email"
                            placeholder="{{ __('app.auth.enter_email') }}" value="{{ old('email') }}" required />
                        @error('email')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <footer class="form__footer">
                    <button class="form__button" type="submit">{{ __('app.actions.send_registration_link') }}</button>
                </footer>
            </form>
        @endif
    </main>
</x-layout>
