<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Real Deal') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <script>
        (function() {
            var theme = localStorage.getItem('vite-ui-theme') || 'system';
            var resolved = theme === 'dark' ? 'dark' :
                theme === 'light' ? 'light' :
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.classList.add(resolved);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

</head>

<body>
    <div class="menu__container">
        <div class="menu">
            <a class="logo" href="{{ url('/') }}">THE REAL DEAL</a>
            <nav class="menu__nav">
                @auth
                    <a class="nav__link {{ request()->is('profile') ? 'nav__link--active' : '' }}"
                        href="{{ route('profile.show') }}">{{ Auth::user()->username }}</a>
                    <a class="nav__link" href="{{ url('/leagues') }}">MY LEAGUES</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav__link nav__link--button">LOGOUT</button>
                    </form>
                @else
                    <a class="nav__link {{ request()->is('register') ? 'nav__link--active' : '' }}"
                        href="{{ route('register') }}">REGISTER</a>
                    <a class="nav__link {{ request()->is('login') ? 'nav__link--active' : '' }}"
                        href="{{ route('login') }}">LOGIN</a>
                @endauth
                <button id="theme-toggle" class="theme-toggle" aria-label="Toggle theme">
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
