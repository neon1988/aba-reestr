<h2 class="text-3xl font-semibold text-gray-900 mb-6">Список специалистов ABA</h2>

@if ($specialists->hasPages())
    <div class="mb-5">
        {{ $specialists->links() }}
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-8">
    @if ($specialists->count() > 0)
        @foreach($specialists->items() as $specialist)
            @include('specialists.card')
        @endforeach
    @else
        Ни одного специалиста не найдено
    @endif
</div>

@if ($specialists->hasPages())
    <div class="mt-5">
        {{ $specialists->links() }}
    </div>
@endif
