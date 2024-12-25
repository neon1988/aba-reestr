@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto p-6">
        <header class="text-center mb-4">
            <h1 class="text-4xl font-bold text-cyan-600">Регистрация и Преимущества</h1>
            <p class="mt-2 text-lg text-gray-600">Станьте частью сети специалистов в области анализа поведения.</p>
        </header>

        <section class="bg-white p-8 rounded-lg shadow-md mb-4">
            <h4 class="text-xl font-semibold text-cyan-600 mb-4">
                Подписка подойдет вам, если вы являетесь:
            </h4>
            <ul class="list-disc pl-6 space-y-2">
                <li class="text-md">специалистом по прикладному анализу поведения</li>
                <li class="text-md">родителем, сиблингом или другим человеком, который вовлечен
                    в жизнь и помощь ребенка, подростка или молодого взрослого с аутизмом или другими
                    нарушениями развития</li>
                <li class="text-md">если вы являетесь специалистом в области специальной педагогики, психологии и всегда ищете эффективные пути помощи вашим подопечным</li>
                <li class="text-md">а также, если вы являетесь руководителем центра, в котором реализуется ABA-терапия</li>
            </ul>

            <p class="mt-6 text-md">
                Наша подписка предполагает доступ к ресурсам в формате вебинаров, видео-лекций,
                статей, электронных пособий в электронном формате, а также возможность разместить информацию
                о себе, своих услугах, делиться информацией о своих мероприятиях и событиях.
            </p>

            <p class="mt-6 text-md font-semibold mb-6">Присоединиться к подписке можно по одному из трех тарифов ниже:</p>

            <div class="overflow-x-auto shadow-md rounded-lg">
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-200 p-4 text-left  font-semibold">Что включено</th>
                        <th class="border border-gray-200 p-4 text-center  font-semibold">
                            Родители или смежники
                        </th>
                        <th class="border border-gray-200 p-4 text-center  font-semibold">ABA специалисты</th>
                        <th class="border border-gray-200 p-4 text-center  font-semibold">
                            Aba центры и руководители центров
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <!-- Row 1 -->
                    <tr>
                        <td class="border border-gray-200 p-4 ">Своя карточка в реестре специалистов</td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 ">Доступ к видео лекциям</td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr>
                        <td class="border border-gray-200 p-4 ">Доступ к материалам (библиотека материалов)</td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 ">Возможность публиковать объявления о свободных
                            часах на доске объявлений
                        </td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 5 -->
                    <tr>
                        <td class="border border-gray-200 p-4 ">Возможность публиковать объявления о своих очных
                            и онлайн мероприятиях
                        </td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 7 -->
                    <tr>
                        <td class="border border-gray-200 p-4 ">Возможность добавить свой центр в список
                            центров
                        </td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 8 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 ">Интервизии для специалистов</td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center ">

                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 9 -->
                    <tr>
                        <td class="border border-gray-200 p-4 ">СЕУ?</td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                    </tr>
                    <!-- Row 10 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 ">1 групповая супервизия в месяц по определенной
                            теме
                        </td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 inline-block"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </td>
                        <td class="border border-gray-200 p-4 text-center "></td>
                    </tr>
                    <!-- Row 10 -->
                    <tr class="bg-gray-50">
                        <td class="border border-gray-200 p-4 "></td>
                        <td class="border border-gray-200 p-4 text-center ">100 ₽/мес</td>
                        <td class="border border-gray-200 p-4 text-center ">200 ₽/мес</td>
                        <td class="border border-gray-200 p-4 text-center ">300 ₽/мес</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 p-4 "></td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <a href="#" class="px-4 py-2  text-white bg-cyan-500 rounded hover:bg-cyan-600">
                                Выбрать
                            </a>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <a href="{{ route('join.specialist') }}" class="px-4 py-2  text-white bg-cyan-500 rounded hover:bg-cyan-600">
                                Выбрать
                            </a>
                        </td>
                        <td class="border border-gray-200 p-4 text-center ">
                            <a href="#" class="px-4 py-2  text-white bg-cyan-500 rounded hover:bg-cyan-600">
                                Выбрать
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="mx-auto py-8 text-gray-700">
                <p class="text-2xl font-semibold mb-6">FAQ</p>

                <ul class="space-y-4">
                    <li class="text-lg">
                        <span class="font-semibold">Когда мне откроется доступ по подписке?</span>
                        <p class="mt-2 text-gray-600">Ответ на этот вопрос...</p>
                    </li>
                    <li class="text-lg">
                        <span class="font-semibold">Что делать, если возникла техническая ошибка?</span>
                        <p class="mt-2 text-gray-600">Ответ на этот вопрос...</p>
                    </li>
                    <li class="text-lg">
                        <span class="font-semibold">Как приостановить или отменить подписку?</span>
                        <p class="mt-2 text-gray-600">Ответ на этот вопрос...</p>
                    </li>
                    <li class="text-lg">
                        <span class="font-semibold">Как я получу квитанцию?</span>
                        <p class="mt-2 text-gray-600">Ответ на этот вопрос...</p>
                    </li>
                    <li class="text-lg">
                        <span class="font-semibold">Я хочу оплатить от юридического лица, что мне сделать?</span>
                        <p class="mt-2 text-gray-600">Ответ на этот вопрос...</p>
                    </li>
                </ul>
            </div>

        </section>

    </div>

@endsection
