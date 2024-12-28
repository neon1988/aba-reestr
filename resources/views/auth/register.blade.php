@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <div class="flex justify-center">
            <div class="max-w-lg p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text"
                                      name="name" :value="old('name')"
                                      required autofocus autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                    <!-- Lastname -->
                    <div class="mt-4">
                        <x-input-label for="lastname" :value="__('Lastname')"/>
                        <x-text-input id="lastname" class="block mt-1 w-full" type="text"
                                      name="lastname" :value="old('lastname')"
                                      required autofocus autocomplete="lastname"/>
                        <x-input-error :messages="$errors->get('lastname')" class="mt-2"/>
                    </div>
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')"/>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                      :value="old('email')"
                                      required autocomplete="username"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>
                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')"/>
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation" required autocomplete="new-password"/>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                    </div>
                    <!-- Accept Privacy Policy -->
                    <div class="mt-4">
                        <label for="accept_private_policy" class="flex items-center">
                            <input name="accept_private_policy" type="hidden" value="0">
                            <input id="accept_private_policy" type="checkbox" name="accept_private_policy"
                                   class="mr-2 rounded border-gray-300 text-cyan-600 shadow-sm focus:ring-cyan-500"
                                   value="1" @if (old('accept_private_policy')) checked @endif
                                   required>
                            <span class="text-sm text-gray-600">
                                Я соглашаюсь с
                                <a target="_blank" href="{{ route('privacy-policy') }}"
                                    class="text-cyan-600 hover:underline">Политикой обработки персональных данных
                                </a>
                            </span>
                        </label>
                        <x-input-error :messages="$errors->get('accept_private_policy')" class="mt-2"/>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500"
                           href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
