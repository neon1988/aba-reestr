<!-- resources/views/errors/403.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-6xl font-extrabold text-cyan-500 pb-5">500</h1>
        <h2 class="text-3xl font-semibold text-gray-800 pb-5">Внутренняя ошибка сервера</h2>
        <p class="text-gray-600">Извините, но произошла непредвиденная ошибка на сервере. Пожалуйста, попробуйте
            обновить страницу или зайдите позже. Или <a class="font-bold text-cyan-600 hover:underline"
                                                        href="{{ route('contacts') }}">свяжитесь с нами</a></p>
        <a href="{{ url('/') }}"
           class="inline-block px-6 py-3 mt-4 text-white bg-cyan-500 hover:bg-cyan-600 rounded-md text-lg font-medium transition duration-150 ease-in-out">
            Вернуться на главную
        </a>

        <a href="{{ url()->previous() }}"
           class="mt-4 inline-block px-4 py-2 text-cyan-600 font-medium hover:text-cyan-700 transition">
            Вернуться назад
        </a>
    </div>

@endsection
