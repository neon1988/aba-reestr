@php use App\Enums\CurrencyEnum;use App\Enums\PaymentProvider;use App\Enums\PaymentStatusEnum; @endphp
@extends('layouts.settings')

@section('settings-content')

    <h4 class="text-lg font-semibold text-gray-800 mb-8">Счета и документы оплаты</h4>

    <!-- Таблица платежей -->
    <table class="min-w-full table-auto">
        <thead>
        <tr class="bg-gray-200">
            <th class="px-4 py-2 text-left text-gray-600">ID Платежа</th>
            <th class="px-4 py-2 text-left text-gray-600">Касса</th>
            <th class="px-4 py-2 text-left text-gray-600">Сумма</th>
            <th class="px-4 py-2 text-left text-gray-600">Статус</th>
            <th class="px-4 py-2 text-left text-gray-600">Дата</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($payments as $payment)
            <tr class="border-t">
                <td class="px-4 py-2 text-gray-800">
                    {{ $payment->payment_id }}
                </td>
                <td class="px-4 py-2 text-gray-800">{{ PaymentProvider::getDescription($payment->payment_provider) }}</td>
                <td class="px-4 py-2 text-gray-800">
                    {{ number_format($payment->amount, 2) }}&nbsp;{{ CurrencyEnum::getDescription($payment->currency) }}
                </td>
                <td class="px-4 py-2">{{ PaymentStatusEnum::getDescription($payment->status) }}</td>
                <td class="px-4 py-2 text-gray-800">{{ $payment->created_at->format('d.m.Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Пейджинация -->
    <div class="mt-6 flex justify-between items-center">
        <div>
            {{ $payments->links() }}
        </div>
    </div>

@endsection
