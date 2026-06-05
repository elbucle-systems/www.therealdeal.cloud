<x-layout>
    <main class="content content--centered">
        <form class="form" method="POST" action="{{ request()->fullUrl() }}">
            @csrf
            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-book-a width="32" height="32" />
                    <h2 class="form__title">{{ __('app.auth.final_registration_step') }}</h2>
                </div>
                <p class="form__subtitle">{!! __('app.auth.complete_registration_for', ['email' => e($email)]) !!}</p>
            </header>

            <div class="form__content">
                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-user width="20" height="20" />
                        <label class="form__label" for="username">{{ __('app.auth.username') }}</label>
                    </span>
                    <input class="form__input" type="text" id="username" name="username"
                        placeholder="{{ __('app.auth.username_placeholder') }}" value="{{ old('username') }}" required />
                    @error('username')
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

                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-lock-keyhole width="20" height="20" />
                        <label class="form__label" for="password_confirmation">{{ __('app.auth.confirm_password') }}</label>
                    </span>
                    <input class="form__input" type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="{{ __('app.auth.repeat_password') }}" required />
                </div>
            </div>

            <footer class="form__footer">
                <button class="form__button" type="submit">{{ __('app.auth.complete_registration') }}</button>
            </footer>
        </form>
    </main>
</x-layout>
