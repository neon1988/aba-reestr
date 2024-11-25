@extends('layouts.app')

@section('content')

    <div class="relative max-w-2xl" x-data="formHandler()">
        <!-- Заглушка -->
        <div x-show="isLoading" x-transition
             class="absolute inset-0 bg-gray-200 bg-opacity-75 flex justify-center items-center z-10">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-cyan-500"></div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Регистрация АВА-центра</h1>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-4">
                    <ul class="list-inside space-y-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form @submit.prevent="submitForm" action="{{ route('centers.store') }}" method="POST"
                  class="space-y-4" enctype="multipart/form-data">
                @csrf

                <div>
                    <label class="block text-gray-700">Фото</label>
                    <input name="photo" type="file" x-ref="photo" class="w-full border border-gray-300 rounded-md p-2">
                    Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.photo">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Название фактическое -->
                <div>
                    <label class="block text-gray-700">Название фактическое *</label>
                    <input name="name" type="text" x-model="formData.name"
                           class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('name') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.name">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Название юридическое -->
                <div>
                    <label class="block text-gray-700">Название юридическое *</label>
                    <input name="legal_name" type="text" x-model="formData.legal_name"
                           class="w-full border @error('legal_name') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('legal_name') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.legal_name">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- ИНН -->
                <div>
                    <label class="block text-gray-700">ИНН *</label>
                    <input name="inn" type="text" x-model="formData.inn"
                           class="w-full border @error('inn') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('inn') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.inn">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Страна -->
                <div>
                    <label class="block text-gray-700">Страна *</label>
                    <select name="country" x-model="formData.country"
                            class="w-full border @error('country') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                    >
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
                           class="w-full border @error('region') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
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
                           class="w-full border @error('city') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('city') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.city">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Телефон -->
                <div>
                    <label class="block text-gray-700">Телефон *</label>
                    <input name="phone" type="tel" x-model="formData.phone"
                           class="w-full border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('phone') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.phone">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Документы о регистрации юр. лица -->
                <div>
                    <label class="block text-gray-700">Документы о регистрации юр. лица</label>
                    <input name="file" type="file" x-ref="file" class="w-full border border-gray-300 rounded-md p-2">
                    Максимальный размер  {{ formatFileSize(convertToBytes(config('upload.document_max_size'))) }}
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.file">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <x-primary-button>Отправить заявку</x-primary-button>

            </form>

        </div>
    </div>

    <script>
        function formHandler() {

            return {
                formData: {
                    photo: null,
                    name: '',
                    legal_name: '',
                    inn: '',
                    country: '',
                    region: '',
                    city: '',
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
                    form.append('name', this.formData.name);
                    form.append('legal_name', this.formData.legal_name);
                    form.append('inn', this.formData.inn);
                    form.append('country', this.formData.country);
                    form.append('region', this.formData.region);
                    form.append('city', this.formData.city);
                    form.append('phone', this.formData.phone);
                    form.append('file', this.$refs.file.files[0]);

                    const response = await fetch('{{ route('centers.store') }}', {
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
                        console.log(this.errors);
                    }
                }
            };
        }
    </script>

@endsection
