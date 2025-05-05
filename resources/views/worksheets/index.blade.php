@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-2">
        <!-- Описание учебных материалов -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добро пожаловать в раздел учебных материалов</h2>
            <p class="text-gray-600">
                Здесь вы найдете полезные ресурсы, включая PDF-файлы и обучающие видео, посвященные ABA-терапии.
                Эти материалы помогут вам углубить свои знания и применить их на практике.
                Если вы хотите поделиться своими материалами в формате видео или PDF, то
                <a href="{{ route('contacts') }}" class="text-cyan-600 hover:underline">свяжитесь с нами</a>
            </p>
        </div>

        <!-- Переключение разделов -->
        <div x-data="{ activeTab: '{{ $tag }}' }" class="mb-8">
            <div class="overflow-x-auto">
                <!-- Основные вкладки -->
                <div class="flex space-x-3 border-b">
                    @foreach (['Пособия', 'Тестирования', 'Протоколы'] as $category)
                        <a href="{{ route('worksheets.index', ['tag' => $category]) }}"
                           class="px-3 py-2 font-medium"
                           :class="{ 'border-b-2 text-cyan-600 border-cyan-600': activeTab === '{{ $category }}' }">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="overflow-x-auto">
                <!-- Подвкладки-фильтры -->
                <div class="mt-2 flex space-x-2 border-b text-sm px-1">
                    <a href="{{ route('worksheets.index', ['tag' => $tag]) }}" class="px-2 py-1">Все</a>
                    @if ($tag == 'Пособия')
                        <a href="{{ route('worksheets.index', ['tag' => $tag, 'extension' => 'mp4']) }}" class="px-2 py-1">Видео</a>
                        <a href="{{ route('worksheets.index', ['tag' => $tag, 'extension' => 'pdf']) }}" class="px-2 py-1">PDF</a>
                    @endif
                    <a href="{{ route('worksheets.index', ['tag' => $tag, 'price' => 0]) }}" class="px-2 py-1">Бесплатные</a>
                </div>
            </div>

            <div class="pt-6">
                @if ($items->count() > 0)
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
                    <p>Ни одного материала не найдено</p>
                @endif
            </div>
        </div>
    </div>
@endsection
