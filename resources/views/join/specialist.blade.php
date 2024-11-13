@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Регистрация АВА специалиста</h1>

                <form action="#" method="POST" class="space-y-4">
                    <!-- Имя -->
                    <div>
                        <label class="block text-gray-700">Имя *</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>

                    <!-- Фамилия -->
                    <div>
                        <label class="block text-gray-700">Фамилия *</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>

                    <!-- Отчество -->
                    <div>
                        <label class="block text-gray-700">Отчество</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    <!-- Страна -->
                    <div>
                        <label class="block text-gray-700">Страна *</label>
                        <select class="w-full border border-gray-300 rounded-md p-2" required>
                            <option value="">Выберите страну</option>
                            <!-- Здесь можно добавить варианты стран -->
                        </select>
                    </div>

                    <!-- Регион -->
                    <div>
                        <label class="block text-gray-700">Регион</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    <!-- Город -->
                    <div>
                        <label class="block text-gray-700">Город *</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>

                    <!-- Эл. почта -->
                    <div>
                        <label class="block text-gray-700">Эл. почта *</label>
                        <input type="email" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>

                    <!-- Образование -->
                    <div>
                        <label class="block text-gray-700">Образование *</label>
                        <input type="text" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>

                    <!-- Телефон -->
                    <div>
                        <label class="block text-gray-700">Телефон *</label>
                        <input type="tel" class="w-full border border-gray-300 rounded-md p-2" required>
                    </div>

                    <!-- Документы об АВА образовании -->
                    <div>
                        <label class="block text-gray-700">Документы об АВА образовании</label>
                        <input type="file" class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    <!-- Кнопка отправки -->
                    <div class="text-center">
                        <button type="submit"
                                class="bg-teal-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-teal-700 transition">
                            Подать заявку
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
