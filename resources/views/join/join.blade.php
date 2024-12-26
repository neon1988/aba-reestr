@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto p-3">
        <header class="text-center mb-4">
            <h1 class="text-4xl font-bold text-cyan-600">
                Регистрация и Преимущества
            </h1>
            <p class="mt-2 text-lg text-gray-600">
                Станьте частью сообщества специалистов в области анализа поведения.
            </p>
        </header>

        <section class="bg-white p-3 lg:p-8 rounded-lg shadow-md mb-4">
            <h4 class="text-xl font-semibold text-cyan-600 mb-4">
                Подписка подойдет вам, если вы являетесь:
            </h4>
            <ul class="list-disc pl-6 space-y-2">
                <li class="text-md">специалистом по прикладному анализу поведения</li>
                <li class="text-md">родителем, сиблингом или другим человеком, который вовлечен
                    в жизнь и помощь ребенка, подростка или молодого взрослого с аутизмом или другими
                    нарушениями развития
                </li>
                <li class="text-md">если вы являетесь специалистом в области специальной педагогики, психологии и всегда
                    ищете эффективные пути помощи вашим подопечным
                </li>
                <li class="text-md">а также, если вы являетесь руководителем центра, в котором реализуется ABA-терапия
                </li>
            </ul>

            <p class="mt-6 text-md">
                Наша подписка предполагает доступ к ресурсам в формате вебинаров, видео-лекций,
                статей, электронных пособий в электронном формате, а также возможность разместить информацию
                о себе, своих услугах, делиться информацией о своих мероприятиях и событиях.
            </p>
            <p class="mt-6 text-md font-semibold mb-6">Присоединиться к подписке можно по одному из трех тарифов
                ниже:</p>

            <div  class="grid grid-cols-1 lg:grid-cols-3 gap-3 cursor-pointer">
                <!-- Card 1: Родители или смежники -->
                <a href="#" class="bg-white p-6 border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <h3 class="text-xl font-semibold mb-4">Родители или смежники</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Доступ к видео лекциям
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Доступ к материалам (библиотека материалов)
                        </li>
                    </ul>
                    <p class="text-center mt-4 font-semibold">100 ₽/мес</p>
                    <div class="text-center mt-4">
                        <button class="px-4 py-2 text-white bg-cyan-500 rounded hover:bg-cyan-600">Выбрать</button>
                    </div>
                </a>

                <!-- Card 2: ABA специалисты -->
                <a href="{{ route('join.specialist') }}"
                   class="bg-white p-6 border border-gray-200 rounded-lg shadow-md  hover:shadow-xl transition duration-300 cursor-pointer">
                    <h3 class="text-xl font-semibold mb-4">ABA специалисты</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Своя карточка в реестре специалистов
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Доступ к видео лекциям
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Доступ к материалам (библиотека материалов)
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Возможность публиковать объявления о свободных часах на доске объявлений
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Возможность публиковать объявления о своих очных и онлайн мероприятиях
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            СЕУ?
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            1 групповая супервизия в месяц по определенной теме
                        </li>
                    </ul>
                    <p class="text-center mt-4 font-semibold">200 ₽/мес</p>
                    <div class="text-center mt-4">
                        <button class="px-4 py-2 text-white bg-cyan-500 rounded hover:bg-cyan-600">Выбрать</button>
                    </div>
                </a>

                <!-- Card 3: Aba центры и руководители центров -->
                <a href="#"
                    class="bg-white p-6 border border-gray-200 rounded-lg shadow-md  hover:shadow-xl transition duration-300 cursor-pointer">
                    <h3 class="text-xl font-semibold mb-4">Aba центры и руководители центров</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Своя карточка в реестре специалистов
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Доступ к видео лекциям
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Доступ к материалам (библиотека материалов)
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Возможность публиковать объявления о свободных часах на доске объявлений
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Возможность публиковать объявления о своих очных и онлайн мероприятиях
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Возможность добавить свой центр в список центров
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            СЕУ?
                        </li>
                    </ul>
                    <p class="text-center mt-4 font-semibold">300 ₽/мес</p>
                    <div class="text-center mt-4">
                        <button class="px-4 py-2 text-white bg-cyan-500 rounded hover:bg-cyan-600">Выбрать</button>
                    </div>
                </a>
            </div>
        </section>

        <div x-data="{ open: false }" class="bg-gray-100 py-12 rounded-lg shadow-md mb-4">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-semibold text-center text-gray-900 mb-8">Часто задаваемые вопросы по подписке
                    ABA Expert</h2>
                <p class="text-center text-lg text-gray-600 mb-12">Узнайте больше о нашей подписке ниже.</p>

                <div class="space-y-3 sm:space-y-6">
                    <!-- Question 1 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Для кого предназначена подписка?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">
                                Подписка ABA Expert предназначена для педагогов, родителей детей с особыми
                                потребностями, семей, которые занимаются домашним обучением, клиницистов, специалистов и
                                администраторов. Эта подписка предоставляет доступ к обучающим видео и ресурсам, а также
                                к эксклюзивному онлайн-сообществу.
                            </p>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Какие цели обучения и повестка дня
                                подписки?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p><a href="/aba-expert-subscription-year-1/" class="text-blue-500">Цели и повестка дня года
                                    1</a></p>
                            <p><a href="/aba-expert-subscription-year-2/" class="text-blue-500">Цели и повестка дня года
                                    2+</a></p>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Когда я получу доступ к ресурсам?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">
                                Вы получите приглашение присоединиться к сети ABA Expert в течение 15 минут после
                                регистрации. После настройки учетной записи вы получите доступ к материалам подписки.
                                Каждый месяц ресурсы будут обновляться, но вы сохраните доступ к предыдущим материалам.
                                Видео можно будет просматривать неограниченное количество раз.
                            </p>
                        </div>
                    </div>

                    <!-- Question 4 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Могу ли я получить кредиты для продолжения
                                образования, участвуя в подписке?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">
                                Участники первого года могут получить 9.5 кредитов для продолжения образования в
                                дополнение к кредитам за курсы. Участники второго года — 12.0 кредитов. Для участников,
                                которые являются подписчиками более 2 лет, кредиты можно получить за весь новый контент.
                                Пожалуйста, ознакомьтесь с подробностями на сайте.
                            </p>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Как получить помощь в случае технических
                                проблем?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">Если у вас возникли технические проблемы, пожалуйста, свяжитесь с
                                нами по электронной почте <a href="mailto:customerservice@abaexpert.com"
                                                             class="text-blue-500">customerservice@abaexpert.com</a>.
                            </p>
                        </div>
                    </div>

                    <!-- Question 6 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Как я могу запросить помощь для людей с
                                особыми потребностями?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">
                                ABA Expert, Inc. стремится обеспечить равные возможности для всех. Если вам нужна
                                помощь, связанная с инвалидностью, пожалуйста, свяжитесь с нами по адресу <a
                                    href="mailto:customerservice@abaexpert.com" class="text-blue-500">customerservice@abaexpert.com</a>.
                            </p>
                        </div>
                    </div>

                    <!-- Question 7 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Как я могу отменить свою подписку?
                                Предоставляете ли вы возврат средств?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">
                                В случае, если вы не удовлетворены подпиской, вы можете запросить полный возврат
                                средств, написав на <a href="mailto:customerservice@abaexpert.com"
                                                       class="text-blue-500">customerservice@abaexpert.com</a>.
                                Подписку можно отменить в любое время. Возврат средств будет произведен в зависимости от
                                вашего плана подписки.
                            </p>
                        </div>
                    </div>

                    <!-- Question 8 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Как оставить отзыв или задать вопросы?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">
                                Мы будем рады услышать ваши отзывы и ответить на ваши вопросы! Напишите нам на <a
                                    href="mailto:customerservice@abaexpert.com" class="text-blue-500">customerservice@abaexpert.com</a>.
                            </p>
                        </div>
                    </div>

                    <!-- Question 9 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Раскрытие информации</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-gray-700">Саша Лонг является основателем и владельцем ABA Expert, Inc. Она
                                получает оплату с продаж всех продуктов, подписок и курсов на этом сайте.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
