@extends('layouts.app')

@section('content')

    <div class="px-4 max-w-lg">

        <div class="relative max-w-2xl">

            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">

                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Регистрация АВА специалиста</h1>

                <x-error-messages />

                <form x-data="formHandler()"
                      @submit.prevent="submit"
                      action="{{ route('specialists.store') }}" method="POST"
                      enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div x-show="Object.keys(errors).length > 0" x-cloak class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-lg">
                        <ul>
                            <template x-for="error in errors">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    </div>

                    <div>
                        <label class="block text-gray-700">Фото</label>

                        @if(isset($user->photo))
                            <img src="{{ $user->photo->url }}" alt="Фото пользователя"
                                 class="w-32 h-32 rounded-full object-cover mb-2">
                        @else
                            <x-upload-file
                                parent_value_name="form.photos"
                                max_files="1"
                                url="{{ route('images.store') }}"
                                @change="form.validate('photos')"
                            />

                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}

                            <template x-if="form.invalid('photos')">
                                <div x-text="form.errors.photos" class="text-sm text-red-600 space-y-1"></div>
                            </template>
                        @endif
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

                    <!-- Отчество -->
                    <div>
                        <label class="block text-gray-700">Отчество</label>
                        <input name="middlename" type="text" x-model="form.middlename"
                               @change="form.validate('middlename')"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('middlename') border-red-500 @enderror"
                               value="{{ old('middlename', $user->middlename) }}">
                        <template x-if="form.invalid('middlename')">
                            <div x-text="form.errors.middlename" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Страна -->
                    <div>
                        <label class="block text-gray-700">Страна *</label>
                        <select name="country" x-model="form.country" @change="form.validate('country')"
                                class="w-full border @error('country') border-red-500 @else border-gray-300 @enderror rounded-md p-2">
                            <option value="" disabled></option>
                            @foreach($countries as $country)
                                <option
                                    value="{{ $country->name }}" {{ old('country') == $country->name ? 'selected' : '' }}>
                                    {{ __($country->name) }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="form.invalid('country')">
                            <div x-text="form.errors.country" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Регион -->
                    <div>
                        <label class="block text-gray-700">Регион</label>
                        <input name="region" type="text" x-model="form.region"
                               @change="form.validate('region')"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('region') border-red-500 @enderror"
                               value="{{ old('region') }}">
                        <template x-if="form.invalid('region')">
                            <div x-text="form.errors.region" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Город -->
                    <div>
                        <label class="block text-gray-700">Город *</label>
                        <input name="city" type="text" x-model="form.city"
                               @change="form.validate('city')"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('city') border-red-500 @enderror"
                               value="{{ old('city') }}">
                        <template x-if="form.invalid('city')">
                            <div x-text="form.errors.city" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Образование -->
                    <div>
                        <label for="education" class="block text-gray-700">Образование *</label>
                        <select name="education" id="education" x-model="form.education"
                                @change="form.validate('education')"
                                class="w-full border border-gray-300 rounded-md p-2
                   @error('education') border-red-500 @enderror">
                            <option value="" disabled selected>Выберите уровень образования</option>
                            @foreach(App\Enums\EducationEnum::getValues() as $value)
                                <option value="{{ $value }}">
                                    {{ App\Enums\EducationEnum::getDescription($value) }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="form.invalid('education')">
                            <div x-text="form.errors.education" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Телефон -->
                    <div>
                        <label class="block text-gray-700">Телефон *</label>
                        <input name="phone" type="tel" x-model="form.phone"
                               @change="form.validate('phone')"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('phone') border-red-500 @enderror"
                               value="{{ old('phone') }}">
                        <template x-if="form.invalid('phone')">
                            <div x-text="form.errors.phone" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <!-- Документы об АВА образовании -->
                    <div>
                        <label class="block text-gray-700">Документы об АВА образовании *</label>
                        <x-upload-file
                            parent_value_name="form.files"
                            max_files="5"
                            @change="form.validate('files')"
                            url="{{ route('files.store') }}" />
                        <template x-if="form.invalid('files')">
                            <div x-text="form.errors.files" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                        Укажите Ваше образование в ABA. Пример: "3 модуля Юлии Эрц, 5 модулей Шаг впереди", магистратура
                        ИПАП и т. д."
                        Максимальный размер {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                    </div>

                    <!-- Дополнительные курсы и тренинги ABA -->
                    <div class="mt-4">
                        <label class="block text-gray-700">Дополнительные курсы и тренинги ABA</label>
                        <x-upload-file
                            parent_value_name="form.additional_courses"
                            max_files="5"
                            @change="form.validate('additional_courses')"
                            url="{{ route('files.store') }}" />
                        <template x-if="form.invalid('additional_courses')">
                            <div x-text="form.errors.additional_courses" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                        Например, курсы повышения квалификации, тренинги, семинары и т.д.
                        Максимальный размер {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                    </div>

                    <x-primary-button ::disabled="form.processing">
                        Отправить заявку
                    </x-primary-button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function formHandler() {
            return {
                form: null,
                errors: [],
                init: function () {
                    this.form = this.$form('post', this.$el.action, {
                        photos: [],
                        name: '{{ old('name', $user->name) }}',
                        lastname: '{{ old('lastname', $user->lastname) }}',
                        middlename: '{{ old('middlename', $user->middlename) }}',
                        country: '{{ old('country') }}',
                        region: '{{ old('region') }}',
                        city: '{{ old('city') }}',
                        education: '{{ old('education') }}',
                        phone: '{{ old('phone') }}',
                        files: [],
                        additional_courses: []
                    }).setErrors({{ Js::from($errors->messages()) }})
                },
                submit() {
                    this.form.submit()
                        .then(response => {
                            this.form.reset();
                            //let response_json = await response.json()
                            window.location.href = response.data['redirect_to']
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        });
                },
            }
        }
    </script>

@endsection
