<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Реестр ABA специалистов и центров</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-200 flex flex-col min-h-screen">
<nav class="fixed top-0 left-0 w-full shadow-md z-50 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex h-16">

            <a href="{{ route('home') }}" class="flex shrink lg:justify-center lg:col-start-2 h-16 w-16 self-center">
                <img
                    src="https://fs-thb03.getcourse.ru/fileservice/file/thumbnail/h/13466f741221f7be4c6975413c43c18f.png/s/f1200x/a/755389/sc/5"/>
            </a>

            <!-- Левая часть навигации -->
            <div class="flex grow">
                <a href="{{ route('specialists.index') }}"
                   class="text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Специалисты
                </a>
                <a href="{{ route('centers.index') }}"
                   class="text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Центры ABA</a>
            </div>

            <!-- Правая часть навигации -->
            <div class="flex shrink bg-cyan-600">
                @if (Route::has('login'))

                    @auth
                        <a href="{{ route('join') }}"
                           class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">Присоединиться</a>

                        <a href="{{ route('profile.edit') }}"
                           class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">{{ Auth::user()->name }}</a>
                    @else
                        <a href="{{ route('register') }}"
                           class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">Присоединиться</a>
                        <a href="{{ route('login') }}"
                           class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">Войти</a>
                    @endauth

                @endif

                <a href="{{ route('contacts') }}"
                   class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">Контакты</a>
            </div>
        </div>
    </div>
</nav>

<main class="flex flex-grow items-center justify-center">
    <div class="flex flex-col mt-20">
        <div class="w-full max-w-2xl px-6 lg:max-w-7xl">
            @yield('content')
        </div>
    </div>
</main>


<!-- Footer -->
<footer class="bg-cyan-600 text-white py-6 mt-16">
    <div class="container mx-auto text-center">
        <p>&copy; 2024 Реестр ABA специалистов и центров. Все права защищены.</p>
    </div>
</footer>
</body>
</html>
