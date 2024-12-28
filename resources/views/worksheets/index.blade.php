@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-2">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Учебные материалы</h1>

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
        <div x-data="{ activeTab: '{{ $extension }}' }" class="mb-8">
            <div class="flex space-x-4 border-b border-gray-200">
                <a href="{{ route('worksheets.index') }}"
                   class="px-4 py-2 text-gray-700 font-semibold hover:text-cyan-600"
                   :class="{ 'border-b-2 border-cyan-600 text-cyan-600': activeTab === '' }">
                    Все
                </a>
                <a href="{{ route('worksheets.index', ['extension' => 'pdf']) }}"
                    class="px-4 py-2 text-gray-700 font-semibold hover:text-cyan-600"
                    :class="{ 'border-b-2 border-cyan-600 text-cyan-600': activeTab === 'pdf' }">
                    PDF материалы
                </a>
                <a href="{{ route('worksheets.index', ['extension' => 'mp4']) }}"
                    class="px-4 py-2 text-gray-700 font-semibold hover:text-cyan-600"
                    :class="{ 'border-b-2 border-cyan-600 text-cyan-600': activeTab === 'mp4' }">
                    Видео материалы
                </a>
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
