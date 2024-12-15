@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <div class="flex items-center space-x-6 mb-6">
            <div class="w-24 h-24">
                <img class="w-full h-full object-cover rounded-full border border-gray-300"
                     src="{{ $user->photo->url }}"
                     alt="Фото пользователя">
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }} {{ $user->lastname }}</h1>
                <p class="text-gray-600">{{ $user->middlename ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <p class="text-sm text-gray-500">{{ $user->phone ?? 'Телефон не указан' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Количество вебинаров -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Количество вебинаров</h2>
                <p class="text-2xl font-bold text-cyan-600">{{ $user->webinars_count }}</p>
            </div>

            <!-- Уровень подписки -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Уровень подписки</h2>
                <p class="text-xl font-bold {{ $user->subscription_level === 0 ? 'text-gray-400' : 'text-green-600' }}">
                    {{ $user->subscription_level === 0 ? 'Бесплатная' : 'Платная (' . $user->subscription_level . ')' }}
                </p>
                <p class="text-sm text-gray-500">{{ $user->subscription_ends_at ? 'Активна до: ' . $user->subscription_ends_at->format('d.m.Y') : 'Подписка не активна' }}</p>
            </div>
        </div>
    </div>
@endsection
