@php use App\Http\Resources\FileResource; @endphp
@extends('layouts.settings')

@section('settings-content')

    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 ">
                {{ __('Profile Information') }}
            </h2>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <x-error-messages/>
        <x-success-message/>

        <form x-data="formHandler()"
              @submit.prevent="submit"
              action="{{ route('profile.update') }}" method="POST"
              enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700">Фото</label>

                <div>
                    <x-upload-file
                        parent_value_name="form.photo"
                        max_files="1"
                        url="{{ route('files.store') }}"
                        accept="image/*"
                    />
                </div>
                <template x-if="form.invalid('photo')">
                    <div x-text="form.errors.photo" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Имя -->
            <div>
                <label class="block text-gray-700">Имя *</label>
                <input name="name" type="text" x-model="form.name"
                       @change="form.validate('name')"
                       class="w-full border border-gray-300 rounded-md p-2
                                      @error('name') border-red-500 @enderror"
                       value="{{ old('name', $user->name) }}">

                <template x-if="form.invalid('name')">
                    <div x-text="form.errors.name" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Фамилия -->
            <div>
                <label class="block text-gray-700">Фамилия *</label>
                <input name="lastname" type="text" x-model="form.lastname"
                       @change="form.validate('lastname')"
                       class="w-full border border-gray-300 rounded-md p-2
                                      @error('lastname') border-red-500 @enderror"
                       value="{{ old('lastname', $user->lastname) }}">
                <template x-if="form.invalid('lastname')">
                    <div x-text="form.errors.lastname" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <template x-if="errors && Object.keys(errors).length > 0">
                <div class="p-4 mb-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded">
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

            <div>
                <x-primary-button ::disabled="form.processing">
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
                    <span x-show="form.processing" x-cloak>Сохранение...</span>
                    <span x-show="!form.processing">Сохранить</span>
                </x-primary-button>

                <template x-if="response && response.data.status == 'success'">

                <span class="text-sm text-green-600 ml-3">
                    <span class="text-green-600" x-text="response.data.message"></span>
                </span>

                </template>
            </div>

        </form>

        <script>
            function formHandler() {
                return {
                    form: null,
                    errors: {},
                    response: null,
                    init: function () {
                        const photo = {{ Js::from($user->photo ? (new FileResource($user->photo))->toArray(request()) : null) }};
                        this.form = this.$form('patch', this.$el.action, {
                            photo: photo,
                            name: '{{ old('name', $user->name) }}',
                            lastname: '{{ old('lastname', $user->lastname) }}'
                        }).setErrors({{ Js::from($errors->messages()) }})
                    },
                    submit() {
                        this.response = null;
                        this.errors = {}
                        this.form.submit()
                            .then(async response => {
                                this.response = response;
                            })
                            .catch(error => {
                                this.errors = error.response.data.errors
                            });
                    }
                }
            }
        </script>
    </section>

@endsection
