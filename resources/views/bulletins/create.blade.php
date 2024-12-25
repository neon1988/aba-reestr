@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <div class="max-w-3xl mx-auto px-4 py-4 text-gray-700">
            <p class="text-xl font-semibold mb-4">При составлении объявления, пожалуйста, учитывайте требования ниже:</p>
            <ul class="space-y-4 text-gray-600">
                <li>Не допускается указание своих социальных сетей или ссылок в мессенджеры в данном разделе, для контакта с вами укажите ваш номер телефона.</li>
                <li>В случае несоответствия объявления тематике или правилам, ваше объявление будет отправлено на доработку.</li>
            </ul>

            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Если вы ABA-специалист, укажите:</h2>
                <ul class="list-inside list-disc text-gray-600">
                    <li>Уровень вашей подготовки в ABA</li>
                    <li>Опыт работы в ABA</li>
                    <li>Город, район</li>
                    <li>Количество свободных часов в неделю</li>
                    <li>Контактную информацию (телефон)</li>
                    <li>Другую информацию, которая может помочь родителю при выборе специалиста</li>
                </ul>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Если вы родитель, укажите:</h2>
                <ul class="list-inside list-disc text-gray-600">
                    <li>Требования к специалисту (уровень подготовки: инструктор, куратор, супервизор)</li>
                    <li>Город, район</li>
                    <li>Занятость</li>
                    <li>Возраст ребенка</li>
                    <li>Область работы (занятия, написание программы, тренинг родителей и др.)</li>
                </ul>
            </div>

            <div class="mt-6 mb-8">
                <h2 class="text-lg font-semibold mb-2">Если вы ABA-центр, укажите:</h2>
                <ul class="list-inside list-disc text-gray-600">
                    <li>Кого вы ищите (клиентов, сотрудников)</li>
                    <li>Город, район</li>
                    <li>Количество свободных окон для клиентов, график и требования для сотрудников</li>
                    <li>Контактную информацию (телефон)</li>
                    <li>Другую информацию, которая может помочь родителю или соискателю</li>
                </ul>
            </div>

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
    </div>
@endsection
