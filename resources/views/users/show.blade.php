@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row">
            <div class="w-24 h-24 shrink-0 mb-6 md:mr-6">
                <x-image :url="optional($user->photo)->url"
                         :alt="$user->fullName"
                         width="100" height="100" quality="90"
                         class="w-full h-full object-cover rounded-full border border-gray-300" />
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }} {{ $user->lastname }}</h1>
                <p class="text-gray-600">{{ $user->middlename ?? '' }}</p>
                <p class="text-sm text-gray-500 text-ellipsis overflow-x-hidden">{{ $user->email }}</p>
                @isset($user->phone)
                    <p class="text-sm text-gray-500">{{ $user->phone }}</p>
                @endisset
            </div>
        </div>
    </div>
@endsection
