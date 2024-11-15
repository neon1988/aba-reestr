@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
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

                <form action="{{ route('specialists.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700">Фото</label>
                        <input name="photo" type="file" class="w-full border border-gray-300 rounded-md p-2">
                        Максимальный размер {{ formatFileSize(config('uploads.image_max_size') * 1000) }}
                    </div>

                    <!-- Имя -->
                    <div>
                        <label class="block text-gray-700">Имя *</label>
                        <input name="firstname" type="text"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('firstname') border-red-500 @enderror"
                               value="{{ old('firstname') }}" required>
                        @error('firstname')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Фамилия -->
                    <div>
                        <label class="block text-gray-700">Фамилия *</label>
                        <input name="lastname" type="text"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('lastname') border-red-500 @enderror"
                               value="{{ old('lastname') }}" required>
                        @error('lastname')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Отчество -->
                    <div>
                        <label class="block text-gray-700">Отчество</label>
                        <input name="middlename" type="text"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('middlename') border-red-500 @enderror"
                               value="{{ old('middlename') }}">
                        @error('middlename')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Страна -->
                    <div>
                        <label class="block text-gray-700">Страна *</label>
                        <select name="country"
                                class="w-full border @error('country') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                                required>
                            @foreach($countries as $country)
                                <option
                                    value="{{ $country->name }}" {{ old('country') == $country->name ? 'selected' : '' }}>
                                    {{ __($country->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('country')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Регион -->
                    <div>
                        <label class="block text-gray-700">Регион</label>
                        <input name="region" type="text"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('region') border-red-500 @enderror"
                               value="{{ old('region') }}">
                        @error('region')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Город -->
                    <div>
                        <label class="block text-gray-700">Город *</label>
                        <input name="city" type="text"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('city') border-red-500 @enderror"
                               value="{{ old('city') }}" required>
                        @error('city')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Образование -->
                    <div>
                        <label class="block text-gray-700">Образование *</label>
                        <input name="education" type="text"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('education') border-red-500 @enderror"
                               value="{{ old('education') }}" required>
                        @error('education')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Телефон -->
                    <div>
                        <label class="block text-gray-700">Телефон *</label>
                        <input name="phone" type="tel"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('phone') border-red-500 @enderror"
                               value="{{ old('phone') }}" required>
                        @error('phone')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Документы об АВА образовании -->
                    <div>
                        <label class="block text-gray-700">Документы об АВА образовании</label>
                        <input name="file" type="file"
                               class="w-full border border-gray-300 rounded-md p-2
                                      @error('education_document') border-red-500 @enderror">
                        @error('education_document')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror

                        Максимальный размер {{ formatFileSize(config('uploads.document_max_size') * 1000) }}
                    </div>

                    <!-- Кнопка отправки -->
                    <div class="text-center">
                        <button type="submit"
                                class="bg-cyan-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-cyan-700 transition">
                            Подать заявку
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
