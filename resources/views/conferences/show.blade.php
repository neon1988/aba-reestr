@extends('layouts.app')
@section('content')

    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center">
            <div class="bg-white shadow-lg rounded-lg max-w-4xl w-full p-6">
                @can('watch', $item)
                    <x-video :url="route('conferences.download', ['conference' => $item])"/>
                @else
                    <!-- Webinar Image -->
                    <div class="relative">
                        <x-image :url="optional($item->cover)->url"
                                 :alt="$item->title"
                                 width="900" height="900" quality="90"
                                 class="w-full h-60 object-cover rounded-lg"/>
                        <div class="absolute bottom-4 left-4 bg-cyan-600 text-white text-sm px-3 py-1 rounded-lg">
                            Конференция
                        </div>
                    </div>
                @endcan
                <!-- Webinar Info -->
                <div class="mt-6">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $item->title }}</h1>
                    <div class="mt-4 text-gray-600">
                        @isset($item->start_at)
                            <p class="text-lg">
                                <span class="font-semibold">Дата начала:</span>
                                <x-time :time="$item->start_at"/>
                            </p>
                        @endisset
                        @isset($item->end_at)
                            <p class="text-lg">
                                <span class="font-semibold">Дата окончания:</span>
                                <x-time :time="$item->end_at"/>
                            </p>
                        @endisset
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{!! $item->description !!}</p>
                </div>
                <!-- Call to Action -->
                <div class="mt-8">
                    @if ($item->isPaid())
                        @can('purchaseSubscription', \App\Models\User::class)
                            <a href="{{ route('join') }}"
                               class="mb-3 w-full inline-block text-center bg-cyan-600 text-white font-semibold p-3 rounded-lg hover:bg-cyan-700 transition">
                                Оформить подписку для получения доступа
                            </a>
                        @endcan
                    @endif
                    @can ('requestParticipation', $item)
                        <a href="{{ $item->registration_url }}" target="_blank"
                           class="mb-3 w-full inline-block text-center bg-cyan-600 text-white font-semibold p-3 rounded-lg hover:bg-cyan-700 transition">
                            Отправить заявку на участие
                        </a>
                    @endcan
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
