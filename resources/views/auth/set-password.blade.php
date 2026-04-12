<x-layout>
    <main class="content content--centered">
        <form class="form" method="POST" action="{{ request()->fullUrl() }}">
            @csrf
            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-book-a width="32" height="32" />
                    <h2 class="form__title">Set Your Password</h2>
                </div>
                <p class="form__subtitle">Setting a new password for <strong>{{ $email }}</strong>.</p>
            </header>

            <div class="form__content">
                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-lock width="20" height="20" />
                        <label class="form__label" for="password">Password:</label>
                    </span>
                    <input class="form__input" type="password" id="password" name="password"
                        placeholder="Enter your new password" required />
                    @error('password')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-lock-keyhole width="20" height="20" />
                        <label class="form__label" for="password_confirmation">Confirm Password:</label>
                    </span>
                    <input class="form__input" type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Re-enter your new password" required />
                </div>
            </div>

            <footer class="form__footer">
                <button class="form__button" type="submit">Set Password</button>
            </footer>
        </form>
    </main>
</x-layout>
