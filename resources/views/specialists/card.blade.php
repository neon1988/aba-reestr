<div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
    <!-- Фото специалиста -->
    <div class="flex justify-center mb-4">
        <img src="{{ optional($specialist->photo)->url ?? 'https://via.placeholder.com/150' }}"
             alt="Фото специалиста" class="w-32 h-32 rounded-full object-cover">
    </div>

    <!-- Имя специалиста -->
    <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $specialist->firstname }} {{ $specialist->lastname }}</h3>

    <!-- Образование специалиста -->
    <p class="text-gray-600 mb-4">Образование: {{ $specialist->education ?? 'Не указано' }}</p>

    <!-- Адрес специалиста -->
    <p class="text-gray-600 mb-4">Адрес: г. {{ __($specialist->city) ?? 'Не указан' }},
        {{ $specialist->region ?? '' }}</p>

    @isset($specialist->center)
        <!-- Центр, в котором работает специалист -->
        <p class="text-gray-600 mb-4">Центр: {{ $specialist->center->name ?? 'Не указано' }}</p>
    @endif

    <!-- Наличие мест -->
    <p class="text-gray-600 mb-4">Есть места: {{ $specialist->available_spots ? 'Да' : 'Нет' }}</p>

    <!-- Ссылка на подробности -->
    <a href="{{ route('specialists.show', $specialist->id) }}"
       class="text-cyan-600 hover:underline">Подробнее</a>
</div>
