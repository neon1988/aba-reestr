@extends('layouts.app')

@section('content')

    <div class="mx-4">
        <div class="max-w-xl mx-auto p-4 sm:p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-8">Редактировать профиль специалиста</h3>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-lg">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('specialists.update', $specialist->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Ошибки валидации -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Сообщения об успешном обновлении -->
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-lg">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-3 my-3">

                    <!-- Фото -->
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">Фото</h3>
                        <div class="mt-2">
                            @isset($specialist->photo)
                                <img src="{{ $specialist->photo->url }}" alt="Фото специалиста"
                                     class="w-32 h-32 rounded-full object-cover mb-2">
                            @endisset
                            <input type="file" name="photo" accept="image/*" class="mt-2 block w-full text-sm">
                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                        </div>
                    </div>

                    <!-- Телефон -->
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">Телефон</h3>
                        <input type="text" name="phone" value="{{ old('phone', $specialist->phone) }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                </div>
                <x-primary-button>Сохранить изменения</x-primary-button>
            </form>
        </div>
    </div>

@endsection
