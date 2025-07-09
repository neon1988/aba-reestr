@php use App\Enums\SubscriptionLevelEnum; @endphp
<a href="{{ route('conferences.show', ['conference' => $item]) }}"
   class="bg-white shadow rounded-lg p-6 hover:shadow-xl transition duration-300">
    <x-image :url="optional($item->cover)->url"
             :alt="$item->title"
             width="600" height="600" quality="90"
             class="w-full h-40 object-cover rounded-lg"/>

    <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $item->title }}</h3>
    @if (!empty($item->available_for_subscriptions))
        <div class="mt-3">
            @foreach ($item->available_for_subscriptions as $subscription)
                <div class="inline-block bg-cyan-600 text-white text-xs font-medium mr-1 mb-1 px-2.5 py-0.5 rounded">
                    {{ SubscriptionLevelEnum::fromValue($subscription)->description }}
                </div>
            @endforeach
        </div>
    @endif
    <div class="mt-2 text-gray-600">
        @isset ($item->start_at)
            <span class="font-medium">Начало:</span>
            <x-time :time="$item->start_at"/><br>
        @endisset
        @isset ($item->end_at)
            <span class="font-medium">Конец:</span>
            <x-time :time="$item->end_at"/>
        @endisset
    </div>
    <p class="text-gray-600 mt-4">
        {{ mb_strimwidth($item->description, 0, 150, '...') }}
    </p>
</a>
