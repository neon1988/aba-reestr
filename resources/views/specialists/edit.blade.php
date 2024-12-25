@php use App\Http\Resources\FileResource; @endphp
@extends('layouts.settings')

@section('settings-content')

    <h3 class="text-lg font-semibold text-gray-800 mb-8">Редактировать профиль специалиста</h3>

    <x-error-messages />

    <x-success-message />

    <form x-data="formHandler()"
          @submit.prevent="submit"
          action="{{ route('specialists.profile.update', $specialist->id) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <template x-if="response && response.data.status == 'success'">
            <div class="p-4 mb-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded">
                <div class="flex items-center">
                    <span x-text="response.data.message"></span>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 gap-3 my-3">

            <!-- Фото -->
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
                       value="{{ old('name', $specialist->name ?? '') }}">

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
                       value="{{ old('lastname', $specialist->lastname ?? '') }}">

                <template x-if="form.invalid('lastname')">
                    <div x-text="form.errors.lastname" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Отчество -->
            <div>
                <label class="block text-gray-700">Отчество</label>
                <input name="middlename" type="text" x-model="form.middlename"
                       @change="form.validate('middlename')"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('middlename') border-red-500 @enderror"
                       value="{{ old('middlename', $specialist->middlename ?? '') }}">

                <template x-if="form.invalid('middlename')">
                    <div x-text="form.errors.middlename" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Телефон -->
            <div>
                <label class="block text-gray-700">Телефон</label>
                <input name="phone" type="text" x-model="form.phone"
                       @change="form.validate('phone')"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('phone') border-red-500 @enderror"
                       value="{{ old('phone', $specialist->phone ?? '') }}">

                <template x-if="form.invalid('phone')">
                    <div x-text="form.errors.phone" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Почта видна всем -->
            <div class="mb-4">
                <label class="block text-gray-700">Почта видна всем пользователям</label>
                <input name="show_email" type="checkbox" x-model="form.show_email"
                       class="mr-2 leading-tight" value="1"
                    {{ old('show_email', $specialist->show_email ?? false) ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Показать почту всем пользователям</span>
            </div>

            <!-- Телефон виден всем -->
            <div class="mb-4">
                <label class="block text-gray-700">Телефон виден всем пользователям</label>
                <input name="show_phone" type="checkbox" x-model="form.show_phone"
                       class="mr-2 leading-tight" value="1"
                    {{ old('show_phone', $specialist->show_phone ?? false) ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Показать телефон всем пользователям</span>
            </div>

            <!-- Профиль телеграмм -->
            <div>
                <label class="block text-gray-700">Профиль телеграмм</label>
                <input name="telegram_profile" type="text" x-model="form.telegram_profile"
                       @change="form.validate('telegram_profile')"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('telegram_profile') border-red-500 @enderror"
                       value="{{ old('telegram_profile', $specialist->telegram_profile ?? '') }}">

                <template x-if="form.invalid('telegram_profile')">
                    <div x-text="form.errors.telegram_profile" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>
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
                    const photo = {{ Js::from((new FileResource($specialist->photo))->toArray(request())) }};
                    this.form = this.$form('patch', this.$el.action, {
                        photo: photo,
                        name: '{{ old('name', $specialist->name) }}',
                        lastname: '{{ old('lastname', $specialist->lastname) }}',
                        middlename: '{{ old('middlename', $specialist->middlename) }}',
                        phone: '{{ old('phone', $specialist->phone) }}',
                        show_email: '{{ old('show_email', $specialist->show_email ? 1 : 0) }}',
                        show_phone: '{{ old('show_phone', $specialist->show_phone ? 1 : 0) }}',
                        telegram_profile: '{{ old('telegram_profile', $specialist->telegram_profile) }}',
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
                },
            }
        }
    </script>

@endsection
