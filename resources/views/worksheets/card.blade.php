<a href="{{ route('worksheets.show', ['worksheet' => $item]) }}"
   class="bg-white shadow rounded-lg p-6 hover:shadow-xl transition duration-300">
    <img src="{{ $item->cover->url }}" alt="{{ $item->title }}" class="w-full h-40 object-cover rounded-lg" />

        <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $item->title }} ({{ mb_strtoupper($item->file->extension) }})</h3>

    <p class="text-gray-600 mt-2">Автор: {{ $item->creator->full_name }}</p>
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
