<!-- resources/views/errors/403.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-6xl font-extrabold text-cyan-500 pb-5">403</h1>
        <h2 class="text-3xl font-semibold text-gray-800 pb-5">Доступ запрещен</h2>
        <p class="text-gray-600">Извините, у вас нет прав для доступа к этой странице.</p>
        <a href="{{ url('/') }}"
           class="inline-block px-6 py-3 mt-4 text-white bg-cyan-500 hover:bg-cyan-600 rounded-md text-lg font-medium transition duration-150 ease-in-out">
            Вернуться на главную
        </a>
        <p class="mt-4 text-sm text-gray-500">
            Если вы считаете, что это ошибка, свяжитесь с администратором.
        </p>
    </div>

@endsection
