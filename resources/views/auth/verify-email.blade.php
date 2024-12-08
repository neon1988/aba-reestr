@extends('layouts.app')

@section('content')

    <div class="mx-4">
        <div class="max-w-md mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">

            <div class="mb-4 text-gray-600 dark:text-gray-400">
                {{ __('Thanks for signing up! Before getting started, could you verify your '.
'email address :email by clicking on the link we just emailed to you? If you didn\'t '.
'receive the email, we will gladly send you another.', ['email' => \Illuminate\Support\Facades\Auth::user()->email]) }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <!-- Кнопка для перехода на страницу смены почты -->
            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-primary-button>
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Если почта неверна, добавляем ссылку на смену почты -->
            @if (!Auth::user()->hasVerifiedEmail())
                <div class="mt-4 text-sm text-cyan-600">
                    <a href="{{ route('user.email.change') }}">Изменить почту</a>
                </div>
            @endif
        </div>
    </div>

@endsection
