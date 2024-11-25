@extends('layouts.app')

@section('content')

    <h1 class="text-3xl font-bold text-center text-gray-800 mt-4 mb-8">Выберите тип регистрации</h1>

    <div class="max-w-4xl grid gap-4 md:grid-cols-2">
        <!-- Блок для регистрации специалиста -->
        <div class="bg-white shadow-md sm:rounded-lg p-4 sm:p-6 hover:shadow-lg transition">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Регистрация как АВА-специалист</h2>
            <p class="text-gray-600 mb-6">
                Зарегистрируйтесь как специалист, чтобы привлечь клиентов, демонстрировать свои навыки и опыт, а также
                предоставлять информацию о доступности для консультаций. Вы сможете добавлять фото, видео и отзывы с
                ваших занятий.
            </p>
            <ul class="text-gray-600 mb-4 space-y-2">
                <li>✓ Создавайте и управляйте своим профилем</li>
                <li>✓ Размещайте документы об образовании</li>
                <li>✓ Делитесь фото и видео с занятий</li>
                <li>✓ Укажите центр, в котором работаете (если применимо)</li>
            </ul>
            <a href="{{ route('join.specialist') }}"
               class="inline-block bg-cyan-500 text-white px-4 py-2 rounded hover:bg-cyan-600 transition">
                Зарегистрироваться как специалист
            </a>
        </div>

        <!-- Блок для регистрации центра -->
        <div class="bg-white shadow-md sm:rounded-lg p-4 sm:p-6 hover:shadow-lg transition">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Регистрация как Центр</h2>
            <p class="text-gray-600 mb-6">
                Зарегистрируйтесь как центр, чтобы управлять услугами, создавать расписание, добавлять интенсивы и
                привлекать специалистов для работы в вашей организации. Вы сможете представить преимущества центра и его
                уникальные предложения.
            </p>
            <ul class="text-gray-600 mb-4 space-y-2">
                <li>✓ Управляйте профилем вашего центра</li>
                <li>✓ Добавляйте услуги и интенсивные программы</li>
                <li>✓ Настраивайте расписание и окна доступности</li>
                <li>✓ Привлекайте АВА-специалистов</li>
            </ul>
            <a href="{{ route('join.center') }}"
               class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                Зарегистрироваться как центр
            </a>
        </div>
    </div>

@endsection
