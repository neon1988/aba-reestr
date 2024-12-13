@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Конференции</h1>

        <!-- Описание конференций -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Присоединяйтесь к нашим конференциям!</h2>
            <p class="text-gray-600">
                Наши конференции посвящены последним исследованиям и достижениям в области ABA-терапии. У вас будет возможность
                услышать выступления ведущих экспертов, обсудить кейсы и обменяться опытом с коллегами.
            </p>
        </div>

        <!-- Список конференций -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Предстоящие конференции</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Карточка конференции -->
                <div class="bg-white shadow rounded-lg p-6">
                    <img src="https://fastly.picsum.photos/id/251/200/300.jpg?hmac=9xXOWzHXFkhqJDfiXSZARyy0pDmdAyazrrJw6VNgoKc" alt="Работа с родителями" class="w-full h-40 object-cover rounded-lg">

                    <h3 class="text-xl font-semibold text-gray-800 mt-4">Международная конференция по ABA-терапии</h3>
                    <p class="text-gray-600 mt-2">Дата: 20 декабря 2024 года</p>
                    <p class="text-gray-600">Время: 10:00 - 18:00 (МСК)</p>
                    <p class="text-gray-600 mt-4">
                        Темы: последние достижения в прикладном анализе поведения, эффективные техники и инновационные подходы.
                    </p>
                    <a href="#" class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700">
                        Подробнее
                    </a>
                </div>
                <!-- Другая карточка конференции -->
                <div class="bg-white shadow rounded-lg p-6">
                    <img src="https://fastly.picsum.photos/id/251/200/300.jpg?hmac=9xXOWzHXFkhqJDfiXSZARyy0pDmdAyazrrJw6VNgoKc" alt="Работа с родителями" class="w-full h-40 object-cover rounded-lg">

                    <h3 class="text-xl font-semibold text-gray-800 mt-4">Практическая конференция для специалистов</h3>
                    <p class="text-gray-600 mt-2">Дата: 25 декабря 2024 года</p>
                    <p class="text-gray-600">Время: 11:00 - 17:00 (МСК)</p>
                    <p class="text-gray-600 mt-4">
                        Темы: работа с детьми с РАС, анализ поведенческих данных, эффективные методы обучения.
                    </p>
                    <a href="#" class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700">
                        Подробнее
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
