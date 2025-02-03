@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center mb-8">Свяжитесь с нами</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Контактная информация -->
            <div>
                <h2 class="text-2xl font-semibold mb-4">Контактная информация</h2>
                <p class="mb-2"><strong>Email:</strong>
                    <a class="font-bold text-cyan-600 hover:underline" href="mailto:abaexpert@yandex.ru">abaexpert@yandex.ru</a> или
                    <a class="font-bold text-cyan-600 hover:underline" href="mailto:info@abaexpert.ru">info@abaexpert.ru</a>
                </p>
                <p class="mb-2"><strong>Время работы:</strong> Пн-Пт, 9:00 - 18:00</p>
                <p>ИП Волкова Анна Владимировна, ИНН 210400982057,  ОГРНИП 325210000004209</p>
            </div>
        </div>
    </div>

@endsection
