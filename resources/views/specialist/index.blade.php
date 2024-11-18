@extends('layouts.app')

@section('content')

    <!-- Search Section -->
    <section class="py-12 bg-white rounded-t">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск специалистов ABA</h2>

            <form x-data="{ open: false }" action="{{ route('specialists.index') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-center space-x-6">
                    <input name="search" type="text" value="{{ old('search') }}" placeholder="Поиск по ФИО или адресу"
                           class="w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    <button type="submit"
                            class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                        Поиск
                    </button>
                    <div x-on:click="open = ! open"
                         class="cursor-pointer bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                        Расширенный поиск
                    </div>
                </div>

                <div x-show="open" class="bg-gray-100 p-6 rounded-lg mt-6" style="display: none" x-transition>

                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Расширенный поиск</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label for="center" class="block text-gray-700">Центр</label>
                            <select id="center" class="w-full p-3 border border-gray-300 rounded-lg">
                                <option value="">Выберите центр</option>
                                <option value="center1">Центр 1</option>
                                <option value="center2">Центр 2</option>
                                <option value="center3">Центр 3</option>
                            </select>
                        </div>
                        <div >
                            <label for="has_spots" class="block text-gray-700">Есть места?</label>
                            <select id="has_spots" class="w-full p-3 border border-gray-300 rounded-lg">
                                <option value="">Выберите</option>
                                <option value="yes">Да</option>
                                <option value="no">Нет</option>
                            </select>
                        </div>
                        <div>
                            <label for="location" class="block text-gray-700">Город</label>
                            <input type="text" id="location" placeholder="Введите город"
                                   class="w-full p-3 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <button type="submit"
                                    class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                                Применить фильтры
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Specialists List Section -->
    <section id="specialists" class="py-16 px-5 bg-gray-50 rounded-b">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Список специалистов ABA</h2>

            @if ($specialists->hasPages())
                <div class="mb-5">
                    {{ $specialists->links() }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($specialists->items() as $specialist)
                    @include('specialist.card')
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
