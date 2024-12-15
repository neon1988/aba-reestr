@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Учебные материалы</h1>

        <!-- Описание учебных материалов -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добро пожаловать в раздел учебных материалов</h2>
            <p class="text-gray-600">
                Здесь вы найдете полезные ресурсы, включая PDF-файлы и обучающие видео, посвященные ABA-терапии.
                Эти материалы помогут вам углубить свои знания и применить их на практике.
            </p>
        </div>

        <!-- Список материалов -->
        <div>
            @if ($items->count() > 0)
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Доступные материалы</h2>

            @if ($items->hasPages())
                <div class="mb-5">
                    {{ $items->links() }}
                </div>
            @endif
            <div class="mb-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    @include('worksheets.card', compact('item'))
                @endforeach
            </div>
            @if ($items->hasPages())
                <div class="mb-5">
                    {{ $items->links() }}
                </div>
            @endif
            @else
                Ни одного материала не найдено
            @endif
        </div>
    </div>
@endsection
