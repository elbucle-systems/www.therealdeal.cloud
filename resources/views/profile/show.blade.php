<x-layout>
    <main class="content content--centered-top">
        <div class="profile">
            <header class="profile__header">
                <x-lucide-circle-user width="40" height="40" />
                <h1 class="profile__title">MY PROFILE</h1>
            </header>

            <div class="profile__cards">
                <div class="profile__col">
                    {{-- Read-only info card --}}
                    <section class="profile__info">
                        <div class="profile__info-row">
                            <span class="profile__info-label">
                                <x-lucide-mail width="16" height="16" />
                                EMAIL
                            </span>
                            <span class="profile__info-value">{{ $user->email }}</span>
                        </div>
                        <div class="profile__info-row">
                            <span class="profile__info-label">
                                <x-lucide-at-sign width="16" height="16" />
                                USERNAME
                            </span>
                            <span class="profile__info-value">{{ $user->username }}</span>
                        </div>
                        <div class="profile__info-row">
                            <span class="profile__info-label">
                                <x-lucide-calendar width="16" height="16" />
                                MEMBER SINCE
                            </span>
                            <span class="profile__info-value">{{ $user->created_at->format('M j, Y') }}</span>
                        </div>
                    </section>

                    {{-- Update username --}}
                    <form class="form" method="POST" action="{{ route('profile.username') }}">
                        @csrf
                        @method('PUT')

                        @if (session('success_username'))
                            <p class="form__success">{{ session('success_username') }}</p>
                        @endif

                        <header class="form__header">
                            <div class="form__title-content">
                                <x-lucide-pencil width="24" height="24" />
                                <h2 class="form__title">Change Username</h2>
                            </div>
                        </header>

                        <div class="form__content">
                            <div class="form__field">
                                <span class="form__label-content">
                                    <x-lucide-at-sign width="20" height="20" />
                                    <label class="form__label" for="username">New Username:</label>
                                </span>
                                <input class="form__input" type="text" id="username" name="username"
                                    placeholder="Enter new username" value="{{ old('username', $user->username) }}"
                                    minlength="3" maxlength="50" required />
                                @error('username')
                                    <p class="form__error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <footer class="form__footer">
                            <button class="form__button" type="submit">Update Username</button>
                        </footer>
                    </form>
                </div>{{-- /.profile__col (left) --}}

                <div class="profile__col">
                    {{-- Update password --}}
                    <form class="form" method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        @if (session('success_password'))
                            <p class="form__success">{{ session('success_password') }}</p>
                        @endif

                        <header class="form__header">
                            <div class="form__title-content">
                                <x-lucide-lock width="24" height="24" />
                                <h2 class="form__title">Change Password</h2>
                            </div>
                        </header>

                        <div class="form__content">
                            <div class="form__field">
                                <span class="form__label-content">
                                    <x-lucide-key-round width="20" height="20" />
                                    <label class="form__label" for="current_password">Current Password:</label>
                                </span>
                                <input class="form__input" type="password" id="current_password" name="current_password"
                                    placeholder="Enter current password" required />
                                @error('current_password')
                                    <p class="form__error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form__field">
                                <span class="form__label-content">
                                    <x-lucide-lock width="20" height="20" />
                                    <label class="form__label" for="password">New Password:</label>
                                </span>
                                <input class="form__input" type="password" id="password" name="password"
                                    placeholder="Min. 8 characters" required />
                                @error('password')
                                    <p class="form__error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form__field">
                                <span class="form__label-content">
                                    <x-lucide-lock width="20" height="20" />
                                    <label class="form__label" for="password_confirmation">Confirm New Password:</label>
                                </span>
                                <input class="form__input" type="password" id="password_confirmation"
                                    name="password_confirmation" placeholder="Repeat new password" required />
                            </div>
                        </div>

                        <footer class="form__footer">
                            <button class="form__button" type="submit">Update Password</button>
                        </footer>
                    </form>
                </div>{{-- /.profile__col (right) --}}
            </div>{{-- /.profile__cards --}}
        </div>
    </main>
</x-layout>
