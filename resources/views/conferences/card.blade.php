<div class="bg-white shadow rounded-lg p-6">
    <img src="{{ $item->cover->url }}" alt="Основы ABA-терапии" class="w-full h-40 object-cover rounded-lg">
    <a href="{{ route('conferences.show', ['conference' => $item]) }}">
        <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $item->title }}</h3>
    </a>
    <div class="mt-2 text-gray-600">
        @isset ($item->start_at)
            <span class="font-medium">Начало:</span> <x-time :time="$item->start_at" /><br>
        @endisset
        @isset ($item->end_at)
            <span class="font-medium">Конец:</span> <x-time :time="$item->end_at" />
        @endisset
    </div>
    <p class="text-gray-600 mt-2">Цена: {{ $item->price }} р.</p>
    <p class="text-gray-600 mt-4">
        {{ $item->description }}
    </p>
</div>
