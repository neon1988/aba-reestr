<div class="bg-white shadow rounded-lg p-6">
    <img src="{{ $item->cover->url }}" alt="{{ $item->title }}" class="w-full h-40 object-cover rounded-lg" />
    <a href="{{ route('worksheets.show', ['worksheet' => $item]) }}">
        <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $item->title }} ({{ mb_strtoupper($item->file->extension) }})</h3>
    </a>
    <p class="text-gray-600 mt-2">Автор: {{ $item->creator->full_name }}</p>
    <p class="text-gray-600 mt-2">Цена: {{ $item->price }} р.</p>
    <p class="text-gray-600 mt-4">
        {{ $item->description }}
    </p>
</div>
