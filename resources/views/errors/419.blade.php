<!-- resources/views/errors/403.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-6xl font-extrabold text-blue-500 pb-5">419</h1>
        <h2 class="text-3xl font-semibold text-gray-800 pb-5">Сессия истекла</h2>
        <p class="text-gray-600">Извините, ваша сессия истекла. Пожалуйста, обновите страницу и попробуйте снова.</p>
        <a href="{{ url('/') }}"
           class="inline-block px-6 py-3 mt-4 text-white bg-blue-500 hover:bg-blue-600 rounded-md text-lg font-medium transition duration-150 ease-in-out">
            Вернуться на главную
        </a>

        <!-- Кнопка для перезагрузки страницы -->
        <button onclick="location.reload()"
                class="mt-3 inline-block px-6 py-3 bg-gray-300 text-gray-800 font-semibold rounded-lg shadow hover:bg-gray-400 transition">
            Перезагрузить страницу
        </button>
    </div>

@endsection
