@extends('layouts.app')

@section('content')

    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

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

                <form action="{{ route('center.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Название фактическое -->
                    <div>
                        <label class="block text-gray-700">Название фактическое *</label>
                        <input name="name" type="text"
                               class="w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Название юридическое -->
                    <div>
                        <label class="block text-gray-700">Название юридическое *</label>
                        <input name="legal_name" type="text"
                               class="w-full border @error('legal_name') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                               value="{{ old('legal_name') }}" required>
                        @error('legal_name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ИНН -->
                    <div>
                        <label class="block text-gray-700">ИНН *</label>
                        <input name="inn" type="text"
                               class="w-full border @error('inn') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                               value="{{ old('inn') }}" required>
                        @error('inn')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Страна -->
                    <div>
                        <label class="block text-gray-700">Страна *</label>
                        <select name="country"
                                class="w-full border @error('country') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                                required>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}" {{ old('country') == $country->name ? 'selected' : '' }}>
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
                               class="w-full border @error('region') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                               value="{{ old('region') }}">
                        @error('region')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Город -->
                    <div>
                        <label class="block text-gray-700">Город *</label>
                        <input name="city" type="text"
                               class="w-full border @error('city') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                               value="{{ old('city') }}" required>
                        @error('city')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Телефон -->
                    <div>
                        <label class="block text-gray-700">Телефон *</label>
                        <input name="phone" type="tel"
                               class="w-full border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                               value="{{ old('phone') }}" required>
                        @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Документы о регистрации юр. лица -->
                    <div>
                        <label class="block text-gray-700">Документы о регистрации юр. лица</label>
                        <input type="file" class="w-full border border-gray-300 rounded-md p-2">
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
