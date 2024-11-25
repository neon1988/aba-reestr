@extends('layouts.app')

@section('content')

    <div class="mx-4">
        <div class="max-w-4xl mx-auto p-4 sm:p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-8">Профиль центра</h3>

            @if ($center->isSentForReview())
                <!-- Сообщение о модерации -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-6 rounded-lg">
                    <p class="text-lg font-medium">Ваш центр находится на стадии модерации.</p>
                    <p>Мы внимательно проверяем информацию о вашем центре, чтобы убедиться в ее точности. Это может
                        занять
                        некоторое время. Пожалуйста, будьте терпеливы. Мы уведомим вас, как только процесс модерации
                        будет
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                <!-- ИНН -->
                <div class="flex flex-col sm:flex-row justify-between">
                    <span class="text-gray-500">ИНН</span>
                    <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ $center->inn }}</span>
                </div>

                <!-- КПП -->
                <div class="flex flex-col sm:flex-row justify-between">
                    <span class="text-gray-500">КПП</span>
                    <span
                        class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ $center->kpp ?? 'Не указано' }}</span>
                </div>

                <!-- Страна -->
                <div class="flex flex-col sm:flex-row justify-between">
                    <span class="text-gray-500">Страна</span>
                    <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ __($center->country) }}</span>
                </div>

                <!-- Регион -->
                <div class="flex flex-col sm:flex-row justify-between">
                    <span class="text-gray-500">Регион</span>
                    <span
                        class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ __($center->region) ?? 'Не указано' }}</span>
                </div>

                <!-- Город -->
                <div class="flex flex-col sm:flex-row justify-between">
                    <span class="text-gray-500">Город</span>
                    <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ __($center->city) }}</span>
                </div>

                <!-- Телефон -->
                <div class="flex flex-col sm:flex-row justify-between">
                    <span class="text-gray-500">Телефон</span>
                    <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ $center->phone }}</span>
                </div>

                @can('update', $center)
                    <!-- Кнопка для редактирования -->
                    <div class="mt-4">
                        <x-primary-button href="{{ route('centers.edit', $center->id) }}">
                            Редактировать профиль
                        </x-primary-button>
                    </div>
                @endcan
            </div>
        </div>
    </div>

@endsection
