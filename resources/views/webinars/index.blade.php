@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-2">
        <!-- Описание вебинаров -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Добро пожаловать на наши вебинары!</h2>
            <p class="text-gray-600">
                Здесь вы найдете записи и расписание предстоящих вебинаров,
                посвященных ABA-терапии, новым техникам и подходам.
                Присоединяйтесь к нашим онлайн встречам, чтобы узнать больше и задать вопросы профессионалам.
                Если вы хотели бы поделиться записью своего вебинара, то
                <a href="{{ route('contacts') }}" class="text-cyan-600 hover:underline">свяжитесь с нами</a>
            </p>
        </div>

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
        </div>
    </div>
@endsection
