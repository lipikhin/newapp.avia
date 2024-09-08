<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body.light-theme {
            background-color: white;
            color: black;
        }

        body.dark-theme {
            background-color: #121212; // темный фон
        color: white; // светлый текст
        }

        /* Дополнительные стили для других элементов */
        .navbar.light-theme {
            background-color: white;
            border-bottom: 1px solid #ddd;
        }

        .navbar.dark-theme {
            background-color: #1c1c1c;
            border-bottom: 1px solid #444;
        }

    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->

                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="/avatars/{{ Auth::user()->avatar }}" class="rounded-circle pe-1"
                                         style="width: 40px;
                                    border-radius: 20%;border-color: blue">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('user.profile') }}" class="dropdown-item">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item">
                                <button id="theme-toggle" class="nav-link">Toggle Theme</button>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggleButton = document.getElementById('theme-toggle');
            const body = document.body;

            themeToggleButton.addEventListener('click', function () {
                body.classList.toggle('dark-theme');
                body.classList.toggle('light-theme');

                // Сохраните выбранную тему в локальном хранилище
                const currentTheme = body.classList.contains('dark-theme') ? 'dark' : 'light';
                localStorage.setItem('theme', currentTheme);
            });

            // Установите тему при загрузке страницы
            const savedTheme = localStorage.getItem('theme') || 'light';
            body.classList.add(savedTheme === 'dark' ? 'dark-theme' : 'light-theme');
        });
    </script>

    @stack('scripts')
</body>
</html>
