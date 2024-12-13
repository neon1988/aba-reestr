<h2 class="text-3xl font-semibold text-gray-900 mb-6">Результаты поиска</h2>
@if ($items->hasPages())
    <div class="mb-5">
        {{ $items->links() }}
    </div>
@endif
<div class="grid grid-cols-1">
    @if ($items->count() > 0)
        @foreach($items->items() as $item)
            @include('bulletins.item')
        @endforeach
    @else
        Ни одного объявления не найдено
    @endif
</div>
@if ($items->hasPages())
    <div class="mt-5">
        {{ $items->links() }}
    </div>
@endif