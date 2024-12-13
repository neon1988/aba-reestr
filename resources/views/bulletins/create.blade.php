@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <form action="{{ route('bulletins.store') }}" method="POST"
              enctype="multipart/form-data" class="space-y-4">
            @csrf
            <!-- Дополнительная информация -->
            <div>
                <label for="text" class="block font-medium text-gray-700">Текст объявления</label>
                <textarea id="text" name="text" rows="8"
                          class="mt-1 block w-full lg:min-w-[40rem] border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500"></textarea>
            </div>

            <!-- Кнопка отправки -->
            <div class="text-left">
                <button type="submit"
                        class="px-6 py-2 bg-cyan-600 text-white rounded-md hover:bg-cyan-700 focus:ring-2 focus:ring-cyan-400">
                    Отправить
                </button>
            </div>
        </form>
    </div>
@endsection
