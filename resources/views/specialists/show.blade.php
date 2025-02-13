@extends('layouts.app')

@section('content')

    <div class="mx-4">
        <div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
            @if ($specialist->isSentForReview())
                <!-- Сообщение о модерации -->
                <div class="mb-8 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold">Ваш профиль находится на проверке!</h4>
                    <p class="text-gray-600">
                        Мы благодарим вас за регистрацию и загрузку информации. Ваш профиль будет рассмотрен нашим
                        модератором в ближайшее время. Пожалуйста, ожидайте уведомление о статусе вашего профиля.
                    </p>
                    <p class="mt-2 text-gray-600">
                        Если будут нужны дополнительные данные или уточнения, мы свяжемся с вами по указанному номеру
                        телефона. Благодарим за терпение!
                    </p>
                </div>
            @endif

            <div class="mt-6">
                <div class="flex flex-col sm:flex-row">
                    <div class="w-64 h-64 rounded-sm bg-gray-300 overflow-hidden shrink-0">
                        <x-image :url="optional($specialist->photo)->url"
                                 :alt="$specialist->name"
                                 width="300" height="300" quality="90"
                                 class="w-full h-full object-cover"/>
                    </div>
                    <div class="sm:ml-10 ml-0 flex-grow mt-5 sm:mt-0 space-y-2">
                        <!-- Имя специалиста -->
                        <div class="mb-5">
                            <h2 class="text-4xl font-semibold text-gray-800">{{ $specialist->name }} {{ $specialist->lastname }}</h2>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between">
                            <span class="text-gray-500">Страна:</span>
                            <span
                                class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ __($specialist->country) }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between">
                            <span class="text-gray-500">Регион:</span>
                            <span
                                class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ __($specialist->region) }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between">
                            <span class="text-gray-500">Город:</span>
                            <span
                                class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ __($specialist->city) }}</span>
                        </div>

                        @if ($specialist->show_email and $user = $specialist->users()->first())
                            <div class="flex flex-col sm:flex-row justify-between">
                                <span class="text-gray-500">Электронная почта:</span>
                                <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">
                                    {{ $user->email }}
                                </span>
                            </div>
                        @endif

                        @if ($specialist->show_phone)
                            <div class="flex flex-col sm:flex-row justify-between">
                                <span class="text-gray-500">Телефон:</span>
                                <span
                                    class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ $specialist->phone }}</span>
                            </div>
                        @endif

                        @isset($specialist->telegram_profile)
                            <div class="flex flex-col sm:flex-row justify-between">
                                <span class="text-gray-500">Telegram: </span>
                                <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">
                                <a href="https://t.me/{{ $specialist->telegram_profile }}"
                                   class="text-cyan-600 hover:underline"
                                   target="_blank">
                                    {{ $specialist->telegram_profile }}
                                </a>
                                </span>
                            </div>
                        @endisset

                        @isset($specialist->vk_profile)
                            <div class="flex flex-col sm:flex-row justify-between">
                                <span class="text-gray-500">VK: </span>
                                <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">
                                <a href="https://vk.com/{{ $specialist->vk_profile }}"
                                   class="text-cyan-600 hover:underline" target="_blank">
                                    {{ $specialist->vk_profile }}
                                </a>
                                </span>
                            </div>
                        @endisset

                        @isset($specialist->center_name)
                            <div class="flex flex-col sm:flex-row justify-between">
                                <span class="text-gray-500">Центр:</span>
                                <span
                                    class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ $specialist->center_name }}</span>
                            </div>
                        @endisset
                    </div>
                </div>

                <div class="mt-4 space-y-4">

                    @isset($specialist->aba_education)
                        <div class="flex flex-col justify-between">
                            <span class="text-gray-500">Образование в области ABA:</span>
                            <span
                                class="text-gray-700 break-words whitespace-pre-line">{{ $specialist->aba_education }}</span>
                        </div>
                    @endisset

                    @isset($specialist->aba_trainings)
                        <div class="flex flex-col justify-between">
                            <span class="text-gray-500">Тренинги в области ABA:</span>
                            <span
                                class="text-gray-700 break-words whitespace-pre-line">{{ $specialist->aba_trainings }}</span>
                        </div>
                    @endisset

                    @isset($specialist->professional_specialization)
                        <div class="flex flex-col justify-between">
                            <span class="text-gray-500">Специализация в сфере профессиональных интересов:</span>
                            <span
                                class="text-gray-700 break-words whitespace-pre-line">{{ $specialist->professional_specialization }}</span>
                        </div>
                    @endisset

                    @isset($specialist->additional_info)
                        <div class="flex flex-col justify-between">
                            <span class="text-gray-500">Дополнительная информация:</span>
                            <span
                                class="text-gray-700 break-words whitespace-pre-line">{{ $specialist->additional_info }}</span>
                        </div>
                    @endisset
                </div>

                <div class="mt-8">
                    <div class=" grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($specialist->certificates as $certificate)
                            <a href="{{ optional($certificate)->url }}" target="_blank"
                               class="relative group flex items-center justify-center bg-gray-100 rounded-lg p-2">
                                <x-image :url="optional($certificate)->url"
                                         width="500" height="500" quality="90"
                                         class="rounded-lg shadow-lg" />
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @can('update', $specialist)
                <div class="mt-8">
                    <x-primary-link-button href="{{ route('specialists.edit', $specialist->id) }}">
                        Редактировать профиль
                    </x-primary-link-button>
                </div>
            @endcan

        </div>
    </div>
@endsection
