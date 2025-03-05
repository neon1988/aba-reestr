<a href="{{ route('webinars.show', ['webinar' => $item]) }}"
   class="bg-white shadow rounded-lg p-6 hover:shadow-xl transition duration-300">
    @if ($item->cover)
        <x-image :url="optional($item->cover)->url"
                 :alt="$item->title"
                 width="600" height="600" quality="90"
                 class="w-full h-40 object-cover rounded-lg"/>
    @endif
    <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $item->title }}</h3>

    <div class="mt-2 text-gray-600">
        @isset ($item->start_at)
            <div>
                <span class="font-medium">Начало:</span>
                <x-time :time="$item->start_at"/>
            </div>
        @endisset
        @isset ($item->end_at)
            <div>
                <span class="font-medium">Конец:</span>
                <x-time :time="$item->end_at"/>
            </div>
        @endisset
        @if ($item->subscribers_count > 0)
            <div>
                <span class="font-medium">Подписчиков: {{ $item->subscribers_count }}</span>
            </div>
        @endif
    </div>
    <p class="text-gray-600 mt-4">
        {{ mb_strimwidth($item->description, 0, 150, '...') }}
    </p>
</a>
