<!-- resources/views/errors/404.blade.php -->

@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-6xl font-bold text-cyan-500 pb-5">404</h1>
        <h2 class="text-3xl font-semibold text-gray-800 pb-5">Страница не найдена</h2>
        <p class="text-gray-600">К сожалению, страница, которую вы ищете, не существует или была перемещена.</p>
        <a href="{{ url('/') }}"
           class="inline-block px-6 py-3 mt-4 text-white bg-cyan-500 hover:bg-cyan-600 rounded-md text-lg font-medium transition duration-150 ease-in-out">
            Вернуться на главную
        </a>
        <p class="mt-4 text-sm text-gray-500">
            Если вы считаете, что это ошибка,
            <a class="font-bold text-cyan-600 hover:underline"
               href="{{ route('contacts') }}">свяжитесь с нами</a>.
        </p>
    </div>

@endsection
