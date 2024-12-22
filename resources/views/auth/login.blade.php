@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <div class="flex justify-center">

            <div class="max-w-lg p-4">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')"/>

                <form x-data="formHandler()" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')"/>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                      :value="old('email')" x-model="form.email" @change="form.validate('email')"
                                      autofocus autocomplete="username"/>
                        <template x-if="form.invalid('email')">
                            <div x-text="form.errors.email" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')"/>

                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      x-model="form.password"
                                      @change="form.validate('password')"
                                      autocomplete="current-password"/>
                        <template x-if="form.invalid('password')">
                            <div x-text="form.errors.password" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                   name="remember"
                                   x-model="form.remember_me"
                                   @change="form.validate('remember_me')">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                        <template x-if="form.invalid('remember_me')">
                            <div x-text="form.errors.remember_me" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                               href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="ms-3" ::disabled="form.processing">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>

                <script>
                    function formHandler() {
                        return {
                            form: null,
                            init: function () {
                                this.form = this.$form('post', this.$el.action, {
                                    email: '{{ old('email') }}',
                                    password: '{{ old('password') }}',
                                    remember_me: '{{ old('remember_me') }}',
                                }).setErrors({{ Js::from($errors->messages()) }})
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
