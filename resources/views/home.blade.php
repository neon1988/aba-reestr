@extends('layouts.app')

@section('content')

    <div class="text-center mb-4">
        <h2 class="text-xl font-semibold">поиск специалиста:</h2>
        <p class="text-gray-500">введите фамилию, город</p>
    </div>

    <div class="mb-6">
        <input type="text" placeholder="введите фамилию, город"
               class="w-full p-3 bg-yellow-100 border-2 border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"/>
    </div>

    <div>
        <h3 class="text-lg font-medium mb-3">расширенный поиск:</h3>
        <div class="space-y-2">
            <div class="flex items-center">
                <input type="checkbox" id="country" class="mr-2">
                <label for="country" class="text-gray-700">страна</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="region" class="mr-2">
                <label for="region" class="text-gray-700">регион</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="city" class="mr-2">
                <label for="city" class="text-gray-700">город</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="qualification" class="mr-2">
                <label for="qualification" class="text-gray-700">квалификация</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="online" class="mr-2">
                <label for="online" class="text-gray-700">онлайн сопровождение</label>
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="availability" class="mr-2">
                <label for="availability" class="text-gray-700">есть окна</label>
            </div>
        </div>
    </div>

@endsection
