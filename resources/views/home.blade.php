@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-cyan-100 text-center py-10 sm:rounded-t-lg">
        <div class="container mx-auto px-4 lg:px-10">
            <h1 class="text-4xl font-bold text-cyan-600 mb-6">Добро пожаловать на страницу проекта ABA Expert!</h1>
            <p class="text-lg text-gray-700 mb-6">
                ABA Expert – это проект для поведенческих аналитиков, родителей детей с аутизмом,
                а также всех профессионалов, работающих в сфере аутизма и других нарушений развития.
            </p>
            <p class="text-lg text-gray-700">
                Здесь вы можете найти контакты квалифицированных
                <a href="{{ route('specialists.index') }}" class="text-cyan-600 hover:underline">специалистов</a>,
                работающих в области ABA-терапии,
                <a href="{{ route('bulletins.index') }}" class="text-cyan-600 hover:underline">разместить объявление</a>,
                а также получить доступ к
                <a href="{{ route('worksheets.index') }}" class="text-cyan-600 hover:underline">полезным видео-лекциям,
                    пособиям для работы</a>.
            </p>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold text-gray-900 mb-6">Поиск специалистов</h2>
            <form action="{{ route('specialists.index') }}" method="get" enctype="multipart/form-data"
                  class="flex justify-center space-x-4 flex-wrap">
                <input name="search" type="text" placeholder="Поиск по имени или городу"
                       class="sm:w-1/3 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                <button type="submit"
                        class="bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                    Поиск
                </button>
            </form>
        </div>
    </section>

    <!-- Specialists Section -->
    <section id="specialists" class="p-4 lg:p-8 bg-gray-50 sm:rounded-b-lg">
        <div class="container mx-auto text-center">
            <a href="{{ route('specialists.index') }}">
                <h2 class="text-3xl font-semibold text-gray-900 mb-6">Специалисты ABA</h2>
            </a>
            <div class="relative overflow-y-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-8">
                    @foreach ($specialists as $specialist)
                        @include('specialists.card')
                    @endforeach
                </div>
                <!-- Градиентная маска для прозрачности снизу -->
                <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent pointer-events-none"></div>
            </div>
            <!-- Ссылка "Еще специалисты" -->
            <div class="mt-8">
                <a href="{{ route('specialists.index') }}"
                   class="inline-block bg-cyan-600 text-white py-3 px-6 rounded-lg hover:bg-cyan-700 transition duration-300">
                    Еще специалисты
                </a>
            </div>
        </div>
    </section>

@endsection
