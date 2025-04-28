@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center">
            <div class="bg-white shadow-lg rounded-lg max-w-4xl w-full p-6">
                @can('watch', $item)
                    <x-video :url="route('worksheets.download', ['worksheet' => $item])"/>
                    <!-- Секция "Видео не воспроизводится?" с Alpine.js -->
                    <div class="mt-4" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            class="w-full text-left text-cyan-600 font-semibold hover:text-cyan-800 transition-colors duration-200 focus:outline-none"
                        >
                            Видео не воспроизводится?
                        </button>
                        <div x-show="open" class="mt-2 text-gray-700">
                            Для корректного просмотра видео рекомендуем использовать современные браузеры: Google Chrome,
                            Яндекс.Браузер или Mozilla Firefox.
                            Это обеспечит лучшее качество воспроизведения и стабильную работу всех функций сайта.
                        </div>
                    </div>
                @else
                    <!-- Webinar Image -->
                    <div class="relative">
                        <x-image :url="optional($item->cover)->url"
                                 :alt="$item->title"
                                 width="900" height="900" quality="90"
                                 class="w-full h-60 object-cover rounded-lg"/>
                    </div>
                @endcan

                <!-- Webinar Info -->
                <div class="mt-6">
                    <!-- Tags -->
                    @if($item->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($item->tags as $tag)
                                <span class="bg-cyan-100 text-cyan-800 text-sm
                                font-medium px-3 py-1 rounded-full">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif

                    <h1 class="text-3xl font-bold text-gray-800">
                        {{ $item->title }}
                    </h1>
                </div>

                <div class="mt-6">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $item->description }}</p>
                </div>

                <div class="mt-8">
                    @can('download', $item)
                        <a
                            href="{{ route('worksheets.download', ['worksheet' => $item]) }}" target="_blank"
                            class="w-full inline-block text-center bg-cyan-600 text-white font-semibold p-3 rounded-lg hover:bg-cyan-700 transition mb-4">
                            Скачать {{ mb_strtoupper(optional($item->file)->extension) }}
                            @if ($item->file instanceof \App\Models\File)
                                - {{ formatFileSize($item->file->size) }}
                            @endif
                        </a>
                    @endcan

                    @if ($item->isPaid())
                        @can('purchaseSubscription', \App\Models\User::class)
                            <div class="mb-6">
                                <a href="{{ route('join') }}"
                                   class="w-full inline-block text-center bg-cyan-600 text-white font-semibold p-3 rounded-lg hover:bg-cyan-700 transition">
                                    Оформить подписку для получения доступа
                                </a>
                            </div>
                        @endcan
                    @endif

                    @if ((auth()->guest() and $item->isPaid()) or (auth()->check() and auth()->user()->can('buy', $item)))
                        <div class="mt-6 bg-gray-100 p-4 rounded-lg shadow-md">
                            <p class="text-gray-700 text-lg mb-4">
                                Или можете приобрести данный материал отдельно за <span
                                    class="font-semibold text-gray-800">{{ $item->price }} р.</span>
                            </p>
                            <p class="text-gray-600">
                                Для оформления покупки
                                <a href="{{ route('contacts') }}"
                                   class="text-cyan-600 hover:text-cyan-800">
                                    свяжитесь с нами
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
