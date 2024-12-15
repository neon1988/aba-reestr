@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg max-w-4xl w-full p-6">
            @if (!empty($webinar->record_file))
                <div>
                    <video x-ref="video" controls class="w-full">
                        <source src="{{ $webinar->record_file->url }}" type="video/mp4">
                        Ваш браузер не поддерживает тег <code>video</code>.
                    </video>
                </div>
            @else
                <!-- Webinar Image -->
                <div class="relative">
                    <img
                        src="{{ $webinar->cover->url }}"
                        alt="{{ $webinar->title }}"
                        class="w-full h-60 object-cover rounded-lg">
                    <div class="absolute bottom-4 left-4 bg-cyan-600 text-white text-sm px-3 py-1 rounded-lg">
                        Онлайн вебинар
                    </div>
                </div>
            @endif

            <!-- Webinar Info -->
            <div class="mt-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ $webinar->title }}</h1>

                <div class="mt-4 text-gray-600">
                    <p class="text-lg">
                        <span
                            class="font-semibold">Дата:</span> {{ \Carbon\Carbon::parse($webinar->start_at)->format('d.m.Y') }}
                    </p>
                    <p class="text-lg mt-2">
                        <span
                            class="font-semibold">Время:</span> {{ \Carbon\Carbon::parse($webinar->start_at)->format('H:i') }}
                        - {{ \Carbon\Carbon::parse($webinar->end_at)->format('H:i') }}
                    </p>
                </div>
            </div>

            <!-- Webinar Description -->
            <div class="mt-6">
                <p class="text-gray-700 leading-relaxed">{{ $webinar->description }}</p>
            </div>

            <!-- Call to Action -->
            <div class="mt-8">
                @if (empty($webinar->record_file))
                    <a
                        href="{{ $webinar->stream_url }}" target="_blank"
                        class="w-full inline-block text-center bg-cyan-600 text-white font-semibold py-3 rounded-lg hover:bg-cyan-700 transition mb-4">
                        Открыть ссылку на вебинар
                    </a>
                @endif

                <a href="{{ route('join') }}"
                   class="mb-3 w-full inline-block text-center bg-cyan-600 text-white font-semibold py-3 rounded-lg hover:bg-cyan-700 transition">
                    Оформить подписку для получения доступа
                </a>

                @can ('toggleSubscription', $webinar)

                    <div
                        x-data="webinarSubscription({{ empty($userSubscription) ? 'false' : 'true' }}, '{{ route('webinars.toggle_subscription', ['webinar' => $webinar->id]) }}')">
                        <!-- Кнопка для подписки -->
                        <button
                            x-cloak
                            x-on:click.prevent="subscribe"
                            class="w-full inline-block text-center bg-cyan-600 text-white font-semibold py-3 rounded-lg hover:bg-cyan-700 transition">
                            <span x-show="!loading && !isSubscribed">Подписаться на вебинар</span>
                            <span x-show="!loading && isSubscribed">Отписаться от вебинара</span>
                            <span x-show="loading">Загрузка...</span>
                        </button>

                        <!-- Сообщения от сервера -->
                        <div x-show="message" x-text="message" class="mt-4 text-center font-semibold"
                             :class="messageType === 'error' ? 'text-red-500' : 'text-green-500'"></div>
                    </div>

                    <script>
                        // Логика подписки на вебинар с использованием Alpine.js
                        function webinarSubscription(isSubscribed, url) {
                            return {
                                // Храним состояние подписки
                                isSubscribed: isSubscribed,
                                url: url,
                                loading: false,
                                message: '', // Сообщение от сервера
                                messageType: '', // Тип сообщения (success или error)

                                // Отправка запроса на сервер для подписки
                                async subscribe() {
                                    try {
                                        this.loading = true;
                                        this.message = ''; // Сбросить сообщение перед новым запросом

                                        // Сделать запрос на сервер
                                        const response = await fetch(this.url, {
                                            method: 'POST',
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                            }
                                        });

                                        const data = await response.json();

                                        this.message = data.message;

                                        if (response.ok) {
                                            this.isSubscribed = data.subscription;
                                            this.messageType = 'success';
                                        } else {
                                            this.messageType = 'error';
                                        }
                                        this.loading = false;
                                    } catch (error) {
                                        console.error('Ошибка при подписке:', error);
                                        this.loading = false;
                                        this.messageType = 'error';
                                        this.message = error.message;
                                    }
                                }
                            };
                        }
                    </script>

                @endcan
            </div>
        </div>
    </div>
@endsection
