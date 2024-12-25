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

            <template x-if="response && response.data.status == 'success'">
                <div class="p-4 mb-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded">
                    <div class="flex items-center">
                        <span x-text="response.data.message"></span>
                    </div>
                </div>
            </template>

            <div>
                <label class="block text-gray-700">Фото</label>

                <div >
                    <x-upload-file
                        parent_value_name="form.photo"
                        max_files="1"
                        url="{{ route('files.store') }}"
                    />
                </div>
                <template x-if="form.invalid('photo')">
                    <div x-text="form.errors.photo" class="text-sm text-red-600 space-y-1"></div>
                </template>
                Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
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

            <x-primary-button ::disabled="form.processing">
                Сохранить
            </x-primary-button>
        </form>

        <script>
            function formHandler() {
                return {
                    form: null,
                    errors: [],
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
