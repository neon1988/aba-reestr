<h2 class="text-3xl font-semibold text-gray-900 mb-6">Результаты поиска</h2>
@if ($centers->hasPages())
    <div class="mb-5">
        {{ $centers->links() }}
    </div>
@endif
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    @if ($centers->count() > 0)
        @foreach($centers->items() as $center)
            @include('center.card')
        @endforeach
    @else
        Ни одного центра не найдено
    @endif
</div>
@if ($centers->hasPages())
    <div class="mt-5">
        {{ $centers->links() }}
    </div>
@endif
