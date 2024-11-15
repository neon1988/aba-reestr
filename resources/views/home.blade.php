@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-cyan-100 text-center py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Добро пожаловать в реестр ABA специалистов и центров</h1>
            <p class="text-lg text-gray-700 mb-6">Здесь вы можете найти квалифицированных специалистов и центры,
                работающие в области ABA-терапии.</p>
            <a href="#centers"
               class="bg-cyan-600 text-white py-2 px-6 rounded-full hover:bg-cyan-700 transition duration-300">Найти
                центр</a>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск специалистов и центров</h2>
            <form class="flex justify-center space-x-4">
                <input type="text" placeholder="Поиск по имени или городу"
                       class="w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                <button type="submit"
                        class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                    Поиск
                </button>
            </form>
        </div>
    </section>

    <!-- Centers Section -->
    <section id="centers" class="py-16 bg-gray-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Центры ABA</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Center Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Центр 1</h3>
                    <p class="text-gray-600 mb-4">Адрес: г. Москва, ул. Пушкина, д. 10</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>
                <!-- Center Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Центр 2</h3>
                    <p class="text-gray-600 mb-4">Адрес: г. Санкт-Петербург, пр. Ленина, д. 5</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>
                <!-- Center Card 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Центр 3</h3>
                    <p class="text-gray-600 mb-4">Адрес: г. Казань, ул. Гая, д. 3</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Specialists Section -->
    <section id="specialists" class="py-16 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Специалисты ABA</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Specialist Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Специалист 1</h3>
                    <p class="text-gray-600 mb-4">Образование: Высшее, диплом МГУ</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>
                <!-- Specialist Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Специалист 2</h3>
                    <p class="text-gray-600 mb-4">Образование: Высшее, диплом СПбГУ</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>
                <!-- Specialist Card 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Специалист 3</h3>
                    <p class="text-gray-600 mb-4">Образование: Высшее, диплом РГУ</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>
            </div>
        </div>
    </section>

@endsection
