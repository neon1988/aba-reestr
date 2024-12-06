@extends('layouts.app')

@section('content')

    <div class="px-4">

        <div class="relative max-w-2xl" x-data="formHandler()">
        <!-- Заглушка -->
        <div x-show="isLoading" x-transition
             class="absolute inset-0 bg-gray-200 bg-opacity-75 flex justify-center items-center z-10">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-cyan-500"></div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Регистрация АВА специалиста</h1>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-4">
                    <ul class="list-inside space-y-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form @submit.prevent="submitForm" action="{{ route('specialists.store') }}" method="POST"
                  enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700">Фото</label>

                    <div x-data="fileUploadHandler()"
                         x-init="$watch('formData.photo', value => photo = value)" x-effect="formData.photo = photo">
                        <!-- Поле для выбора файла -->
                        <input
                            type="file"
                            @change="handleFile"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100"
                        />

                        <!-- Прогресс загрузки -->
                        <template x-if="loading">
                            <div class="relative mt-4">
                                <div class="h-4 bg-gray-300 rounded-lg overflow-hidden">
                                    <div
                                        class="h-full bg-cyan-500 transition-all duration-300"
                                        :style="{ width: progress + '%' }"
                                    ></div>
                                </div>
                                <div class="text-sm text-gray-600 mt-1" x-text="'Загрузка: ' + progress + '%'"></div>
                            </div>
                        </template>

                        <!-- Уведомления -->
                        <template x-if="success">
                            <div class="mt-4 p-2 bg-green-100 text-green-700 rounded-lg">
                                Файл успешно загружен!
                            </div>
                        </template>

                        <template x-if="error">
                            <div class="mt-4 p-2 bg-red-100 text-red-700 rounded-lg" x-text="error"></div>
                        </template>

                        <input type="hidden" x-model="photo" />
                    </div>

                    <script>
                        function fileUploadHandler() {
                            return {
                                file: null, // Храним выбранный файл
                                loading: false, // Состояние загрузки
                                progress: 0, // Прогресс загрузки
                                success: false, // Успешность операции
                                error: null, // Сообщение об ошибке
                                photo: '',

                                // Обработчик выбора файла и автоматическая загрузка
                                handleFile(event) {
                                    this.file = event.target.files[0];
                                    if (this.file) {
                                        this.uploadFile();
                                    }
                                },

                                // Загрузка файла
                                async uploadFile() {
                                    if (!this.file) return;

                                    this.loading = true;
                                    this.progress = 0;
                                    this.success = false;
                                    this.error = null;

                                    try {
                                        // Создаем объект FormData
                                        const formData = new FormData();
                                        formData.append('photo', this.file);

                                        // Отправляем файл на сервер
                                        const response = await axios.post('/images', formData, {
                                            headers: {
                                                'Content-Type': 'multipart/form-data',
                                            },
                                            onUploadProgress: (event) => {
                                                this.progress = Math.round((event.loaded / event.total) * 100);
                                            },
                                        });

                                        // Обрабатываем успешный ответ
                                        this.success = true;
                                        this.photo = response.data.path;
                                        console.log('Файл успешно загружен:', response.data);
                                    } catch (err) {
                                        // Обрабатываем ошибку
                                        this.error = 'Ошибка при загрузке файла';
                                        console.error(err);
                                    } finally {
                                        this.loading = false;
                                        this.file = null; // Сбрасываем выбранный файл
                                    }
                                },
                            };
                        }
                    </script>

                    Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}

                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.photo">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Имя -->
                <div>
                    <label class="block text-gray-700">Имя *</label>
                    <input name="firstname" type="text" x-model="formData.firstname"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('firstname') border-red-500 @enderror"
                           value="{{ old('firstname') }}">

                    <p x-show="errors.firstname" x-text="errors.firstname" class="text-sm text-red-500 mt-1"></p>
                </div>

                <!-- Фамилия -->
                <div>
                    <label class="block text-gray-700">Фамилия *</label>
                    <input name="lastname" type="text" x-model="formData.lastname"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('lastname') border-red-500 @enderror"
                           value="{{ old('lastname') }}">
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
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('middlename') border-red-500 @enderror"
                           value="{{ old('middlename') }}">
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
                        <option value="Среднее">Среднее</option>
                        <option value="Среднее специальное">Среднее специальное</option>
                        <option value="Неполное высшее">Неполное высшее</option>
                        <option value="Высшее">Высшее</option>
                        <option value="Магистр">Магистр</option>
                        <option value="Доктор наук">Доктор наук</option>
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
                    <input name="file" type="file" x-ref="file"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('education_document') border-red-500 @enderror">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.file">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                    Укажите Ваше образование в ABA. Пример: "3 модуля Юлии Эрц, 5 модулей Шаг впереди", магистратура ИПАП и т. д."

                    Максимальный размер  {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                </div>

                <!-- Дополнительные курсы и тренинги ABA -->
                <div class="mt-4">
                    <label class="block text-gray-700">Дополнительные курсы и тренинги ABA</label>
                    <input name="additional_courses" type="file" x-ref="additional_courses"
                           class="w-full border border-gray-300 rounded-md p-2
                                      @error('additional_courses') border-red-500 @enderror">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.additional_courses">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                    Например, курсы повышения квалификации, тренинги, семинары и т.д.
                    Максимальный размер  {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                </div>

                <x-primary-button>Отправить заявку</x-primary-button>

            </form>

        </div>
    </div>
    </div>
    <script>
        function formHandler() {

            return {
                formData: {
                    photo: '',
                    firstname: '',
                    lastname: '',
                    middlename: '',
                    country: '',
                    region: '',
                    city: '',
                    education: '',
                    phone: '',
                    file: '',
                },
                errors: {},
                successMessage: '',
                isLoading: false,

                // Функция для отправки формы
                async submitForm() {
                    this.isLoading = true

                    // Сбор данных формы
                    const form = new FormData();
                    form.append('photo', this.formData.photo);
                    form.append('firstname', this.formData.firstname);
                    form.append('lastname', this.formData.lastname);
                    form.append('middlename', this.formData.middlename);
                    form.append('country', this.formData.country);
                    form.append('region', this.formData.region);
                    form.append('city', this.formData.city);
                    form.append('education', this.formData.education);
                    form.append('phone', this.formData.phone);
                    form.append('file', this.formData.file);

                    console.log(this.formData);

                    const response = await fetch('{{ route('specialists.store') }}', {
                        method: 'POST',
                        body: form,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    });

                    if (response.ok) {
                        this.isLoading = false
                        this.errors = {};
                        let response_json = await response.json()
                        window.location.href = response_json['redirect_to']
                    } else {
                        // Получаем ошибки валидации и отображаем их
                        this.isLoading = false
                        const errorData = await response.json();
                        this.errors = errorData.errors || ['Неизвестная ошибка'];
                    }
                }
            };
        }
    </script>

@endsection
