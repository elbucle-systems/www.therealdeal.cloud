<x-layout>
    <main class="content content--centered">
        @if (session('success'))
            <div class="form">
                <header class="form__header">
                    <h2 class="form__title">Check Your Inbox</h2>
                </header>
                <p class="form__subtitle">{{ session('success') }}</p>
            </div>
        @else
            <form class="form" method="POST" action="{{ route('register') }}">
                @csrf
                <header class="form__header">
                    <div class="form__title-content">
                        <x-lucide-mail width="32" height="32" />
                        <h2 class="form__title">Register with Email</h2>
                    </div>
                    <p class="form__subtitle">Please enter your email to create an account.</p>
                </header>

                <div class="form__content">
                    <div class="form__field">
                        <label class="form__label" for="email">Email Address:</label>
                        <input class="form__input" type="email" id="email" name="email"
                            placeholder="Enter your email" value="{{ old('email') }}" required />
                        @error('email')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <footer class="form__footer">
                    <button class="form__button" type="submit">Send Registration Link</button>
                </footer>
            </form>
        @endif
    </main>
</x-layout>
