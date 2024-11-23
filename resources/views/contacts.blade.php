@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center mb-8">Свяжитесь с нами</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Контактная информация -->
            <div>
                <h2 class="text-2xl font-semibold mb-4">Контактная информация</h2>
                <p class="mb-2"><strong>Адрес:</strong> ул. Примерная, 123, г. Город</p>
                <p class="mb-2"><strong>Телефон:</strong> +7 (123) 456-78-90</p>
                <p class="mb-2"><strong>Email:</strong> example@example.com</p>
                <p class="mb-2"><strong>Время работы:</strong> Пн-Пт, 9:00 - 18:00</p>
            </div>

        </div>
    </div>

@endsection
