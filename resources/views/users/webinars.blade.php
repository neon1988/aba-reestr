@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Мои вебинары</h1>

        @if ($upcomingWebinars->count() > 0)
        <!-- Список вебинаров -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Предстоящие вебинары</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($upcomingWebinars as $item)
                    @include('webinars.card', compact('item'))
                @endforeach
            </div>
        </div>
        @endif

        <!-- Список вебинаров -->
        <div class="mt-5">
            @if ($endedWebinars->count() > 0)
                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Вебинары в записи</h2>
                @if ($endedWebinars->hasPages())
                    <div class="mb-5">
                        {{ $endedWebinars->links() }}
                    </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($endedWebinars as $item)
                        @include('webinars.card', compact('item'))
                    @endforeach
                </div>
                @if ($endedWebinars->hasPages())
                    <div class="mb-5">
                        {{ $endedWebinars->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
