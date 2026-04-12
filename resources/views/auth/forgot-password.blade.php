<x-layout>
    <main class="content content--centered">
        <form class="form" method="POST" action="{{ route('password.request') }}">
            @csrf
            <header class="form__header">
                <div class="form__title-content">
                    <x-lucide-key-round width="32" height="32" />
                    <h2 class="form__title">Forgot Password</h2>
                </div>
                @if (session('success'))
                    <p class="form__subtitle">Check your inbox — if that email exists, we sent a reset link valid for 1
                        hour.</p>
                @else
                    <p class="form__subtitle">Enter your email and we'll send you a link to reset your password.</p>
                @endif
            </header>

            @unless (session('success'))
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
                </div>

                <footer class="form__footer">
                    <button class="form__button" type="submit">Send Reset Link</button>
                </footer>
            @endunless
        </form>
    </main>
</x-layout>
