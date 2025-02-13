@php use App\Http\Resources\FileResource; @endphp
@extends('layouts.settings')

@section('settings-content')

    <h3 class="text-lg font-semibold text-gray-800 mb-8">Редактировать профиль специалиста</h3>

    <x-error-messages/>

    <x-success-message/>

    <form x-data="formHandler()"
          @submit.prevent="submit"
          action="{{ route('specialists.profile.update', $specialist->id) }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <template x-if="response && response.data.status == 'success'">
            <div class="p-4 mb-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded">
                <div class="flex items-center">
                    <span x-text="response.data.message"></span>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 gap-3 my-3">

            <!-- Фото -->
            <div>
                <label class="block text-gray-700">Фото</label>

                <div>
                    <x-upload-file
                        parent_value_name="form.photo"
                        max_files="1"
                        url="{{ route('files.store') }}"
                        accept="image/*"
                    />
                </div>
                <template x-if="form.invalid('photo')">
                    <div x-text="form.errors.photo" class="text-sm text-red-600 space-y-1"></div>
                </template>
                <span class="text-sm text-gray-700">
                    Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                </span>
            </div>

            <!-- Имя -->
            <div>
                <label class="block text-gray-700">Имя *</label>
                <input name="name" type="text" x-model="form.name"
                       @change="form.validate('name')"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('name') border-red-500 @enderror"
                       value="{{ old('name', $specialist->name ?? '') }}">

                <template x-if="form.invalid('name')">
                    <div x-text="form.errors.name" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Фамилия -->
            <div>
                <label class="block text-gray-700">Фамилия *</label>
                <input name="lastname" type="text" x-model="form.lastname"
                       @change="form.validate('lastname')"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('lastname') border-red-500 @enderror"
                       value="{{ old('lastname', $specialist->lastname ?? '') }}">

                <template x-if="form.invalid('lastname')">
                    <div x-text="form.errors.lastname" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Отчество -->
            <div>
                <label class="block text-gray-700">Отчество</label>
                <input name="middlename" type="text" x-model="form.middlename"
                       @change="form.validate('middlename')"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('middlename') border-red-500 @enderror"
                       value="{{ old('middlename', $specialist->middlename ?? '') }}">

                <template x-if="form.invalid('middlename')">
                    <div x-text="form.errors.middlename" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Есть свободные часы -->
            <div>
                <input name="has_available_hours" type="checkbox" x-model="form.has_available_hours"
                       class="mr-2 leading-tight" value="1"
                    {{ old('has_available_hours', $specialist->has_available_hours ?? false) ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Есть свободные часы</span>
            </div>

            <!-- Почта видна всем -->
            <div>
                <input name="show_email" type="checkbox" x-model="form.show_email"
                       class="mr-2 leading-tight" value="1"
                    {{ old('show_email', $specialist->show_email ?? false) ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Показать электронную почту всем пользователям</span>
            </div>

            <!-- Телефон -->
            <div>
                <label class="block text-gray-700">Телефон</label>
                <input name="phone" type="text" x-model="form.phone"
                       @change="form.validate('phone')"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('phone') border-red-500 @enderror"
                       value="{{ old('phone', $specialist->phone ?? '') }}">

                <template x-if="form.invalid('phone')">
                    <div x-text="form.errors.phone" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Телефон виден всем -->
            <div>
                <input name="show_phone" type="checkbox" x-model="form.show_phone"
                       class="mr-2 leading-tight" value="1"
                    {{ old('show_phone', $specialist->show_phone ?? false) ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Показать телефон всем пользователям</span>
            </div>

            <!-- Профиль телеграмм -->
            <div>
                <label class="block text-gray-700">Профиль телеграмм</label>
                <input name="telegram_profile" type="text" x-model="form.telegram_profile"
                       @change="form.validate('telegram_profile')"
                       x-on:paste.prevent="handleTelegramPaste"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('telegram_profile') border-red-500 @enderror"
                       value="{{ old('telegram_profile', $specialist->telegram_profile ?? '') }}">

                <template x-if="form.invalid('telegram_profile')">
                    <div x-text="form.errors.telegram_profile" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Профиль VK -->
            <div>
                <label class="block text-gray-700">Профиль VK</label>
                <input name="vk_profile" type="text" x-model="form.vk_profile"
                       @change="form.validate('vk_profile')"
                       x-on:paste.prevent="handleVKProfilePaste"
                       class="w-full border border-gray-300 rounded-md p-2
                  @error('vk_profile') border-red-500 @enderror"
                       value="{{ old('vk_profile', $specialist->vk_profile ?? '') }}">

                <template x-if="form.invalid('vk_profile')">
                    <div x-text="form.errors.vk_profile" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Образование в области ABA -->
            <div>
                <label class="block text-gray-700">Образование в области ABA</label>
                <textarea name="aba_education" type="text" x-model="form.aba_education"
                          @change="form.validate('aba_education')"
                          class="w-full field-sizing-content border border-gray-300 rounded-md p-2
                  @error('aba_education') border-red-500 @enderror">
                    {{ old('aba_education', $specialist->aba_education ?? '') }}
                </textarea>

                <template x-if="form.invalid('aba_education')">
                    <div x-text="form.errors.aba_education" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Тренинги в области ABA -->
            <div>
                <label class="block text-gray-700">Тренинги в области ABA</label>
                <textarea name="aba_trainings" type="text" x-model="form.aba_trainings"
                          @change="form.validate('aba_trainings')"
                          class="w-full field-sizing-content border border-gray-300 rounded-md p-2
                  @error('aba_trainings') border-red-500 @enderror">
                    {{ old('aba_trainings', $specialist->aba_trainings ?? '') }}
                </textarea>

                <template x-if="form.invalid('aba_trainings')">
                    <div x-text="form.errors.aba_trainings" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Специализация в сфере профессиональных интересов -->
            <div>
                <label class="block text-gray-700">Специализация в сфере профессиональных интересов</label>
                <textarea name="professional_specialization" type="text" x-model="form.professional_specialization"
                          @change="form.validate('professional_specialization')"
                          class="w-full field-sizing-content border border-gray-300 rounded-md p-2
                  @error('professional_specialization') border-red-500 @enderror">
                    {{ old('professional_specialization', $specialist->professional_specialization ?? '') }}
                </textarea>

                <template x-if="form.invalid('professional_specialization')">
                    <div x-text="form.errors.professional_specialization" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Дополнительная информация -->
            <div>
                <label class="block text-gray-700">Дополнительная информация</label>
                <textarea name="additional_info" type="text" x-model="form.additional_info"
                          @change="form.validate('additional_info')"
                          class="w-full field-sizing-content border border-gray-300 rounded-md p-2
                  @error('additional_info') border-red-500 @enderror">
                    {{ old('additional_info', $specialist->additional_info ?? '') }}
                </textarea>

                <template x-if="form.invalid('additional_info')">
                    <div x-text="form.errors.additional_info" class="text-sm text-red-600 space-y-1"></div>
                </template>
            </div>

            <!-- Сертификаты -->
            <div>
                <label class="block text-gray-700">Сертификаты</label>

                <div>
                    <x-upload-file
                        parent_value_name="form.certificates"
                        max_files="9"
                        url="{{ route('files.store') }}"
                        accept="image/*"
                    />
                </div>
                <template x-if="form.invalid('certificates')">
                    <div x-text="form.errors.certificates" class="text-sm text-red-600 space-y-1"></div>
                </template>
                <span class="text-sm text-gray-700">
                Максимальный размер {{ formatFileSize(convertToBytes(config('upload.image_max_size'))) }}
                </span>
            </div>
        </div>
        <div>
            <x-primary-button ::disabled="form.processing">
                Сохранить
            </x-primary-button>

            <template x-if="response && response.data.status == 'success'">

                <span class="text-sm text-green-600 ml-3">
                    <span class="text-green-600" x-text="response.data.message"></span>
                    <a href="{{ route('specialists.show', compact('specialist')) }}"
                        class="text-cyan-600 hover:underline">Просмотреть профиль</a>
                </span>

            </template>
        </div>
    </form>

    <script>
        function formHandler() {
            return {
                form: null,
                errors: [],
                response: null,
                init: function () {
                    const photo = {{ Js::from((new FileResource($specialist->photo))->toArray(request())) }};
                    const certificates = {{ Js::from(FileResource::collection($specialist->certificates)->toArray(request())) }};
                    this.form = this.$form('patch', this.$el.action, {
                        photo: photo,
                        name: '{{ old('name', $specialist->name) }}',
                        lastname: '{{ old('lastname', $specialist->lastname) }}',
                        middlename: '{{ old('middlename', $specialist->middlename) }}',
                        has_available_hours: '{{ old('has_available_hours', $specialist->has_available_hours ? 1 : 0) }}',
                        phone: '{{ old('phone', $specialist->phone) }}',
                        show_email: '{{ old('show_email', $specialist->show_email ? 1 : 0) }}',
                        show_phone: '{{ old('show_phone', $specialist->show_phone ? 1 : 0) }}',
                        telegram_profile: '{{ old('telegram_profile', $specialist->telegram_profile) }}',
                        vk_profile: '{{ old('vk_profile', $specialist->vk_profile) }}',
                        aba_education: `{{ old('aba_education', $specialist->aba_education) }}`,
                        aba_trainings: `{{ old('aba_trainings', $specialist->aba_trainings) }}`,
                        professional_specialization: `{{ old('professional_specialization', $specialist->professional_specialization) }}`,
                        additional_info: `{{ old('additional_info', $specialist->additional_info) }}`,
                        certificates: certificates,
                    }).setErrors({{ Js::from($errors->messages()) }})
                },
                submit() {
                    this.response = null;
                    this.form.submit()
                        .then(async response => {
                            this.response = response;
                        })
                        .catch(error => {
                            this.errors = error.response.data.errors
                        });
                },
                handleVKProfilePaste() {
                    const clipboardData = event.clipboardData || window.clipboardData;
                    const pastedText = clipboardData.getData('text').trim();
                    const regex = /^(?:https?:\/\/)?(?:www\.)?vk\.com\/([^\/?#]+)/i;
                    const match = pastedText.match(regex);
                    const username = match ? match[1] : pastedText;
                    this.form.vk_profile = username;
                },
                handleTelegramPaste() {
                    const clipboardData = event.clipboardData || window.clipboardData;
                    const pastedText = clipboardData.getData('text').trim();
                    const regex = /^(?:https?:\/\/)?(?:t\.me\/|www\.telegram\.me\/)([^\/?#]+)/i;
                    const match = pastedText.match(regex);
                    const username = match ? match[1] : pastedText;
                    this.form.telegram_profile = username;
                }
            }
        }
    </script>

@endsection
