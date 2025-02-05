@extends('layouts.app')

@section('content')

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                Платеж не завершён
            </h1>
            <p class="text-gray-600 mb-6 text-center">
                Кажется, платеж не был завершён. Пожалуйста, попробуйте снова или выберите другой вариант.
            </p>
            <div class="flex flex-col space-y-4">
                <a href="{{ $paymentUrl }}" class="block text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                    Вернуться к платежу
                </a>
                <a href="{{ route('join') }}" class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Отказаться от оплаты
                </a>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('contacts') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    Связаться с нами
                </a>
            </div>
        </div>
    </div>

@endsection
