@php use App\Enums\PaymentStatusEnum; @endphp
@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                Ошибка платежа
            </h1>
            <p class="text-gray-600 mb-6 text-center">
                Произошла ошибка при обработке платежа. Попробуйте снова или выберите другой способ оплаты.
            </p>
            <div class="mt-6 text-center">
                <a href="{{ route('contacts') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    Связаться с нами
                </a>
            </div>
        </div>
    </div>
@endsection
