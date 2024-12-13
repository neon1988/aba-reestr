@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Вебинары</h1>

        <!-- Описание вебинаров -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добро пожаловать на наши вебинары!</h2>
            <p class="text-gray-600">
                Здесь вы найдете записи и расписание предстоящих вебинаров, посвященных ABA-терапии, новым техникам и подходам.
                Присоединяйтесь к нашим онлайн встречам, чтобы узнать больше и задать вопросы профессионалам.
            </p>
        </div>

        <!-- Список вебинаров -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Предстоящие вебинары</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Карточка вебинара 1 -->
                <div class="bg-white shadow rounded-lg p-6">
                    <img src="https://fastly.picsum.photos/id/251/200/300.jpg?hmac=9xXOWzHXFkhqJDfiXSZARyy0pDmdAyazrrJw6VNgoKc" alt="Основы ABA-терапии" class="w-full h-40 object-cover rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mt-4">Основы ABA-терапии</h3>
                    <p class="text-gray-600 mt-2">Дата: 10 декабря 2024 года</p>
                    <p class="text-gray-600">Время: 18:00 (МСК)</p>
                    <p class="text-gray-600 mt-4">
                        Узнайте о базовых принципах прикладного анализа поведения и его использовании в повседневной практике.
                    </p>
                    <a href="{{ route('join') }}" class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700">
                        Оформить подписку
                    </a>
                </div>
                <!-- Карточка вебинара 2 -->
                <div class="bg-white shadow rounded-lg p-6">
                    <img src="https://fastly.picsum.photos/id/251/200/300.jpg?hmac=9xXOWzHXFkhqJDfiXSZARyy0pDmdAyazrrJw6VNgoKc" alt="Работа с родителями" class="w-full h-40 object-cover rounded-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mt-4">Работа с родителями</h3>
                    <p class="text-gray-600 mt-2">Дата: 15 декабря 2024 года</p>
                    <p class="text-gray-600">Время: 17:00 (МСК)</p>
                    <p class="text-gray-600 mt-4">
                        Подробно о том, как включить родителей в процесс терапии и наладить эффективное сотрудничество.
                    </p>
                    <a href="{{ route('join') }}" class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700">
                        Оформить подписку
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
