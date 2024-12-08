@extends('layouts.settings')

@section('settings-content')

    <h3 class="text-lg font-semibold text-gray-800 mb-8">Образование и документы</h3>

    <!-- Документы -->
    <div class="bg-white p-6">
        <div class="space-y-4">
            @foreach($documents as $document)
                <div class="flex items-center justify-between border-b pb-4">
                    <div class="flex items-center">
                        <i class="fas fa-file-alt text-cyan-500 mr-3"></i>
                        <span class="text-gray-800">{{ $document->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ $document->url }}" target="_blank"
                           class="text-cyan-600 hover:text-cyan-800">
                            Скачать
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
