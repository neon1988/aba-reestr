<a href="{{ route('worksheets.show', ['worksheet' => $item]) }}"
   class="bg-white shadow rounded-lg p-6 hover:shadow-xl transition duration-300">
    <x-image :url="optional($item->cover)->url"
             :alt="$item->title"
             width="600" height="600" quality="90"
             class="w-full h-40 object-cover rounded-lg"/>

    <h3 class="text-xl font-semibold text-gray-800 mt-4">
        {{ $item->title }} @if ($item->isVideo())
            (Видео)
        @endif
    </h3>

    <p class="text-gray-600 mt-2">Автор: {{ $item->creator->full_name }}</p>
    @if ((auth()->guest() and $item->isPaid()) or (auth()->check() and auth()->user()->can('buy', $item)))
        <p class="text-gray-600 mt-2">
            Цена: {{ $item->price }} р.
        </p>
    @endif
    <p class="text-gray-600 mt-4">
        {{ mb_strimwidth($item->description, 0, 150, '...') }}
    </p>
</a>
