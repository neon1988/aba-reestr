@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Профиль центра</h1>

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
                <p class="text-gray-600">{{ $center->country }}</p>
            </div>

            <!-- Регион -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Регион</h3>
                <p class="text-gray-600">{{ $center->region ?? 'Не указано' }}</p>
            </div>

            <!-- Город -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Город</h3>
                <p class="text-gray-600">{{ $center->city }}</p>
            </div>

            <!-- Телефон -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-700">Телефон</h3>
                <p class="text-gray-600">{{ $center->phone }}</p>
            </div>

        </div>
    </div>



@endsection
