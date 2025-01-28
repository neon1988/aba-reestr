@extends('layouts.app')

@section('content')

    <div class="flex flex-col md:flex-row ">
        <!-- Левый блок с навигацией -->
        <aside class="w-full md:w-4/12 lg:w-3/12 bg-white sm:rounded-none sm:rounded-l-lg rounded-lg shadow-lg p-6 mb-3 md:mb-0">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 min-w-96">Меню</h2>
            <ul class="space-y-3">
                @if (Auth::user()->isSpecialist())
                    <li><a href="{{ route('specialists.edit', Auth::user()->getSpecialistId()) }}"
                           class="text-cyan-600 hover:text-cyan-800">Профиль</a></li>
                    <li><a href="{{ route('specialists.location-and-work', Auth::user()->getSpecialistId()) }}"
                           class="text-cyan-600 hover:text-cyan-800">Место проживания и работы</a></li>
                    <li><a href="{{ route('specialists.education-and-documents', Auth::user()->getSpecialistId()) }}"
                           class="text-cyan-600 hover:text-cyan-800">Образование и документы</a></li>
                    <li><a href="{{ route('specialists.billing-and-payment-documents', Auth::user()->getSpecialistId()) }}"
                           class="text-cyan-600 hover:text-cyan-800">Счета и документы оплаты</a></li>
                @elseif (\Illuminate\Support\Facades\Auth::user()->isCenter())

                @else
                    <li><a href="{{ route('profile.edit') }}"
                           class="text-cyan-600 hover:text-cyan-800">Профиль</a></li>
                @endif
                    <li><a href="{{ route('profile.password_change') }}"
                           class="text-cyan-600 hover:text-cyan-800">Пароли и безопасность</a></li>
                    <li><a href="{{ route('user.email.update') }}"
                           class="text-cyan-600 hover:text-cyan-800">Почтовый ящик</a></li>
            </ul>
        </aside>

        <!-- Правый блок с формой -->
        <main class="w-full md:w-8/12 lg:w-9/12 bg-white sm:rounded-none sm:rounded-r-lg rounded-lg shadow-lg p-6">
            @yield('settings-content')
        </main>
    </div>

@endsection
