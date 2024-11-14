@extends('layouts.app')

@section('content')

    <!-- Search Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск специалистов ABA</h2>

            <div class="mb-8">
                <form class="flex justify-center space-x-6">
                    <input type="text" placeholder="Поиск по ФИО или адресу"
                           class="w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <button type="submit"
                            class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                        Поиск
                    </button>
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
                    <input type="text" id="location" placeholder="Введите город"
                           class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
                <div class="w-full text-center mt-6">
                    <button type="submit"
                            class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                        Найти
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Specialists List Section -->
    <section id="specialists" class="py-16 px-5 bg-gray-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Список специалистов ABA</h2>

            @if ($specialists->hasPages())
                <div class="mb-5">
                    {{ $specialists->links() }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($specialists->items() as $specialist)
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <!-- Фото специалиста -->
                        <div class="flex justify-center mb-4">
                            <img src="{{ $specialist->profile_photo_url ?? 'https://via.placeholder.com/150' }}"
                                 alt="Фото специалиста" class="w-32 h-32 rounded-full object-cover">
                        </div>

                        <!-- Имя специалиста -->
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $specialist->firstname }} {{ $specialist->lastname }}</h3>

                        <!-- Образование специалиста -->
                        <p class="text-gray-600 mb-4">Образование: {{ $specialist->education ?? 'Не указано' }}</p>

                        <!-- Адрес специалиста -->
                        <p class="text-gray-600 mb-4">Адрес: г. {{ __($specialist->city) ?? 'Не указан' }},
                            {{ $specialist->region ?? '' }}</p>

                        @isset($specialist->center)
                            <!-- Центр, в котором работает специалист -->
                            <p class="text-gray-600 mb-4">Центр: {{ $specialist->center->name ?? 'Не указано' }}</p>
                        @endif

                        <!-- Наличие мест -->
                        <p class="text-gray-600 mb-4">Есть места: {{ $specialist->available_spots ? 'Да' : 'Нет' }}</p>

                        <!-- Ссылка на подробности -->
                        <a href="{{ route('specialists.show', $specialist->id) }}"
                           class="text-cyan-600 hover:underline">Подробнее</a>
                    </div>

                @endforeach
            </div>

            @if ($specialists->hasPages())
                <div class="mt-5">
                    {{ $specialists->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection
