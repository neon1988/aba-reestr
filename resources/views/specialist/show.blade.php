@extends('layouts.app')

@section('content')

    <!-- Profile Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <!-- Personal Photo -->
                <div class="w-40 h-40 md:w-48 md:h-48 bg-gray-200 rounded-full overflow-hidden mb-8 md:mb-0">
                    <img src="https://via.placeholder.com/150" alt="Фото специалиста"
                         class="w-full h-full object-cover">
                </div>
                <!-- Specialist Info -->
                <div class="md:ml-12">
                    <h1 class="text-4xl font-semibold text-gray-900 mb-4">Иван Иванов</h1>
                    <p class="text-lg text-gray-700 mb-6">Специалист ABA, сертифицированный тренер</p>
                    <p class="text-gray-600 mb-6">Образование: Высшее психологическое образование, диплом МГУ</p>
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Контактная информация:</h3>
                        <p class="text-gray-600 mb-2">Телефон: +7 123 456 7890</p>
                        <p class="text-gray-600 mb-2">Email: ivanov@mail.ru</p>
                        <p class="text-gray-600 mb-2">Город: Москва</p>
                    </div>

                    <!-- Social Links -->
                    <div class="flex space-x-6">
                        <a href="#" class="text-cyan-600 hover:underline">Facebook</a>
                        <a href="#" class="text-cyan-600 hover:underline">Instagram</a>
                        <a href="#" class="text-cyan-600 hover:underline">LinkedIn</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education & Experience Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Образование и Опыт</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Education -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Образование</h3>
                    <ul class="list-disc pl-5">
                        <li>Московский государственный университет, Психология — 2015-2020</li>
                        <li>Сертификат ABA-терапевта — 2021</li>
                    </ul>
                </div>
                <!-- Experience -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Опыт работы</h3>
                    <ul class="list-disc pl-5">
                        <li>Специалист ABA в Центре психотерапии "ПсихоПро" — 2021-2023</li>
                        <li>Частная практика — 2023-настоящее время</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Photo Gallery Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Галерея</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Gallery Image 1 -->
                <div class="w-full h-64 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/300" alt="Фото с занятий" class="w-full h-full object-cover">
                </div>
                <!-- Gallery Image 2 -->
                <div class="w-full h-64 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/300" alt="Фото с занятий" class="w-full h-full object-cover">
                </div>
                <!-- Gallery Image 3 -->
                <div class="w-full h-64 bg-gray-200 rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/300" alt="Фото с занятий" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Видео</h2>
            <div class="relative pb-9/16">
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0"
                        class="absolute top-0 left-0 w-full h-full rounded-lg" allowfullscreen></iframe>
            </div>
        </div>
    </section>

@endsection
