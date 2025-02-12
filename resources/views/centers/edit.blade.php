@extends('layouts.app')

@section('content')

    <div class="mx-4">
        <div class="max-w-xl mx-auto p-4 sm:p-6 bg-white rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-8">Редактировать профиль центра</h3>

            <x-error-messages/>

            <x-success-message/>

            <form action="{{ route('centers.update', $center->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-3 my-3">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">Фото</h3>
                        <div class="mt-2">
                            @isset($center->photo)
                                <x-image :url="$center->photo->url"
                                         :alt="$center->name"
                                         width="300" height="300" quality="90"
                                         class="w-32 h-32 rounded-full object-cover mb-2"/>
                            @endisset
                            <input type="file" name="photo" accept="image/*" class="mt-2 block w-full text-sm">
                            <span class="text-sm text-gray-700">
                            Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                                </span>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="profile_phone" value="Телефон для отображения в профиле"/>
                        <x-text-input id="profile_phone" name="profile_phone" type="text" class="mt-1 block w-full"
                                      :value="old('profile_phone', $center->profile_phone)"
                                      required autocomplete="profile_phone"/>
                        <x-input-error class="mt-2" :messages="$errors->get('profile_phone')"/>
                    </div>

                    <div>
                        <x-input-label for="profile_email" value="Электронная почта для профиля"/>
                        <x-text-input id="profile_email" name="profile_email" type="email" class="mt-1 block w-full"
                                      :value="old('profile_email', $center->profile_email)"
                                      required autocomplete="email"/>
                        <x-input-error class="mt-2" :messages="$errors->get('profile_email')"/>
                    </div>

                    <div>
                        <x-input-label for="actual_address_1" value="Фактический адрес 1"/>
                        <x-text-input id="actual_address_1" name="actual_address_1" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('actual_address_1', $center->actual_address_1)"
                                      required autocomplete="address-line1"/>
                        <x-input-error class="mt-2" :messages="$errors->get('actual_address_1')"/>
                    </div>

                    <div>
                        <x-input-label for="actual_address_2" value="Фактический адрес 2"/>
                        <x-text-input id="actual_address_2" name="actual_address_2" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('actual_address_2', $center->actual_address_2)"
                                      autocomplete="address-line2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('actual_address_2')"/>
                    </div>

                    <div>
                        <x-input-label for="actual_address_3" value="Фактический адрес 3"/>
                        <x-text-input id="actual_address_3" name="actual_address_3" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('actual_address_3', $center->actual_address_3)"
                                      autocomplete="address-line3"/>
                        <x-input-error class="mt-2" :messages="$errors->get('actual_address_3')"/>
                    </div>

                </div>

                <x-primary-button>Сохранить изменения</x-primary-button>
            </form>
        </div>
    </div>
@endsection
