@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Профиль центра</h1>

        @if ($center->isSentForReview())
            <!-- Сообщение о модерации -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-6 rounded-lg">
                <p class="text-lg font-medium">Ваш центр находится на стадии модерации.</p>
                <p>Мы внимательно проверяем информацию о вашем центре, чтобы убедиться в ее точности. Это может занять некоторое время. Пожалуйста, будьте терпеливы. Мы уведомим вас, как только процесс модерации будет завершен.</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Название -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Название центра</h3>
                <p class="text-gray-600">{{ $center->name }}</p>
            </div>

            <!-- Название юридическое -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Юридическое название</h3>
                <p class="text-gray-600">{{ $center->legal_name }}</p>
            </div>

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

        </div>
    </div>

@endsection
