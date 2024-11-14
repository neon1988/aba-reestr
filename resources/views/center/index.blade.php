@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-cyan-100 text-center py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Список центров ABA</h1>
            <p class="text-lg text-gray-700 mb-6">Найдите центр ABA рядом с вами или по нужным критериям.</p>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск центров ABA</h2>
            <form class="space-y-6">
                <!-- Простое поле поиска -->
                <div class="flex justify-center space-x-4">
                    <input type="text" placeholder="Поиск по названию или городу"
                           class="w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <button type="submit"
                            class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                        Поиск
                    </button>
                </div>

                <!-- Расширенный поиск -->
                <div class="bg-gray-100 p-6 rounded-lg mt-6">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Расширенный поиск</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="legal_name" class="block text-gray-700">Название юридическое</label>
                            <input id="legal_name" type="text" placeholder="Введите юридическое название"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label for="address" class="block text-gray-700">Адрес фактический</label>
                            <input id="address" type="text" placeholder="Введите адрес"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label for="tax_id" class="block text-gray-700">ИНН</label>
                            <input id="tax_id" type="text" placeholder="Введите ИНН"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label for="kpp" class="block text-gray-700">КПП</label>
                            <input id="kpp" type="text" placeholder="Введите КПП"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                    </div>
                    <button type="submit"
                            class="bg-cyan-600 text-white py-3 px-6 mt-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                        Применить фильтры
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Centers List Section -->
    <section id="centers" class="py-16 px-5 bg-gray-50">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Результаты поиска</h2>
            @if ($centers->hasPages())
                <div class="mb-5">
                    {{ $centers->links() }}
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($centers->items() as $center)
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                        <img src="https://via.placeholder.com/400x250" alt="Фото центра"
                             class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $center->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ __($center->country) }} {{ __($center->region) }} {{ __($center->city) }}</p>
                        <p class="text-gray-600 mb-4">Юридическое название: {{ $center->legal_name }}</p>
                        <a href="{{ route('centers.show', compact('center')) }}" class="text-cyan-600 hover:underline">Подробнее</a>
                    </div>
                @endforeach
            </div>
            @if ($centers->hasPages())
                <div class="mt-5">
                    {{ $centers->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection
