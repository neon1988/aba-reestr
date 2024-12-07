@extends('layouts.settings')

@section('settings-content')

    <h4 class="text-lg font-semibold text-gray-800 mb-8">Счета и документы оплаты</h4>

    <!-- Таблица с информацией о счетах -->
    <div class="overflow-x-auto border rounded-lg shadow-md">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Счет на оплату #</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Дата счёта</th>
                <th class="px-6 py-3 hidden md:table-cell text-left text-sm font-medium text-gray-500">Срок оплаты</th>
                <th class="px-6 py-3 text-center text-sm font-medium text-gray-500">Статус</th>
                <th class="px-6 py-3 text-right text-sm font-medium text-gray-500">Сумма долга</th>
            </tr>
            </thead>
            <tbody>
            @if (False)
            @foreach($specialist->invoices as $invoice)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800">
                            {{ $invoice->invoice_number }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <span>{{ $invoice->date->format('d.m.Y') }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700 hidden md:table-cell">
                        <span>{{ $invoice->due_date->format('d.m.Y') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($invoice->status == 'paid')
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                                <i class="fa fa-fw fa-check mr-1"></i>
                                Оплачено
                            </span>
                        @elseif($invoice->status == 'unpaid')
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                <i class="fa fa-fw fa-exclamation-triangle mr-1"></i>
                                Не оплачено
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">
                                <i class="fa fa-fw fa-times mr-1"></i>
                                Просрочено
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right text-sm text-gray-700">
                        <span class="text-gray-900">{{ number_format($invoice->amount_residual, 2, ',', ' ') }} руб.</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
            @endif
        </table>
    </div>

@endsection
