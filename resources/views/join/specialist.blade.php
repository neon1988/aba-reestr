@extends('layouts.app')

@section('content')

    <div class="px-4 max-w-lg">

        <div class="relative max-w-2xl">

            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">

                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Регистрация АВА специалиста</h1>

                <p class="text-md mb-4">
                    Укажите сведения о вашем основном образовании,
                    а также о вашем образовании в области прикладного анализа поведения.
                    В случае возникновения проблем
                    <a href="{{ route('contacts') }}"
                       target="_blank"
                       class="text-cyan-600 hover:underline">свяжитесь с нами</a>.
                </p>

                <x-error-messages/>

                <form x-data="formHandler()"
                      @submit.prevent="submit"
                      action="{{ route('specialists.store') }}" method="POST"
                      enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700">Фото</label>

                        @if(isset($user->photo))
                            <x-image :url="$user->photo->url"
                                     :alt="$user->fullName"
                                     width="200" height="200" quality="90"
                                     class="w-32 h-32 rounded-full object-cover mb-2" />
                        @else
                            <x-upload-file
                                parent_value_name="form.photo"
                                max_files="1"
                                url="{{ route('files.store') }}"
                                @change="form.validate('photo')"
                                accept="image/*"
                            />
                            <template x-if="form.invalid('photo')">
                                <div x-text="form.errors.photo" class="text-sm text-red-600 space-y-1"></div>
                            </template>
                            <span class="text-sm text-gray-700">
                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                            </span>
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
                            url="{{ route('files.store') }}"/>
                        <template x-if="form.invalid('files')">
                            <div x-text="form.errors.files" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                        <div class="text-gray-600 text-sm">
                            Укажите Ваше образование в ABA. Пример: "3 модуля Юлии Эрц, 5 модулей Шаг впереди",
                            магистратура
                            ИПАП и т. д."
                            <span class="text-sm text-gray-700">
                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                            </span>
                        </div>
                    </div>

                    <!-- Дополнительные курсы и тренинги ABA -->
                    <div class="mt-4">
                        <label class="block text-gray-700">Дополнительные курсы и тренинги ABA</label>
                        <x-upload-file
                            parent_value_name="form.additional_courses"
                            max_files="5"
                            @change="form.validate('additional_courses')"
                            url="{{ route('files.store') }}"/>
                        <template x-if="form.invalid('additional_courses')">
                            <div x-text="form.errors.additional_courses" class="text-sm text-red-600 space-y-1"></div>
                        </template>
                        <div class="text-gray-600 text-sm">
                            Например, курсы повышения квалификации, тренинги, семинары и т.д.
                            <span class="text-sm text-gray-700">
                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex space-x-2">
                            <input
                                id="confirm_document_authenticity"
                                name="confirm_document_authenticity"
                                x-model="form.confirm_document_authenticity"
                                @change="form.validate('confirm_document_authenticity')"
                                type="checkbox" class="text-cyan-600 mt-1 mr-2"/>
                            <label for="document-confirmation" class="text-gray-600">
                                Я, <span x-text="form.name" class="font-semibold"></span>
                                <span x-text="form.lastname" class="font-semibold"></span>
                                <span x-text="form.middlename" class="font-semibold"></span>,
                                подлинность приложенных документов подтверждаю.
                            </label>
                        </div>
                        <template x-if="form.invalid('confirm_document_authenticity')">
                            <div x-text="form.errors.confirm_document_authenticity"
                                 class="text-sm text-red-600 space-y-1"></div>
                        </template>
                    </div>

                    <div class="text-gray-600">
                        <p class="mt-2">
                            В случае возникновения проблем
                            <a href="{{ route('contacts') }}"
                               target="_blank"
                               class="text-cyan-600 hover:underline">свяжитесь с нами</a>.
                        </p>
                    </div>

                    <template x-if="errors && Object.keys(errors).length > 0" x-cloak>
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
                        <span x-show="form.processing">Обработка...</span>
                        <span x-show="!form.processing">Отправить заявку</span>
                    </x-primary-button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function formHandler() {
            return {
                form: null,
                errors: {},
                init: function () {
                    this.form = this.$form('post', this.$el.action, {
                        photo: '{{ old('photo') }}',
                        name: '{{ old('name', $user->name) }}',
                        lastname: '{{ old('lastname', $user->lastname) }}',
                        middlename: '{{ old('middlename', $user->middlename) }}',
                        country: '{{ old('country') }}',
                        region: '{{ old('region') }}',
                        city: '{{ old('city') }}',
                        education: '{{ old('education') }}',
                        phone: '{{ old('phone') }}',
                        files: '{{ old('files') }}',
                        additional_courses: '{{ old('additional_courses') }}',
                        confirm_document_authenticity: '{{ old('confirm_document_authenticity') }}'
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
