@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-lg rounded-2xl p-8 text-center max-w-md mx-auto mt-10">
        <div class="flex items-center justify-center w-24 h-24 mx-auto bg-green-100 text-green-500 rounded-full shadow-md">
            <svg class="w-14 h-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mt-6">Платеж успешно завершен</h1>
        <p class="text-gray-600 mt-3">
            Ваша подписка успешно активирована. Спасибо за ваш платеж!
        </p>
        <p class="text-gray-600 mt-3">
            Теперь вы можете добавить страницу специалиста. Нажмите на кнопку ниже:
        </p>
        <div class="mt-6">
            @can('createSpecialist', Auth::user())
                <x-primary-link-button href="{{ route('join.specialist') }}" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Добавить страницу специалиста
                </x-primary-link-button>
            @endcan
        </div>
        <div class="text-gray-600 mt-8 font-semibold">
            А также вам доступны:
        </div>
        <ul class="mt-4 text-gray-700 space-y-1">
            <li class="flex items-center">
                <span class="text-green-500 mr-3">✔</span>
                <a href="{{ route('bulletins.index') }}" class="text-cyan-600 hover:underline font-medium">Доска объявлений</a>
            </li>
            <li class="flex items-center">
                <span class="text-green-500 mr-3">✔</span>
                <a href="{{ route('webinars.index') }}" class="text-cyan-600 hover:underline font-medium">Вебинары</a>
            </li>
            <li class="flex items-center">
                <span class="text-green-500 mr-3">✔</span>
                <a href="{{ route('worksheets.index') }}" class="text-cyan-600 hover:underline font-medium">Библиотека</a>
            </li>
            <li class="flex items-center">
                <span class="text-green-500 mr-3">✔</span>
                <a href="{{ route('conferences.index') }}" class="text-cyan-600 hover:underline font-medium">Мероприятия</a>
            </li>
        </ul>
    </div>
@endsection
