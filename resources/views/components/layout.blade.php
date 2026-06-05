<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Real Deal') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <script>
        const theme = localStorage.getItem('vite-ui-theme') || 'system';
        const resolved = theme === 'dark' ? 'dark' :
            theme === 'light' ? 'light' :
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.classList.add(resolved);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

</head>

<body>
    <div class="menu__container">
        <div class="menu">
            <a class="logo" href="{{ url('/') }}">{{ __('app.brand') }}</a>
            <nav class="menu__nav">
                @auth
                    @php($unreadNotificationsCount = Auth::user()->unreadNotifications()->count())

                    <a class="nav__link {{ request()->is('profile') ? 'nav__link--active' : '' }}"
                        href="{{ route('profile.show') }}">
                        <x-lucide-circle-user width="18" height="18" />
                        {{ Auth::user()->username }}
                    </a>
                    <a class="nav__link {{ request()->is('leagues*') ? 'nav__link--active' : '' }}"
                        href="{{ route('leagues.index') }}">
                        <x-lucide-trophy width="18" height="18" />
                        {{ __('app.nav.my_leagues') }}
                    </a>
                    <a class="nav__link {{ request()->is('notifications') ? 'nav__link--active' : '' }}"
                        href="{{ route('notifications.index') }}">
                        <x-lucide-bell width="18" height="18" />
                        {{ __('app.nav.notifications') }}
                        @if ($unreadNotificationsCount > 0)
                            <span class="nav__badge">{{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav__link nav__link--button">
                            <x-lucide-log-out width="18" height="18" />
                            {{ __('app.nav.logout') }}
                        </button>
                    </form>
                @else
                    <a class="nav__link {{ request()->is('register') ? 'nav__link--active' : '' }}"
                        href="{{ route('register') }}">
                        <x-lucide-user-plus width="18" height="18" />
                        {{ __('app.nav.register') }}
                    </a>
                    <a class="nav__link {{ request()->is('login') ? 'nav__link--active' : '' }}"
                        href="{{ route('login') }}">
                        <x-lucide-log-in width="18" height="18" />
                        {{ __('app.nav.login') }}
                    </a>
                @endauth
                <a class="nav__link" href="{{ route('language.switch', app()->getLocale() === 'es' ? 'en' : 'es') }}"
                    aria-label="{{ __('app.language.label') }}">
                    <x-lucide-languages width="18" height="18" />
                    {{ app()->getLocale() === 'es' ? 'EN' : 'ES' }}
                </a>
                <button id="theme-toggle" class="theme-toggle" aria-label="{{ __('app.nav.toggle_theme') }}">
                    <x-lucide-moon class="theme-toggle__moon" width="32" height="32" />
                    <x-lucide-sun class="theme-toggle__sun" width="32" height="32" />
                </button>
            </nav>
        </div>
    </div>
    {{ $slot }}

    @stack('scripts')
</body>

</html>
