@extends('layouts.app')

@section('content')

    <div class="mx-4">
        <div class="max-w-xl mx-auto p-4 sm:p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-8">Редактировать профиль центра</h3>

            <x-error-messages />

            <x-success-message />

            <form action="{{ route('centers.update', $center->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-3 my-3">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">Фото</h3>
                        <div class="mt-2">
                            @isset($center->photo)
                                <img src="{{ $center->photo->url }}" alt="Фото специалиста"
                                     class="w-32 h-32 rounded-full object-cover mb-2">
                            @endisset
                            <input type="file" name="photo" accept="image/*" class="mt-2 block w-full text-sm">
                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                        </div>
                    </div>

                    <div>
                        <x-input-label for="phone" value="Телефон"/>
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $center->phone)"
                                      required autocomplete="phone"/>
                        <x-input-error class="mt-2" :messages="$errors->get('phone')"/>
                    </div>

                </div>

                <x-primary-button>Сохранить изменения</x-primary-button>
            </form>
        </div>
    </div>
@endsection
