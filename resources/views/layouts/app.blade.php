<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Реестр ABA специалистов и центров</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ drawer_open: false }" class="font-sans antialiased bg-gray-200 flex flex-col min-h-screen">
<nav class="fixed top-0 left-0 w-full shadow-md z-50 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between h-16">

            <!-- Левая часть навигации -->
            <div class="flex">
                <!-- Sidebar Toggle Button -->
                <button x-on:click="drawer_open = ! drawer_open" class="sm:hidden block px-3">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <a href="{{ route('home') }}" class="h-12 w-12 self-center mx-3 h-full flex items-center justify-center">
                    <img src="https://fs-thb03.getcourse.ru/fileservice/file/thumbnail/h/13466f741221f7be4c6975413c43c18f.png/s/f1200x/a/755389/sc/5" alt=""/>
                </a>
                <a href="{{ route('home') }}"
                   class="sm:flex hidden text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Главная
                </a>
                <a href="{{ route('specialists.index') }}"
                   class="sm:flex hidden text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Специалисты
                </a>
                <a href="{{ route('centers.index') }}"
                   class="sm:flex hidden text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Центры ABA</a>
                <a href="{{ route('webinars.index') }}"
                   class="sm:flex hidden text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Вебинары</a>
                <a href="{{ route('worksheets.index') }}"
                   class="sm:flex hidden text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Пособия</a>
                <a href="{{ route('conferences.index') }}"
                   class="sm:flex hidden text-cyan-600 hover:text-cyan-800 font-semibold py-2 px-3 h-full flex items-center justify-center">
                    Мероприятия</a>
            </div>

            <div class="flex bg-cyan-600">

                @if (Route::has('login'))
                    @auth
                        @if (!Auth::user()->hasSpecialistOrCenter())
                            <a href="{{ route('join') }}"
                               class="text-white bg-orange-700 font-semibold py-2 px-3 h-full flex items-center justify-center">Присоединиться</a>
                        @endif
                        <!-- Меню пользователя -->
                        <div class="relative" x-data="{ open: false }">
                            <button id="userMenuButton" x-on:click="open = ! open"
                                    class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="userMenu" x-show="open"
                                 class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg"
                                 style="display: none">
                                @if (Auth::user()->isSpecialist())
                                    <a href="{{ route('specialists.show', Auth::user()->getSpecialistId()) }}"
                                       class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Профиль специалиста</a>
                                @endif
                                @if (Auth::user()->isCenter())
                                    <a href="{{ route('centers.show', Auth::user()->getCenterId()) }}"
                                       class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Профиль центра</a>
                                @endif
                                @if (Auth::user()->isStaff())
                                    <a href=""
                                       class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        Перейти в админку</a>
                                @endif
                                <a href="{{ route('profile.edit') }}"
                                   class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Настройки</a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Для гостей -->
                        <a href="{{ route('register') }}"
                           class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">Регистрация</a>
                        <a href="{{ route('login') }}"
                           class="text-white font-semibold py-2 px-3 h-full flex items-center justify-center">Войти</a>
                    @endauth
                @endif
                <a href="{{ route('contacts') }}"
                   class="hidden sm:flex text-white font-semibold py-2 px-3 h-full items-center justify-center">Контакты</a>
            </div>
        </div>
    </div>
</nav>


<!-- drawer component -->
<div id="drawer-navigation"
     class="sm:hidden block fixed top-16 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
     :class="drawer_open && 'transform-none'"
     tabindex="-1" aria-labelledby="drawer-navigation-label">
    <div class="overflow-y-auto">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('home') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="ms-3">Главная</span>
                </a>
            </li>
            <li>
                <a href="{{ route('specialists.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="ms-3">Специалисты</span>
                </a>
            </li>
            <li>
                <a href="{{ route('centers.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ms-3 whitespace-nowrap">Центры ABA</span>
                </a>
            </li>
            <li>
                <a href="{{ route('webinars.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ms-3 whitespace-nowrap">Вебинары</span>
                </a>
            </li>
            <li>
                <a href="{{ route('worksheets.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ms-3 whitespace-nowrap">Пособия</span>
                </a>
            </li>
            <li>
                <a href="{{ route('conferences.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ms-3 whitespace-nowrap">Мероприятия</span>
                </a>
            </li>
            <li>
                <a href="{{ route('contacts') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <span class="flex-1 ms-3 whitespace-nowrap">Контакты</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<main class="flex flex-grow items-center justify-center">
    <div class="flex flex-col mt-20">
        <div class="w-full max-w-2xl sm:px-3 lg:max-w-7xl">
            @yield('content')
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-cyan-600 text-white py-6 mt-4">
    <div class="container mx-auto text-center">
        <p>&copy; 2024 Реестр ABA специалистов и центров. Все права защищены.</p>
    </div>
</footer>

<div
    x-on:click="drawer_open = false"
    x-show="drawer_open"
    :class="{ 'hidden': !drawer_open }"
    class="bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-30 sm:hidden"
    style="display: none;">
</div>

</body>
</html>
