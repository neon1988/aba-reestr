@extends('layouts.app')

@section('content')

    <!-- Search Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск специалистов ABA</h2>

            <div class="mb-8">
                <form class="flex justify-center space-x-6">
                    <input type="text" placeholder="Поиск по ФИО или адресу" class="w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <button type="submit" class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">Поиск</button>
                </form>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 mb-4">Расширенный поиск</h3>
            <form class="flex flex-wrap justify-center space-x-6 space-y-4">
                <div class="w-full sm:w-1/3">
                    <label for="center" class="block text-gray-700">Центр</label>
                    <select id="center" class="w-full p-3 border border-gray-300 rounded-lg">
                        <option value="">Выберите центр</option>
                        <option value="center1">Центр 1</option>
                        <option value="center2">Центр 2</option>
                        <option value="center3">Центр 3</option>
                    </select>
                </div>
                <div class="w-full sm:w-1/3">
                    <label for="has_spots" class="block text-gray-700">Есть места?</label>
                    <select id="has_spots" class="w-full p-3 border border-gray-300 rounded-lg">
                        <option value="">Выберите</option>
                        <option value="yes">Да</option>
                        <option value="no">Нет</option>
                    </select>
                </div>
                <div class="w-full sm:w-1/3">
                    <label for="location" class="block text-gray-700">Город</label>
                    <input type="text" id="location" placeholder="Введите город" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
                <div class="w-full text-center mt-6">
                    <button type="submit" class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">Найти</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Specialists List Section -->
    <section id="specialists" class="py-16 bg-gray-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Список специалистов ABA</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Specialist Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex justify-center mb-4">
                        <img src="https://via.placeholder.com/150" alt="Фото специалиста" class="w-32 h-32 rounded-full object-cover">
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Иван Иванов</h3>
                    <p class="text-gray-600 mb-4">Образование: Высшее, диплом РГУ</p>
                    <p class="text-gray-600 mb-4">Адрес: г. Москва, ул. Ленина, д. 5</p>
                    <p class="text-gray-600 mb-4">Центр: Центр ABA 1</p>
                    <div class="mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Фото с занятий</h4>
                        <img src="https://via.placeholder.com/300x200" alt="Фото с занятий" class="w-full h-48 object-cover rounded-lg mb-2">
                    </div>
                    <div class="mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Документы об образовании</h4>
                        <img src="https://via.placeholder.com/300x200" alt="Фото диплома" class="w-full h-48 object-cover rounded-lg mb-2">
                    </div>
                    <div class="mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Видео с занятий</h4>
                        <video class="w-full rounded-lg mb-2" controls>
                            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                            Ваш браузер не поддерживает видео.
                        </video>
                    </div>
                    <p class="text-gray-600 mb-4">Есть места: Да</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>

                <!-- Specialist Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex justify-center mb-4">
                        <img src="https://via.placeholder.com/150" alt="Фото специалиста" class="w-32 h-32 rounded-full object-cover">
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Мария Петрова</h3>
                    <p class="text-gray-600 mb-4">Образование: Высшее, диплом СПбГУ</p>
                    <p class="text-gray-600 mb-4">Адрес: г. Санкт-Петербург, пр. Пушкина, д. 7</p>
                    <p class="text-gray-600 mb-4">Центр: Центр ABA 2</p>
                    <div class="mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Фото с занятий</h4>
                        <img src="https://via.placeholder.com/300x200" alt="Фото с занятий" class="w-full h-48 object-cover rounded-lg mb-2">
                    </div>
                    <div class="mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Документы об образовании</h4>
                        <img src="https://via.placeholder.com/300x200" alt="Фото диплома" class="w-full h-48 object-cover rounded-lg mb-2">
                    </div>
                    <div class="mb-4">
                        <h4 class="text-lg font-semibold text-gray-900">Видео с занятий</h4>
                        <video class="w-full rounded-lg mb-2" controls>
                            <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                            Ваш браузер не поддерживает видео.
                        </video>
                    </div>
                    <p class="text-gray-600 mb-4">Есть места: Нет</p>
                    <a href="#" class="text-cyan-600 hover:underline">Подробнее</a>
                </div>

                <!-- Add more cards as needed -->

            </div>
        </div>
    </section>

@endsection
