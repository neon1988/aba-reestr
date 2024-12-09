@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto p-6">
        <header class="text-center mb-4">
            <h1 class="text-4xl font-bold text-cyan-600">Регистрация и Преимущества</h1>
            <p class="mt-2 text-lg text-gray-600">Станьте частью сети специалистов в области анализа поведения.</p>
        </header>

        <section class="bg-white p-8 rounded-lg shadow-md mb-4">
            <h2 class="text-3xl font-semibold text-cyan-600 mb-4">Как стать участником</h2>
            <p class="text-lg text-gray-700 mb-6">Вы можете присоединиться или продлить свою регистрацию с 1 сентября каждого года. Плата и условия не пропорционируются.</p>
            <p class="text-lg text-gray-700 mb-6">При регистрации вы становитесь частью сети ученых, преподавателей, практиков и студентов, с которыми можно делиться научными достижениями, образовательными стратегиями и профессиональными возможностями. Используйте ссылки ниже, чтобы узнать больше.</p>

            <div class="flex space-x-4">
                <a href="{{ route('register') }}" class="bg-cyan-600 text-white py-2 px-6 rounded-full hover:bg-cyan-700">Регистрация</a>
                <a href="{{ route('login') }}" class="bg-gray-600 text-white py-2 px-6 rounded-full hover:bg-gray-700">Войти</a>
            </div>
        </section>

        <section class="bg-white p-8 rounded-lg shadow-md mb-4">
            <h2 class="text-3xl font-semibold text-cyan-600 mb-4">Сравнение Преимуществ</h2>
            <table class="min-w-full table-auto text-center">
                <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Преимущество</th>
                    <th class="px-4 py-2">Ассоциированный</th>
                    <th class="px-4 py-2">Студент</th>
                    <th class="px-4 py-2">Член Общества</th>
                    <th class="px-4 py-2">Полный</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-4 py-2 text-left">Подача материалов на мероприятия</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="px-4 py-2 text-left">Доступ к каталогу участников</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 text-left">Скидки на участие в мероприятиях</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="px-4 py-2 text-left">Доступ к видеоматериалам учебного центра</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                    <td class="px-4 py-2">✔</td>
                </tr>
                </tbody>
            </table>
        </section>

        <section class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-cyan-600 mb-4">Типы Участников</h2>
            <p class="text-lg text-gray-700 mb-6">При выборе типа участия обратите внимание, что полное участие и участие в качестве партнера имеют одинаковую стоимость, но предоставляют разные возможности. Полные участники могут выдвигать и голосовать за членов исполнительного совета.</p>
            <div class="flex space-x-4">
                <a href="#" class="bg-cyan-600 text-white py-2 px-6 rounded-full hover:bg-cyan-700">Узнать больше</a>
                <a href="#" class="bg-gray-600 text-white py-2 px-6 rounded-full hover:bg-gray-700">Посмотреть типы</a>
            </div>
        </section>

    </div>

@endsection
