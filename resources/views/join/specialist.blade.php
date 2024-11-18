@extends('layouts.app')

@section('content')

    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6 relative" x-data="formHandler()">
        <!-- Заглушка -->
        <div x-show="isLoading" x-transition
             class="absolute inset-0 bg-gray-200 bg-opacity-75 flex justify-center items-center z-10">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

            <div class="max-w-xl">
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
                        <input name="photo" type="file" x-ref="photo"
                               class="w-full border border-gray-300 rounded-md p-2">
                        Максимальный размер {{ formatFileSize(config('uploads.image_max_size') * 1000) }}
                        <p x-show="errors.photo" x-text="errors.photo" class="text-sm text-red-500 mt-1"></p>
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
                        <p x-show="errors.lastname" x-text="errors.lastname" class="text-sm text-red-500 mt-1"></p>
                    </div>

                    <!-- Отчество -->
                    <div>
                        <label class="block text-gray-700">Отчество</label>
                        <input name="middlename" type="text" x-model="formData.middlename"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('middlename') border-red-500 @enderror"
                               value="{{ old('middlename') }}">
                        <p x-show="errors.middlename" x-text="errors.middlename" class="text-sm text-red-500 mt-1"></p>
                    </div>

                    <!-- Страна -->
                    <div>
                        <label class="block text-gray-700">Страна *</label>
                        <select name="country" x-model="formData.country"
                                class="w-full border @error('country') border-red-500 @else border-gray-300 @enderror rounded-md p-2">
                            @foreach($countries as $country)
                                <option
                                    value="{{ $country->name }}" {{ old('country') == $country->name ? 'selected' : '' }}>
                                    {{ __($country->name) }}
                                </option>
                            @endforeach
                        </select>
                        <p x-show="errors.country" x-text="errors.country" class="text-sm text-red-500 mt-1"></p>
                    </div>

                    <!-- Регион -->
                    <div>
                        <label class="block text-gray-700">Регион</label>
                        <input name="region" type="text" x-model="formData.region"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('region') border-red-500 @enderror"
                               value="{{ old('region') }}">
                        <p x-show="errors.region" x-text="errors.region" class="text-sm text-red-500 mt-1"></p>
                    </div>

                    <!-- Город -->
                    <div>
                        <label class="block text-gray-700">Город *</label>
                        <input name="city" type="text" x-model="formData.city"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('city') border-red-500 @enderror"
                               value="{{ old('city') }}">
                        <p x-show="errors.city" x-text="errors.city" class="text-sm text-red-500 mt-1"></p>
                    </div>

                    <!-- Образование -->
                    <div>
                        <label class="block text-gray-700">Образование *</label>
                        <input name="education" type="text" x-model="formData.education"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('education') border-red-500 @enderror"
                               value="{{ old('education') }}">
                        <p x-show="errors.education" x-text="errors.education" class="text-sm text-red-500 mt-1"></p>
                    </div>

                    <!-- Телефон -->
                    <div>
                        <label class="block text-gray-700">Телефон *</label>
                        <input name="phone" type="tel" x-model="formData.phone"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('phone') border-red-500 @enderror"
                               value="{{ old('phone') }}">
                        <p x-show="errors.phone" x-text="errors.phone" class="text-sm text-red-500 mt-1"></p>
                    </div>

                    <!-- Документы об АВА образовании -->
                    <div>
                        <label class="block text-gray-700">Документы об АВА образовании</label>
                        <input name="file" type="file" x-ref="file"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('education_document') border-red-500 @enderror">
                        <p x-show="errors.file" x-text="errors.file" class="text-sm text-red-500 mt-1"></p>

                        Максимальный размер {{ formatFileSize(config('uploads.document_max_size') * 1000) }}
                    </div>

                    <!-- Кнопка отправки -->
                    <div class="text-center">
                        <x-primary-button>Подать заявку</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function formHandler() {

            return {
                formData: {
                    photo: null,
                    firstname: '',
                    lastname: '',
                    middlename: '',
                    country: '',
                    region: '',
                    city: '',
                    education: '',
                    phone: '',
                    file: null,
                },
                errors: {},
                successMessage: '',
                isLoading: false,

                // Функция для отправки формы
                async submitForm() {
                    this.isLoading = true

                    // Сбор данных формы
                    const form = new FormData();
                    form.append('photo', this.$refs.photo.files[0]);
                    form.append('firstname', this.formData.firstname);
                    form.append('lastname', this.formData.lastname);
                    form.append('middlename', this.formData.middlename);
                    form.append('country', this.formData.country);
                    form.append('region', this.formData.region);
                    form.append('city', this.formData.city);
                    form.append('education', this.formData.education);
                    form.append('phone', this.formData.phone);
                    form.append('file', this.$refs.file.files[0]);

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
