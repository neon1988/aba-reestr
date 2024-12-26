@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg max-w-4xl w-full p-6">

            @if (Auth::check() and Auth::user()->isSubscriptionActive() and $item->file->isVideo())
                <x-video :url="$item->file->url"/>
            @else
                <!-- Webinar Image -->
                <div class="relative">
                    <img
                        src="{{ $item->cover->url }}"
                        alt="{{ $item->title }}"
                        class="w-full h-60 object-cover rounded-lg">
                    <div class="absolute bottom-4 left-4 bg-cyan-600 text-white text-sm px-3 py-1 rounded-lg">
                        {{ mb_strtoupper($item->file->extension) }}
                    </div>
                </div>
            @endif

            <!-- Webinar Info -->
            <div class="mt-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ $item->title }}
                    ({{ mb_strtoupper($item->file->extension) }})</h1>
            </div>

            <div class="mt-6">
                <p class="text-gray-700 leading-relaxed">{{ $item->description }}</p>
            </div>

            <div class="mt-8">
                @if (Auth::check() and Auth::user()->isSubscriptionActive() and !$item->file->isVideo())
                    <a
                        href="{{ $item->file->url }}" target="_blank"
                        class="w-full inline-block text-center bg-cyan-600 text-white font-semibold py-3 rounded-lg hover:bg-cyan-700 transition mb-4">
                        Скачать {{ mb_strtoupper($item->file->extension) }}
                    </a>
                @endif

                @if (!empty($item->price) and !optional(Auth::user())->isSubscriptionActive())
                    <div class="mb-6">
                        <a href="{{ route('join') }}"
                           class="w-full inline-block text-center bg-cyan-600 text-white font-semibold py-3 rounded-lg hover:bg-cyan-700 transition">
                            Оформить подписку для получения доступа
                        </a>
                    </div>

                    <div class="mt-6 bg-gray-100 p-4 rounded-lg shadow-md">
                        <p class="text-gray-700 text-lg mb-4">
                            Или можете приобрести данный материал отдельно за <span class="font-semibold text-gray-800">{{ $item->price }} р.</span>
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
@endsection
