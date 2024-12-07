@extends('layouts.app')

@section('content')

    <div class="min-h-screen flex flex-col md:flex-row ">
        <!-- Левый блок с навигацией -->
        <aside class="w-full md:w-5/12 bg-white rounded-l-lg shadow-lg p-6 mb-6 md:mb-0">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Меню</h2>
            <ul class="space-y-3">
                @if (Auth::user()->isSpecialist())
                    <li><a href="{{ route('specialists.edit', Auth::user()->getSpecialistId()) }}"
                           class="text-blue-600 hover:text-blue-800">Профиль</a></li>
                    <li><a href="{{ route('specialists.location_and_work', Auth::user()->getSpecialistId()) }}"
                           class="text-blue-600 hover:text-blue-800">Место проживания и работы</a></li>
                    <li><a href="{{ route('specialists.education_and_documents', Auth::user()->getSpecialistId()) }}"
                           class="text-blue-600 hover:text-blue-800">Образование и документы</a></li>
                    <li><a href="{{ route('specialists.billing_and_payment_documents', Auth::user()->getSpecialistId()) }}"
                           class="text-blue-600 hover:text-blue-800">Счета и документы оплаты</a></li>
                @elseif (\Illuminate\Support\Facades\Auth::user()->isCenter())

                @else
                    <li><a href="{{ route('profile.edit') }}"
                           class="text-blue-600 hover:text-blue-800">Профиль</a></li>
                @endif
                    <li><a href="{{ route('profile.password_change') }}"
                           class="text-blue-600 hover:text-blue-800">Пароли и безопасность</a></li>
            </ul>
        </aside>

        <!-- Правый блок с формой -->
        <main class="w-full md:w-7/12 bg-white rounded-r-lg shadow-lg p-6">
            @yield('settings-content')
        </main>
    </div>

@endsection
