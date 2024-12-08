@extends('layouts.settings')

@section('settings-content')

    <h3 class="text-lg font-semibold text-gray-800 mb-8">Смена почтового ящика</h3>

    <x-error-messages bag="updatePassword" />

    <x-success-message />


    <form method="POST" action="{{ route('user.email.update') }}">
        @csrf
        @method('POST')

        <div class="grid grid-cols-1 gap-3 my-3">

            <div>
                <label class="block text-gray-700">Текущий пароль</label>
                <input name="current_password" type="password" required
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('current_password') border-red-500 @enderror"
                       value="{{ old('current_password', $specialist->current_password ?? '') }}">

                @error('current_password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Новый адрес почтового ящика</label>
                <input name="email" type="text"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('email') border-red-500 @enderror"
                       value="{{ old('email') }}">

                @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <x-primary-button>{{ __('Сменить почту') }}</x-primary-button>
    </form>

@endsection
