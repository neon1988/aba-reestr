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

            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Регистрация АВА-центра</h1>

            <x-error-messages bag="updatePassword" />

            <form @submit.prevent="submitForm" action="{{ route('centers.store') }}" method="POST"
                  class="space-y-4" enctype="multipart/form-data">
                @csrf

                <div>
                    <label class="block text-gray-700">Фото</label>

                    @if(isset($center->photo))
                        <img src="{{ $center->photo->url }}" alt="Фото пользователя"
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

                <!-- КПП -->
                <div>
                    <label class="block text-gray-700">КПП</label>
                    <input name="kpp" type="text" x-model="formData.kpp"
                           class="w-full border @error('kpp') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('kpp') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.kpp">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- ОГРН -->
                <div>
                    <label class="block text-gray-700">ОГРН *</label>
                    <input name="ogrn" type="text" x-model="formData.ogrn"
                           class="w-full border @error('ogrn') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('ogrn') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.ogrn">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Юридический адрес -->
                <div>
                    <label class="block text-gray-700">Юридический адрес *</label>
                    <input name="legal_address" type="text" x-model="formData.legal_address"
                           class="w-full border @error('legal_address') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('legal_address') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.legal_address">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Фактический адрес -->
                <div>
                    <label class="block text-gray-700">Фактический адрес 1 *</label>
                    <input name="actual_address" type="text" x-model="formData.actual_address"
                           class="w-full border @error('actual_address') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('actual_address') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.actual_address">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Расчетный счет -->
                <div>
                    <label class="block text-gray-700">Расчетный счет *</label>
                    <input name="account_number" type="text" x-model="formData.account_number"
                           class="w-full border @error('account_number') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('account_number') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.account_number">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- БИК -->
                <div>
                    <label class="block text-gray-700">БИК *</label>
                    <input name="bik" type="text" x-model="formData.bik"
                           class="w-full border @error('bik') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('bik') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.bik">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Должность руководителя -->
                <div>
                    <label class="block text-gray-700">Должность руководителя *</label>
                    <input name="director_position" type="text" x-model="formData.director_position"
                           class="w-full border @error('director_position') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('director_position') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.director_position">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- ФИО руководителя -->
                <div>
                    <label class="block text-gray-700">ФИО руководителя *</label>
                    <input name="director_name" type="text" x-model="formData.director_name"
                           class="w-full border @error('director_name') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('director_name') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.director_name">
                            <li x-text="error"></li>
                        </template>
                    </ul>
                </div>

                <!-- Действует на основании -->
                <div>
                    <label class="block text-gray-700">Действует на основании *</label>
                    <input name="acting_on_basis" type="text" x-model="formData.acting_on_basis"
                           class="w-full border @error('acting_on_basis') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                           value="{{ old('acting_on_basis') }}">
                    <ul class="text-sm text-red-500 mt-1">
                        <template x-for="error in errors.acting_on_basis">
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

                <!-- Документы  -->
                <div>
                    <label class="block text-gray-700">Документы *</label>
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
                    photos: [],
                    name: '',
                    legal_name: '',
                    inn: '',
                    country: '',
                    region: '',
                    city: '',
                    phone: '',
                    files: [],
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
