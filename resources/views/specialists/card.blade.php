<a
    href="{{ route('specialists.show', $specialist->id) }}"
   class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
    <!-- Фото специалиста -->
    <div class="flex justify-center mb-4">
        <x-image :url="optional($specialist->photo)->url"
                 :alt="$specialist->name"
                 width="100" height="100" quality="90"
                 class="w-24 h-24 rounded-full object-cover" />
    </div>

    <!-- Имя специалиста -->
    <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $specialist->name }} {{ $specialist->lastname }}</h3>

    <!-- Образование специалиста -->
    <p class="text-gray-600 mb-2">Образование: {{ App\Enums\EducationEnum::getDescription($specialist->education) }}</p>

    <!-- Адрес специалиста -->
    <p class="text-gray-600 mb-2">Адрес: г. {{ __($specialist->city) ?? 'Не указан' }},
        {{ $specialist->region ?? '' }}</p>

    @isset($specialist->center_name)
        <!-- Центр, в котором работает специалист -->
        <p class="text-gray-600 mb-2">Центр: {{ $specialist->center_name }}</p>
    @endif

    <!-- Наличие мест -->
    <p class="text-gray-600">Есть места: {{ $specialist->available_spots ? 'Да' : 'Нет' }}</p>

</a>
