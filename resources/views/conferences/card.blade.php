<a href="{{ route('conferences.show', ['conference' => $item]) }}"
   class="bg-white shadow rounded-lg p-6 hover:shadow-xl transition duration-300">
    <x-image :url="optional($item->cover)->url"
             :alt="$item->title"
             width="600" height="600" quality="90"
             class="w-full h-40 object-cover rounded-lg" />

        <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $item->title }}</h3>

    <div class="mt-2 text-gray-600">
        @isset ($item->start_at)
            <span class="font-medium">Начало:</span> <x-time :time="$item->start_at" /><br>
        @endisset
        @isset ($item->end_at)
            <span class="font-medium">Конец:</span> <x-time :time="$item->end_at" />
        @endisset
    </div>
    <p class="text-gray-600 mt-2">
        @empty($item->price)
            Бесплатно
        @else
            Цена: {{ $item->price }} р.
        @endif
    </p>
    <p class="text-gray-600 mt-4">
        {{ $item->description }}
    </p>
</a>
