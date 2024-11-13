@extends('layouts.app')

@section('content')

    <!-- Center Info Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/3 mb-8 md:mb-0">
                    <img src="https://via.placeholder.com/300" alt="Фото центра"
                         class="w-full h-80 object-cover rounded-lg shadow-lg">
                </div>
                <div class="md:w-2/3 md:pl-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Центр ABA "Дети будущего"</h1>
                    <p class="text-gray-700 mb-4">Мы предоставляем квалифицированную помощь детям с аутизмом, используя
                        передовые методики ABA-терапии. Наш центр оборудован современными методическими материалами и
                        работает с опытными специалистами.</p>
                    <p class="text-gray-600 mb-2">Адрес: г. Москва, ул. Пушкина, д. 10</p>
                    <p class="text-gray-600 mb-4">Юридический адрес: г. Москва, ул. Ленина, д. 5</p>
                    <p class="text-gray-600 mb-4">ИНН: 1234567890, КПП: 987654321</p>
                    <a href="tel:+78001234567" class="text-blue-600 hover:underline">Позвоните нам: +7 (800)
                        123-45-67</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-gray-900 text-center mb-6">Галерея</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/400x300" alt="Фото 1" class="w-full h-48 object-cover">
                </div>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/400x300" alt="Фото 2" class="w-full h-48 object-cover">
                </div>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="https://via.placeholder.com/400x300" alt="Фото 3" class="w-full h-48 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-gray-900 text-center mb-6">Услуги центра</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Индивидуальные занятия</h3>
                    <p class="text-gray-700 mb-4">Мы предлагаем индивидуальные занятия с использованием методик
                        ABA-терапии, направленных на развитие коммуникативных навыков и социального поведения.</p>
                </div>
                <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Групповые занятия</h3>
                    <p class="text-gray-700 mb-4">Групповые занятия для детей с аутизмом помогают развивать навыки
                        взаимодействия с другими детьми и усваивать основные жизненные навыки.</p>
                </div>
                <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Тренировка социальных навыков</h3>
                    <p class="text-gray-700 mb-4">Наши специалисты помогают детям с аутизмом развивать навыки общения,
                        взаимодействия с окружающими, решать конфликтные ситуации и многое другое.</p>
                </div>
                <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Консультации для родителей</h3>
                    <p class="text-gray-700 mb-4">Мы проводим консультации для родителей, обучая их методикам
                        ABA-терапии, которые они могут применять в повседневной жизни для помощи своим детям.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Intensives Section -->
    <section id="intensives" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-semibold text-gray-900 text-center mb-6">Интенсивы и курсы</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Интенсив по социальной адаптации</h3>
                    <p class="text-gray-700 mb-4">Курс, который поможет детям с аутизмом освоить базовые социальные
                        навыки, необходимые для успешной адаптации в обществе.</p>
                    <a href="#" class="text-blue-600 hover:underline">Подробнее</a>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Интенсив по развитию речи</h3>
                    <p class="text-gray-700 mb-4">Курс, направленный на развитие коммуникативных навыков у детей с
                        аутизмом, включая использование жестов и символов для улучшения речи.</p>
                    <a href="#" class="text-blue-600 hover:underline">Подробнее</a>
                </div>
            </div>
        </div>
    </section>

@endsection
