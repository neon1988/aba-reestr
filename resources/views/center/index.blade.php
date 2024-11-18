@extends('layouts.app')

@section('content')

    <!-- Search Section -->
    <section class="py-12 bg-white rounded-t">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск центров ABA</h2>
            <form x-data="{ open: false }" action="{{ route('centers.index') }}" method="post"
                  enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Простое поле поиска -->
                <div class="flex justify-center space-x-4">
                    <input name="search" value="{{ old('search') }}" type="text"
                           placeholder="Поиск по названию или городу"
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

                <!-- Расширенный поиск -->
                <div class="bg-gray-100 p-6 rounded-lg mt-6" x-show="open" style="display: none" x-transition>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Расширенный поиск</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label for="legal_name" class="block text-gray-700">Название юридическое</label>
                            <input name="legal_name" value="{{ old('legal_name') }}" id="legal_name" type="text"
                                   placeholder="Введите юридическое название"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label for="address" class="block text-gray-700">Адрес фактический</label>
                            <input name="address" value="{{ old('address') }}" id="address" type="text"
                                   placeholder="Введите адрес"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label for="inn" class="block text-gray-700">ИНН</label>
                            <input name="inn" value="{{ old('inn') }}" id="inn" type="text" placeholder="Введите ИНН"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        </div>
                        <div>
                            <label for="kpp" class="block text-gray-700">КПП</label>
                            <input name="kpp" value="{{ old('kpp') }}" id="kpp" type="text" placeholder="Введите КПП"
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
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

    <!-- Centers List Section -->
    <section id="centers" class="py-16 px-5 bg-gray-50 rounded-b">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Результаты поиска</h2>
            @if ($centers->hasPages())
                <div class="mb-5">
                    {{ $centers->links() }}
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($centers->items() as $center)
                    @include('center.card')
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
