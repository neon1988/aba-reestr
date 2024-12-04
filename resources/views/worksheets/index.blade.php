@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Учебные материалы</h1>

        <!-- Описание учебных материалов -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добро пожаловать в раздел учебных материалов</h2>
            <p class="text-gray-600">
                Здесь вы найдете полезные ресурсы, включая PDF-файлы и обучающие видео, посвященные ABA-терапии.
                Эти материалы помогут вам углубить свои знания и применить их на практике.
            </p>
        </div>

        <!-- Список материалов -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Доступные материалы</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Карточка PDF -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">День рождения социальная история (PDF)</h3>
                    <p class="text-gray-600 mt-2">Автор: Иван Иванов</p>
                    <p class="text-gray-600 mt-4">
                        Подробное руководство по основным принципам и техникам ABA-терапии. Подходит для начинающих специалистов.
                    </p>
                    <a href="{{ \Illuminate\Support\Facades\Storage::url('День_рождения_социальная_история_.pdf') }}"
                       class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700"
                       target="_blank">
                        Скачать PDF
                    </a>
                </div>

                <div x-data="{ isOpen: false }"
                     @keyup.escape="isOpen = false;"
                     x-init="$watch('isOpen', value => { if (!value) { $refs.video.pause(); } else { $refs.video.play(); } })"
                     class="relative">
                    <!-- Карточка видео -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Введение в ABA-терапию (Видео)</h3>
                        <p class="text-gray-600 mt-2">Автор: Анастасия Панченко</p>
                        <p class="text-gray-600 mt-2">Длительность: 56 минут</p>
                        <p class="text-gray-600 mt-4">
                            Узнайте о ключевых принципах прикладного анализа поведения в удобном видеоформате.
                        </p>
                        <button @click="isOpen = true"
                                class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700">
                            Смотреть видео
                        </button>
                    </div>

                    <!-- Модальное окно -->
                    <div x-show="isOpen"
                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                         style="display: none;"
                         x-cloak>
                        <div @click.outside="isOpen = false;"
                             class="bg-white rounded-lg overflow-hidden shadow-lg w-full max-w-4xl">
                            <div class="relative">
                                <!-- Видео -->
                                <video x-ref="video" controls class="w-full" autoplay>
                                    <source src="{{ \Illuminate\Support\Facades\Storage::url('IMG_1150.MP4') }}" type="video/mp4">
                                    Ваш браузер не поддерживает тег <code>video</code>.
                                </video>

                                <!-- Кнопка закрытия -->
                                <button @click="isOpen = false;"
                                        class="absolute top-3 right-3 text-gray-700 hover:text-gray-900">
                                    ✖
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Другая карточка PDF -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800">Работа с родителями (PDF)</h3>
                    <p class="text-gray-600 mt-2">Автор: Анна Смирнова</p>
                    <p class="text-gray-600 mt-4">
                        Практическое руководство по взаимодействию с родителями в процессе ABA-терапии.
                    </p>
                    <a href="#"
                       class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700"
                       target="_blank">
                        Скачать PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
