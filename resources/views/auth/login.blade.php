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
                    <h2 class="form__title">Login</h2>
                </div>
                <p class="form__subtitle">Please enter your credentials to log in to your account.</p>
            </header>

            <div class="form__content">
                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-mail width="20" height="20" />
                        <label class="form__label" for="email">Email:</label>
                    </span>
                    <input class="form__input" type="email" id="email" name="email"
                        placeholder="Enter your email" value="{{ old('email') }}" required />
                    @error('email')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__field">
                    <span class="form__label-content">
                        <x-lucide-lock width="20" height="20" />
                        <label class="form__label" for="password">Password:</label>
                    </span>
                    <input class="form__input" type="password" id="password" name="password"
                        placeholder="Enter your password" required />
                    @error('password')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <footer class="form__footer">
                <a class="form__link" href="{{ route('password.request') }}">Forgot password?</a>
                <button class="form__button" type="submit">Login</button>
            </footer>
        </form>
    </main>
</x-layout>
