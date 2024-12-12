@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto p-6">
        <header class="text-center mb-4">
            <h1 class="text-4xl font-bold text-cyan-600">Регистрация и Преимущества</h1>
            <p class="mt-2 text-lg text-gray-600">Станьте частью сети специалистов в области анализа поведения.</p>
        </header>

        <section class="bg-white p-8 rounded-lg shadow-md mb-4">
            <h2 class="text-3xl font-semibold text-cyan-600 mb-4">Как стать участником</h2>
            <p class="text-lg text-gray-700 mb-6">Вы можете присоединиться или продлить свою регистрацию с 1 сентября
                каждого года. Плата и условия не пропорционируются.</p>
            <p class="text-lg text-gray-700 mb-6">При регистрации вы становитесь частью сети ученых, преподавателей,
                практиков и студентов, с которыми можно делиться научными достижениями, образовательными стратегиями и
                профессиональными возможностями. Используйте ссылки ниже, чтобы узнать больше.</p>

            <div class="flex space-x-4">
                <a href="{{ route('register') }}"
                   class="bg-cyan-600 text-white py-2 px-6 rounded-full hover:bg-cyan-700">Регистрация</a>
                <a href="{{ route('login') }}" class="bg-gray-600 text-white py-2 px-6 rounded-full hover:bg-gray-700">Войти</a>
            </div>
        </section>

        <section class="bg-white p-8 rounded-lg shadow-md mb-4">
            <h2 class="text-3xl font-semibold text-cyan-600 mb-4">Сравнение Преимуществ</h2>
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-200 p-4 text-left text-sm font-semibold">Что включено</th>
                        <th class="border border-gray-200 p-4 text-center text-sm font-semibold">
                            Родители или смежники
                        </th>
                        <th class="border border-gray-200 p-4 text-center text-sm font-semibold">ABA специалисты</th>
                        <th class="border border-gray-200 p-4 text-center text-sm font-semibold">
                            Aba центры и руководители центров
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <!-- Row 1 -->
                    <tr>
                        <td class="border border-gray-200 p-4 text-sm">Своя карточка в реестре специалистов</td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 text-sm">Доступ к видео лекциям</td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr>
                        <td class="border border-gray-200 p-4 text-sm">Доступ к материалам (библиотека материалов)</td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 text-sm">Возможность публиковать объявления о свободных
                            часах на доске объявлений
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr>
                        <td class="border border-gray-200 p-4 text-sm">Возможность публиковать объявления о своих очных
                            и онлайн мероприятиях
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 7 -->
                    <tr>
                        <td class="border border-gray-200 p-4 text-sm">Возможность добавить свой центр в список
                            центров
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 8 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 text-sm">Интервизии для специалистов</td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">

                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 9 -->
                    <tr>
                        <td class="border border-gray-200 p-4 text-sm">СЕУ?</td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 10 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 text-sm">1 групповая супервизия в месяц по определенной
                            теме
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm"></td>
                    </tr>
                    <!-- Row 10 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">100 ₽/мес</td>
                        <td class="border border-gray-200 p-4 text-center text-sm">200 ₽/мес</td>
                        <td class="border border-gray-200 p-4 text-center text-sm">300 ₽/мес</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 p-4 text-sm"></td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <a href="#" class="px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                Выбрать
                            </a>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <a href="#" class="px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                Выбрать
                            </a>
                        </td>
                        <td class="border border-gray-200 p-4 text-center text-sm">
                            <a href="#" class="px-4 py-2 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                Выбрать
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </div>

@endsection
