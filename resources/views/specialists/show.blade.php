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

            <div class="flex items-center space-x-4">
                <!-- Фото специалиста (если есть) -->
                <div class="w-20 h-20 rounded-full bg-gray-300 overflow-hidden">
                    <img src="{{ $specialist->photo->url ?? asset('default-avatar.png') }}" alt="Profile Photo"
                         class="w-full h-full object-cover">
                </div>

                <!-- Имя специалиста -->
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $specialist->name }} {{ $user->lastname }}</h2>
                    <p class="text-sm text-gray-600">{{ $user->middlename }}</p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-800">Информация о специалисте</h3>
                <div class="mt-4 space-y-4">
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
                        <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ __($specialist->city) }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between">
                        <span class="text-gray-500">Образование:</span>
                        <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">
                            {{ App\Enums\EducationEnum::getDescription($specialist->education) }}
                        </span>
                    </div>
                    @if ($specialist->show_email)
                        <div class="flex flex-col sm:flex-row justify-between">
                            <span class="text-gray-500">Электронная почта:</span>
                            <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ $specialist->user->email }}</span>
                        </div>
                    @endif
                    @if ($specialist->show_phone)
                    <div class="flex flex-col sm:flex-row justify-between">
                        <span class="text-gray-500">Телефон:</span>
                        <span class="text-gray-700 mt-1 sm:mt-0 sm:ml-3 break-words">{{ $specialist->phone }}</span>
                    </div>
                        @endif
                </div>
            </div>

            @can('update', $specialist)
                <div class="mt-4">
                    <x-primary-link-button href="{{ route('specialists.edit', $specialist->id) }}">
                        Редактировать профиль
                    </x-primary-link-button>
                </div>
            @endcan

        </div>
    </div>
@endsection
