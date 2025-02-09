@php use App\Enums\PaymentStatusEnum; @endphp
@extends('layouts.app')

@section('content')

    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                Платеж не завершён
            </h1>
            <p class="text-gray-600 mb-6 text-center">
                @if ($payment->status->is(PaymentStatusEnum::CANCELED))
                    Платеж был отменен
                @else
                    Кажется, платеж не был завершён. Пожалуйста, попробуйте снова или выберите другой вариант.
                @endif
            </p>
            <div class="flex flex-col space-y-4">
                @if (filled($paymentUrl))
                    <a href="{{ $paymentUrl }}"
                       class="block text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                        Вернуться к платежу
                    </a>
                @endif
                @if (!$payment->status->is(PaymentStatusEnum::CANCELED))
                    <a href="{{ route('payments.cancel', compact('payment')) }}"
                       class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                        Отказаться от оплаты
                    </a>
                @endif
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('contacts') }}" class="text-sm text-gray-500 hover:text-gray-700">
                    Связаться с нами
                </a>
            </div>
        </div>
    </div>

@endsection
