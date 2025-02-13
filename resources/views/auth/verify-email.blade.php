@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')

@section('content')

    <div class="w-full max-w-md bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-lg">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200 text-center mb-4">
            Спасибо за регистрацию!
        </h2>

        <p class="text-gray-600 dark:text-gray-400 text-center mb-4">
            Мы отправили письмо с подтверждением на ваш адрес:
            <span class="font-medium text-gray-800 dark:text-gray-100">{{ Auth::user()->email }}</span>.
        </p>

        <p class="text-gray-600 dark:text-gray-400 text-center mb-4">
            Проверьте папку "Входящие" и "Спам".
            Если письмо не пришло в течение 2–3 минут, запросите повторную отправку.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                {{ __('Новое письмо с подтверждением отправлено.') }}
            </div>
        @endif

        <div class="mt-4 flex flex-col space-y-3">

            <div x-data="{
                currentTime: Math.floor(Date.now() / 1000),
                showButtonTime: @js(Auth::user()->getLastVerificationEmailSentTimestamp())
                }"
                 x-init="setInterval(() => currentTime = Math.floor(Date.now() / 1000), 1000)">
                <!-- Показ кнопки, если текущее время больше или равно времени для показа -->
                <form x-show="currentTime - 60 >= showButtonTime" method="POST"
                      action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                        {{ __('Отправить письмо повторно') }}
                    </button>
                </form>
            </div>

            @if (!Auth::user()->hasVerifiedEmail())
                <a href="{{ route('user.email.change') }}"
                   class="w-full text-center text-sm font-medium text-cyan-600 hover:underline">
                    Изменить почту
                </a>
            @endif
        </div>
    </div>

@endsection
