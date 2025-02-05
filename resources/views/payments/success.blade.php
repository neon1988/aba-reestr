@extends('layouts.app')

@section('content')

    <div class="bg-white shadow-lg rounded p-8 text-center max-w-md">
        <div class="flex items-center justify-center w-20 h-20 mx-auto bg-green-100 text-green-500 rounded-full">
            <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-semibold text-gray-900 mt-4">Платеж успешно завершен</h1>
        <p class="text-gray-600 mt-2">
            Ваша подписка успешно активирована. Спасибо за ваш платеж!
        </p>
        <p class="text-gray-600 mt-2">
            Теперь вам доступны:
        </p>
        <ul class="mt-4 text-gray-700 text-left">
            @can('createSpecialist', auth()->user())
                <li class="flex items-center">
                    <span class="text-green-500 mr-2">✔</span>
                    <a href="{{ route('join.specialist') }}">Добавление страницы специалиста</a>
                </li>
            @endcan
            <li class="flex items-center">
                <span class="text-green-500 mr-2">✔</span>
                <a href="{{ route('bulletins.index') }}">Доска объявлений</a>
            </li>
            <li class="flex items-center">
                <span class="text-green-500 mr-2">✔</span>
                <a href="{{ route('webinars.index') }}">Вебинары</a>
            </li>
            <li class="flex items-center">
                <span class="text-green-500 mr-2">✔</span>
                <a href="{{ route('worksheets.index') }}">Библиотека</a>
            </li>
            <li class="flex items-center">
                <span class="text-green-500 mr-2">✔</span>
                <a href="{{ route('conferences.index') }}">Мероприятия</a>
            </li>
        </ul>
    </div>
@endsection
