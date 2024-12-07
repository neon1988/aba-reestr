@extends('layouts.app')

@section('content')

    <div class="px-4 max-w-lg">

        <div class="relative max-w-2xl" x-data="formHandler()">
        <!-- Заглушка -->
        <div x-show="loading" x-transition
             class="absolute inset-0 bg-gray-200 bg-opacity-75 flex justify-center items-center z-10">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-cyan-500"></div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Регистрация АВА специалиста</h1>

            <x-error-messages bag="updatePassword" />

            <form @submit.prevent="" action="{{ route('specialists.store') }}" method="POST"
                  enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700">Фото</label>

                    @if(isset($user->photo))
                        <img src="{{ $user->photo->url }}" alt="Фото пользователя"
                             class="w-32 h-32 rounded-full object-cover mb-2">
                    @else
                        <x-upload-file
                            parent_value_name="formData.photos"
                            max_files="1"
                            url="{{ route('images.store') }}">
                        </x-upload-file>

                        Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}

                        <ul class="text-sm text-red-500 mt-1">
                            <template x-for="error in errors.photos">
                                <li x-text="error"></li>
                            </template>
                        </ul>
                    @endif
                </div>

                <!-- Имя -->
                <div>
                    <label class="block text-gray-700">Имя *</label>
                    <input name="name" type="text" x-model="formData.name"
                           x-init="formData.name = $el.value"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('name') border-red-500 @enderror"
                           value="{{ old('name', $user->name) }}">

                    <p x-show="errors.name" x-text="errors.name" class="text-sm text-red-500 mt-1"></p>
                </div>

                <!-- Фамилия -->
                <div>
                    <label class="block text-gray-700">Фамилия *</label>
                    <input name="lastname" type="text" x-model="formData.lastname"
                           x-init="formData.lastname = $el.value"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('lastname') border-red-500 @enderror"
                           value="{{ old('lastname', $user->lastname) }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.lastname">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Отчество -->
                <div>
                    <label class="block text-gray-700">Отчество</label>
                    <input name="middlename" type="text" x-model="formData.middlename"
                           x-init="formData.middlename = $el.value"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('middlename') border-red-500 @enderror"
                           value="{{ old('middlename', $user->middlename) }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.middlename">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Страна -->
                <div>
                    <label class="block text-gray-700">Страна *</label>
                    <select name="country" x-model="formData.country"
                            class="w-full border @error('country') border-red-500 @else border-gray-300 @enderror rounded-md p-2">
                        <option value="" disabled></option>
                        @foreach($countries as $country)
                            <option
                                value="{{ $country->name }}" {{ old('country') == $country->name ? 'selected' : '' }}>
                                {{ __($country->name) }}
                            </option>
                        @endforeach
                    </select>
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.country">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Регион -->
                <div>
                    <label class="block text-gray-700">Регион</label>
                    <input name="region" type="text" x-model="formData.region"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('region') border-red-500 @enderror"
                           value="{{ old('region') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.region">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Город -->
                <div>
                    <label class="block text-gray-700">Город *</label>
                    <input name="city" type="text" x-model="formData.city"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('city') border-red-500 @enderror"
                           value="{{ old('city') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.city">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Образование -->
                <div>
                    <label for="education" class="block text-gray-700">Образование *</label>
                    <select name="education" id="education" x-model="formData.education"
                            class="w-full border border-gray-300 rounded-md p-2
                   @error('education') border-red-500 @enderror">
                        <option value="" disabled selected>Выберите уровень образования</option>
                        @foreach(App\Enums\EducationEnum::getValues() as $value)
                            <option value="{{ $value }}">
                                {{ App\Enums\EducationEnum::getDescription($value) }}
                            </option>
                        @endforeach
                    </select>
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.education">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Телефон -->
                <div>
                    <label class="block text-gray-700">Телефон *</label>
                    <input name="phone" type="tel" x-model="formData.phone"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('phone') border-red-500 @enderror"
                           value="{{ old('phone') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.phone">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Документы об АВА образовании -->
                <div>
                    <label class="block text-gray-700">Документы об АВА образовании *</label>
                    <x-upload-file
                        parent_value_name="formData.files"
                        max_files="5"
                        url="{{ route('files.store') }}">
                    </x-upload-file>
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.files">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                    Укажите Ваше образование в ABA. Пример: "3 модуля Юлии Эрц, 5 модулей Шаг впереди", магистратура ИПАП и т. д."

                    Максимальный размер  {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                </div>

                <!-- Дополнительные курсы и тренинги ABA -->
                <div class="mt-4">
                    <label class="block text-gray-700">Дополнительные курсы и тренинги ABA</label>
                    <x-upload-file
                        parent_value_name="formData.additional_courses"
                        max_files="5"
                        url="{{ route('files.store') }}">
                    </x-upload-file>
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.additional_courses">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                    Например, курсы повышения квалификации, тренинги, семинары и т.д.
                    Максимальный размер  {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                </div>

                <x-primary-button @click="submitForm()">Отправить заявку</x-primary-button>

            </form>

        </div>
    </div>
    </div>
    <script>
        function formHandler() {

            return {
                formData: {
                    photos: [],
                    name: '',
                    lastname: '',
                    middlename: '',
                    country: '',
                    region: '',
                    city: '',
                    education: '',
                    phone: '',
                    files: [],
                    additional_courses: []
                },
                errors: {},
                successMessage: '',
                loading: false,

                // Функция для отправки формы
                async submitForm() {
                    console.log('submitForm');

                    this.loading = true

                    console.log(this.formData.photos.map(file => file.path));

                    // Сбор данных формы
                    const form = new FormData();
                    this.formData.photos.forEach((file, index) => {
                        form.append('photo[]', file.path);
                    });
                    form.append('name', this.formData.name);
                    form.append('lastname', this.formData.lastname);
                    form.append('middlename', this.formData.middlename);
                    form.append('country', this.formData.country);
                    form.append('region', this.formData.region);
                    form.append('city', this.formData.city);
                    form.append('education', this.formData.education);
                    form.append('phone', this.formData.phone);
                    this.formData.files.forEach((file, index) => {
                        form.append('files[]', file.path);
                    });
                    this.formData.additional_courses.forEach((file, index) => {
                        form.append('additional_courses[]', file.path);
                    });

                    const response = await fetch('{{ route('specialists.store') }}', {
                        method: 'POST',
                        body: form,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    });

                    if (response.ok) {
                        this.loading = false
                        this.errors = {};
                        let response_json = await response.json()
                        window.location.href = response_json['redirect_to']
                    } else {
                        // Получаем ошибки валидации и отображаем их
                        this.loading = false
                        const errorData = await response.json();
                        this.errors = errorData.errors || ['Неизвестная ошибка'];
                    }
                }
            };
        }
    </script>

@endsection
