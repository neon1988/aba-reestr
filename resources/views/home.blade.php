@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="bg-cyan-100 text-center py-16 sm:rounded-t">
        <div class="container mx-auto px-4 lg:px-10">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Добро пожаловать на страницу проекта ABA Expert!</h1>
            <p class="text-lg text-gray-700 mb-6 ">
                Aba Expert – это проект для поведенческих аналитиков, родителей детей с аутизмом,
                а также всех профессионалов, работающих в сфере аутизма и других нарушений развития.
            </p>
            <p class="text-lg text-gray-700 mb-6">
                Здесь вы можете найти контакты квалифицированных
                <a href="{{ route('specialists.index') }}">специалистов</a>
                и <a href="{{ route('centers.index') }}">центров</a>,
                работающих в области ABA-терапии,
                <a href="{{ route('bulletins.index') }}">разместить объявление</a>,
                а также получить доступ к
                <a href="{{ route('worksheets.index') }}">полезным видео-лекциям,
                    пособиям для работы</a>.</p>
            <a href="{{ route('centers.index') }}"
               class="bg-cyan-600 text-white py-2 px-6 rounded-full hover:bg-cyan-700 transition duration-300">Найти
                центр</a>
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

    <!-- Centers Section -->
    <section id="centers" class="p-4 lg:p-8 bg-gray-50">
        <div class="container mx-auto text-center">
            <a href="{{ route('centers.index') }}">
                <h2 class="text-3xl font-semibold text-gray-900 mb-6">Центры ABA</h2>
            </a>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-8">
                @foreach ($centers as $center)
                    @include('centers.card')
                @endforeach
            </div>
        </div>
    </section>

    <!-- Specialists Section -->
    <section id="specialists" class="p-4 lg:p-8 bg-gray-50">
        <div class="container mx-auto text-center">
            <a href="{{ route('specialists.index') }}">
                <h2 class="text-3xl font-semibold text-gray-900 mb-6">Специалисты ABA</h2>
            </a>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-8">
                @foreach ($specialists as $specialist)
                    @include('specialists.card')
                @endforeach
            </div>
        </div>
    </section>

@endsection
