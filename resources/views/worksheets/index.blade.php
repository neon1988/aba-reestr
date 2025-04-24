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
        <div x-data="{ activeTab: '{{ $activeTab }}' }" class="mb-8">
            <div class="overflow-x-auto">
                <div class="flex space-x-4 border-b border-gray-200 px-4 w-max sm:min-w-0 mb-2">
                    <a href="{{ route('worksheets.index') }}"
                       class="whitespace-nowrap sm:px-4 py-2 text-gray-700 font-semibold hover:text-cyan-600"
                       :class="{ 'border-b-2 border-cyan-600 text-cyan-600': activeTab === '' }">
                        Все
                    </a>
                    <a href="{{ route('worksheets.index', ['extension' => 'pdf']) }}"
                       class="whitespace-nowrap px-2 sm:px-4 py-2 text-gray-700 font-semibold hover:text-cyan-600"
                       :class="{ 'border-b-2 border-cyan-600 text-cyan-600': activeTab === 'pdf' }">
                        PDF
                    </a>
                    <a href="{{ route('worksheets.index', ['extension' => 'mp4']) }}"
                       class="whitespace-nowrap px-2 sm:px-4 py-2 text-gray-700 font-semibold hover:text-cyan-600"
                       :class="{ 'border-b-2 border-cyan-600 text-cyan-600': activeTab === 'mp4' }">
                        Видео
                    </a>
                    <a href="{{ route('worksheets.index', ['tag' => 'Протокол']) }}"
                       class="whitespace-nowrap px-2 sm:px-4 py-2 text-gray-700 font-semibold hover:text-cyan-600"
                       :class="{ 'border-b-2 border-cyan-600 text-cyan-600': activeTab === 'Протокол' }">
                        Протоколы
                    </a>
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
