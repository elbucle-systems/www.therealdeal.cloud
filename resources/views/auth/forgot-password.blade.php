<x-layout>
    <main class="content content--centered">
        <form class="form" method="POST" action="{{ route('password.request') }}">
            @csrf
            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-key-round width="32" height="32" />
                    <h2 class="form__title">{{ __('app.auth.forgot_password') }}</h2>
                </div>
                @if (session('success'))
                    <p class="form__subtitle">{{ __('app.auth.forgot_sent') }}</p>
                @else
                    <p class="form__subtitle">{{ __('app.auth.forgot_subtitle') }}</p>
                @endif
            </header>

            @unless (session('success'))
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
                </div>

                <footer class="form__footer">
                    <button class="form__button" type="submit">{{ __('app.actions.send_reset_link') }}</button>
                </footer>
            @endunless
        </form>
    </main>
</x-layout>
