@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center">
            <div class="bg-white shadow-lg rounded-lg max-w-4xl w-full p-6">

                @can('watch', $item)
                    <x-video :url="route('webinars.download', ['webinar' => $item])"/>
                @else
                    <!-- Webinar Image -->
                    <div class="relative">
                        <x-image :url="optional($item->cover)->url"
                                 :alt="$item->title"
                                 width="900" height="900" quality="90"
                                 class="w-full h-60 object-cover rounded-lg"/>
                        <div class="absolute bottom-4 left-4 bg-cyan-600 text-white text-sm px-3 py-1 rounded-lg">
                            Онлайн вебинар
                        </div>
                    </div>
                @endif

                <!-- Webinar Info -->
                <div class="mt-6">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $item->title }}</h1>

                    <div class="mt-4 text-gray-600">
                        <p class="text-lg">
                            <span class="font-semibold">Дата:</span>
                            <x-time :time="$item->start_at"/>
                        </p>
                    </div>
                </div>

                <!-- Webinar Description -->
                <div class="mt-6">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $item->description }}</p>
                </div>

                <!-- Call to Action -->
                <div class="mt-8">
                    @if (Auth::check() and Auth::user()->isSubscriptionActive() and !$item->hasRecordFile())
                        <a
                            href="{{ $item->stream_url }}" target="_blank"
                            class="w-full inline-block text-center bg-cyan-600 text-white font-semibold p-3 rounded-lg hover:bg-cyan-700 transition mb-4">
                            Открыть ссылку на вебинар
                        </a>
                    @endif

                    @if ($item->isPaid())
                        @can('purchaseSubscription', \App\Models\User::class)
                            <a href="{{ route('join') }}"
                               class="mb-3 w-full inline-block text-center bg-cyan-600 text-white font-semibold p-3 rounded-lg hover:bg-cyan-700 transition">
                                Оформить подписку для получения доступа
                            </a>
                        @endcan
                    @endif

                    @can ('toggleSubscription', $item)

                        <div
                            x-data="webinarSubscription({{ empty($userSubscription) ? 'false' : 'true' }}, '{{ route('webinars.toggle_subscription', ['webinar' => $item->id]) }}')">
                            <!-- Кнопка для подписки -->
                            <button
                                x-cloak
                                x-on:click.prevent="subscribe"
                                class="w-full inline-block text-center bg-cyan-600 text-white font-semibold py-3 rounded-lg hover:bg-cyan-700 transition">
                                <span x-show="!loading && !isSubscribed">Зарегистрироваться на вебинар</span>
                                <span x-show="!loading && isSubscribed">Отменить регистрацию на вебинар</span>
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
                                            this.loading = false;
                                            this.messageType = 'error';
                                            this.message = error.message;
                                        }
                                    }
                                };
                            }
                        </script>

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
