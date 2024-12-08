@extends('layouts.settings')

@section('settings-content')

    <h3 class="text-lg font-semibold text-gray-800 mb-8">Редактировать профиль специалиста</h3>

    <x-error-messages bag="updatePassword" />

    <x-success-message />

    <form action="{{ route('specialists.update', $specialist->id) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-3 my-3">

            <!-- Фото -->
            <div>
                <label class="block text-gray-700">Фото *</label>
                @isset($specialist->photo)
                    <img src="{{ $specialist->photo->url }}" alt="Фото специалиста"
                         class="w-32 h-32 rounded-full object-cover mb-2">
                @endisset
                <input type="file" name="photo" accept="image/*" class="mt-2 block w-full text-sm">
                Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}

                <p x-show="errors.name" x-text="errors.name" class="text-sm text-red-500 mt-1"></p>
            </div>

            <!-- Имя -->
            <div>
                <label class="block text-gray-700">Имя *</label>
                <input name="name" type="text"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('name') border-red-500 @enderror"
                       value="{{ old('name', $specialist->name ?? '') }}">

                @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Фамилия -->
            <div>
                <label class="block text-gray-700">Фамилия *</label>
                <input name="lastname" type="text"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('lastname') border-red-500 @enderror"
                       value="{{ old('lastname', $specialist->lastname ?? '') }}">

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
                       value="{{ old('middlename', $specialist->middlename ?? '') }}">

                @error('middlename')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Телефон -->
            <div>
                <label class="block text-gray-700">Телефон</label>
                <input name="phone" type="text"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('phone') border-red-500 @enderror"
                       value="{{ old('phone', $specialist->phone ?? '') }}">

                @error('phone')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Почта -->
            <div class="mb-4">
                <label class="block text-gray-700">Почта видна всем пользователям</label>
                <input name="show_email" type="hidden" value="0" />
                <input name="show_email" type="checkbox" id="showEmail"
                       class="mr-2 leading-tight" value="1"
                    {{ old('show_email', $specialist->show_email ?? false) ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Показать почту всем пользователям</span>
            </div>

            <!-- Телефон -->
            <div class="mb-4">
                <label class="block text-gray-700">Телефон виден всем пользователям</label>
                <input name="show_phone" type="hidden" value="0" />
                <input name="show_phone" type="checkbox" id="showPhone"
                       class="mr-2 leading-tight" value="1"
                    {{ old('show_phone', $specialist->show_phone ?? false) ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Показать телефон всем пользователям</span>
            </div>

            <!-- telegram profile -->
            <div>
                <label class="block text-gray-700">Профиль телеграмм</label>
                <input name="telegram_profile" type="text"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('telegram_profile') border-red-500 @enderror"
                       value="{{ old('telegram_profile', $specialist->telegram_profile ?? '') }}">

                @error('telegram_profile')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
        <x-primary-button>Сохранить изменения</x-primary-button>
    </form>

@endsection
