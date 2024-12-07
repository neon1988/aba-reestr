@extends('layouts.settings')

@section('settings-content')

    <h3 class="text-lg font-semibold text-gray-800 mb-8">Образование и документы</h3>

    <!-- Документы -->
    <div class="bg-white p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Документы</h2>

        <div class="space-y-4">
            <!-- Пример документа 1 -->
            <div class="flex items-center justify-between border-b pb-4">
                <div class="flex items-center">
                    <i class="fas fa-file-alt text-blue-500 mr-3"></i>
                    <span class="text-gray-800">Свидетельство об образовании</span>
                </div>
                <div class="flex items-center">
                    <a href="{{ asset('storage/' . $specialist->education_certificate) }}" target="_blank"
                       class="text-blue-600 hover:text-blue-800">
                        Скачать
                    </a>
                </div>
            </div>

            <!-- Пример документа 2 -->
            <div class="flex items-center justify-between border-b pb-4">
                <div class="flex items-center">
                    <i class="fas fa-file-alt text-blue-500 mr-3"></i>
                    <span class="text-gray-800">Документ удостоверяющий личность</span>
                </div>
                <div class="flex items-center">
                    <a href="{{ asset('storage/' . $specialist->identity_document) }}" target="_blank"
                       class="text-blue-600 hover:text-blue-800">
                        Скачать
                    </a>
                </div>
            </div>


        </div>

    </div>

@endsection
