@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-lg">

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
                <h2 class="text-2xl font-semibold text-gray-800">{{ $specialist->firstname }} {{ $specialist->lastname }}</h2>
                <p class="text-sm text-gray-600">{{ $specialist->middlename }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-800">Информация о специалисте</h3>
            <div class="mt-4 space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Страна:</span>
                    <span class="text-gray-700">{{ __($specialist->country) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Регион:</span>
                    <span class="text-gray-700">{{ __($specialist->region) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Город:</span>
                    <span class="text-gray-700">{{ __($specialist->city) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Образование:</span>
                    <span class="text-gray-700">{{ $specialist->education }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Телефон:</span>
                    <span class="text-gray-700">{{ $specialist->phone }}</span>
                </div>
            </div>
        </div>

        <!-- Кнопка для редактирования -->
        <div class="mt-6">
            <a href="{{ route('specialists.edit', $specialist->id) }}"
               class="text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg px-4 py-2">
                Редактировать профиль
            </a>
        </div>
    </div>

@endsection