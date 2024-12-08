@extends('layouts.settings')

@section('settings-content')

    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 ">
                {{ __('Profile Information') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 ">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <x-error-messages />
        <x-success-message />

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
              enctype="multipart/form-data">
            @csrf
            @method('patch')

            <!-- Фото -->
            <div>
                <label class="block text-gray-700">Фото *</label>
                @isset($user->photo)
                    <img src="{{ $user->photo->url }}" alt="Фото пользователя"
                         class="w-32 h-32 rounded-full object-cover mb-2">
                @endisset
                <input type="file" name="photo" accept="image/*" class="mt-2 block w-full text-sm">
                Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}

                <x-input-error class="mt-2" :messages="$errors->get('photo')"/>
            </div>

            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                              required autofocus autocomplete="name"/>
                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
            </div>

            <div>
                <x-input-label for="lastname" :value="__('Lastname')"/>
                <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user->lastname)"
                              required autofocus autocomplete="lastname"/>
                <x-input-error class="mt-2" :messages="$errors->get('lastname')"/>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </section>



@endsection
