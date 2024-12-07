@extends('layouts.settings')

@section('settings-content')

    <h3 class="text-lg font-semibold text-gray-800 mb-8">Место проживания и работы</h3>

    <x-error-messages bag="updatePassword" />

    <x-success-message />

    <form action="{{ route('specialists.location_and_work.update', $specialist->id) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 gap-3 my-3">

            <!-- Страна -->
            <div>
                <label class="block text-gray-700">Страна *</label>
                <select name="country"
                        class="w-full border @error('country') border-red-500 @else border-gray-300 @enderror rounded-md p-2">
                    <option value=""
                            disabled {{ is_null(old('country', $specialist->country)) ? 'selected' : '' }}></option>
                    @foreach($countries as $country)
                        <option
                            value="{{ $country->name }}" {{ old('country', $specialist->country) == $country->name ? 'selected' : '' }}>
                            {{ __($country->name) }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Регион -->
            <div>
                <label class="block text-gray-700">Регион</label>
                <input name="region" type="text"
                       class="w-full border @error('region') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                       value="{{ old('region', $specialist->region) }}">
                @error('region')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Город -->
            <div>
                <label class="block text-gray-700">Город *</label>
                <input name="city" type="text"
                       class="w-full border @error('city') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                       value="{{ old('city', $specialist->city) }}">
                @error('city')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Центр работы -->
            <div>
                <label class="block text-gray-700">Центр работы</label>
                <input name="center_name" type="text"
                       class="w-full border @error('center_name') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                       value="{{ old('center_name', $specialist->center_name) }}">
                @error('center_name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Куратор -->
            <div>
                <label class="block text-gray-700">Куратор</label>
                <input name="curator" type="text"
                       class="w-full border @error('curator') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                       value="{{ old('curator', $specialist->curator) }}">
                @error('curator')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Супервизор -->
            <div>
                <label class="block text-gray-700">Супервизор</label>
                <input name="supervisor" type="text"
                       class="w-full border @error('supervisor') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                       value="{{ old('supervisor', $specialist->supervisor) }}">
                @error('supervisor')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Профессиональные интересы -->
            <div>
                <label class="block text-gray-700">Профессиональные интересы</label>
                <input name="professional_interests" type="text"
                       class="w-full border @error('professional_interests') border-red-500 @else border-gray-300 @enderror rounded-md p-2"
                       value="{{ old('professional_interests', $specialist->professional_interests) }}">
                @error('professional_interests')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <x-primary-button>Сохранить изменения</x-primary-button>
    </form>


@endsection
