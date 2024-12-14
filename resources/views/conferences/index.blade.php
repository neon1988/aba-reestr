@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Конференции</h1>

        <!-- Описание конференций -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Присоединяйтесь к нашим конференциям!</h2>
            <p class="text-gray-600">
                Наши конференции посвящены последним исследованиям и достижениям в области ABA-терапии. У вас будет возможность
                услышать выступления ведущих экспертов, обсудить кейсы и обменяться опытом с коллегами.
            </p>
        </div>

        <!-- Список конференций -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Предстоящие конференции</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($upcoming as $item)
                    @include('conferences.card', compact('item'))
                @endforeach
            </div>
        </div>

        <div class="mt-5">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Прошлые конференции</h2>
            @if ($ended->hasPages())
                <div class="mb-5">
                    {{ $ended->links() }}
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ended as $item)
                    @include('conferences.card', compact('item'))
                @endforeach
            </div>
            @if ($ended->hasPages())
                <div class="mb-5">
                    {{ $ended->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
