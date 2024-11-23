@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-8">Профиль центра</h3>

        @if ($center->isSentForReview())
            <!-- Сообщение о модерации -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-6 rounded-lg">
                <p class="text-lg font-medium">Ваш центр находится на стадии модерации.</p>
                <p>Мы внимательно проверяем информацию о вашем центре, чтобы убедиться в ее точности. Это может занять
                    некоторое время. Пожалуйста, будьте терпеливы. Мы уведомим вас, как только процесс модерации будет
                    завершен.</p>
            </div>
        @endif

        <div class="flex items-center space-x-4">
            <!-- Фото специалиста (если есть) -->
            <div class="w-20 h-20 rounded-full bg-gray-300 overflow-hidden">
                <img src="{{ $center->photo->url ?? asset('default-avatar.png') }}" alt="Profile Photo"
                     class="w-full h-full object-cover">
            </div>

            <!-- Имя специалиста -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">{{ $center->name }}</h2>
                <p class="text-sm text-gray-600">{{ $center->legal_name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            <!-- ИНН -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">ИНН</h3>
                <p class="text-gray-600">{{ $center->inn }}</p>
            </div>

            <!-- КПП -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">КПП</h3>
                <p class="text-gray-600">{{ $center->kpp ?? 'Не указано' }}</p>
            </div>

            <!-- Страна -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Страна</h3>
                <p class="text-gray-600">{{ __($center->country) }}</p>
            </div>

            <!-- Регион -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Регион</h3>
                <p class="text-gray-600">{{ __($center->region) ?? 'Не указано' }}</p>
            </div>

            <!-- Город -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Город</h3>
                <p class="text-gray-600">{{ __($center->city) }}</p>
            </div>

            <!-- Телефон -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Телефон</h3>
                <p class="text-gray-600">{{ $center->phone }}</p>
            </div>

            <!-- Кнопка для редактирования -->
            <div class="mt-6">
                <a href="{{ route('centers.edit', $center->id) }}" class="text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg px-4 py-2">
                    Редактировать профиль
                </a>
            </div>
        </div>
    </div>

@endsection