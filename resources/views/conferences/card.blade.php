<div class="bg-white shadow rounded-lg p-6">
    <img src="{{ $item->cover->url }}" alt="Основы ABA-терапии" class="w-full h-40 object-cover rounded-lg">
    <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $item->title }}</h3>
    <div class="mt-2 text-gray-600">
        @isset ($item->start_at)
        <span class="font-medium">Начало:</span> <span>{{ \Carbon\Carbon::parse($item->start_at)->format('d.m.Y H:i') }}</span><br>
        @endisset
        @isset ($item->end_at)
            <span class="font-medium">Конец:</span> <span>{{ \Carbon\Carbon::parse($item->end_at)->format('d.m.Y H:i') }}</span>
        @endisset
    </div>
    <p class="text-gray-600 mt-4">
        {{ $item->description }}
    </p>
    <a href="{{ route('join') }}" class="inline-block mt-4 bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700">
        Оформить подписку
    </a>
</div>
