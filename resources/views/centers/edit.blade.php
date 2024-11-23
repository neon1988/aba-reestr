@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-8">Редактировать профиль центра</h3>

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

        <form action="{{ route('centers.update', $center->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-3 mt-3">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-700">Фото</h3>
                    <div class="mt-2">
                        @isset($center->photo)
                            <img src="{{ $center->photo->url }}" alt="Фото специалиста" class="w-32 h-32 rounded-full object-cover mb-2">
                        @endisset
                        <input type="file" name="photo" accept="image/*" class="mt-2 block w-full text-sm">
                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                    </div>
                </div>

                <!-- Имя -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-700">Имя центра</h3>
                    <input type="text" name="name" value="{{ old('name', $center->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <!-- Телефон -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-700">Телефон</h3>
                    <input type="text" name="phone" value="{{ old('phone', $center->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

            </div>

            <div class="mt-3 flex justify-end">
                <button type="submit" class="bg-cyan-600 text-white px-6 py-3 rounded-lg hover:bg-cyan-700">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>

@endsection
