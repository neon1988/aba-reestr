@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <div class="flex justify-center">

            <div class="max-w-lg p-4">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')"/>

                <form x-data="formHandler()" @submit.prevent="submit" method="POST" action="{{ route('login') }}">
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
                                   class="rounded border-gray-300 text-cyan-600 shadow-sm focus:ring-cyan-500"
                                   name="remember"
                                   x-model="form.remember_me"
                                   @change="form.validate('remember_me')">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                        <template x-if="form.invalid('remember_me')">
                            <div x-text="form.errors.remember_me" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <template x-if="errors && Object.keys(errors).length > 0">
                        <div class="p-4 mt-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded">
                            <div class="flex items-center">
                                <span>Пожалуйста, исправьте следующие ошибки:</span>
                            </div>
                            <ul class="mt-2">
                                <template x-for="(error, field) in errors" :key="field">
                                    <li class="text-sm text-red-600" x-text="error[0]"></li>
                                </template>
                            </ul>
                        </div>
                    </template>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500"
                               href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-primary-button class="ms-3" ::disabled="form.processing">
                            <svg x-show="form.processing" aria-hidden="true" role="status"
                                 class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="#E5E7EB"/>
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentColor"/>
                            </svg>
                            <span x-show="form.processing">Загрузка...</span>
                            <span x-show="!form.processing">{{ __('Log in') }}</span>
                        </x-primary-button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <span class="text-gray-600 text-sm">{{ __('Don\'t have an account?') }}</span>
                    <a href="{{ route('register') }}" class="text-cyan-600 hover:text-cyan-900 font-semibold">
                        {{ __('Register') }}
                    </a>
                </div>

                <script>
                    function formHandler() {
                        return {
                            form: null,
                            errors: {},
                            response: null,
                            init: function () {
                                this.form = this.$form('post', this.$el.action, {
                                    email: '{{ old('email') }}',
                                    password: '{{ old('password') }}',
                                    remember_me: '{{ old('remember_me') }}',
                                }).setErrors({{ Js::from($errors->messages()) }})
                            },
                            submit() {
                                this.response = null;
                                this.errors = {}
                                this.form.submit()
                                    .then(async response => {
                                        this.response = response;
                                        console.log(this.response);
                                        window.location.href = this.response.data['redirect_to']
                                    })
                                    .catch(error => {
                                        this.errors = error.response.data.errors
                                    });
                            }
                        }
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
