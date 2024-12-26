@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <div class="flex items-center space-x-6 mb-6">
            <div class="w-24 h-24">
                <img class="w-full h-full object-cover rounded-full border border-gray-300"
                     src="{{ $user->photo->url }}"
                     alt="{{ $user->fullName }}">
            </div>
            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }} {{ $user->lastname }}</h1>
                <p class="text-gray-600">{{ $user->middlename ?? '' }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                @isset($user->phone)
                    <p class="text-sm text-gray-500">{{ $user->phone }}</p>
                @endisset
            </div>
        </div>
    </div>
@endsection
