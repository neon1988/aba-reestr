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
            <p class="text-md">
                Наша подписка предполагает доступ к ресурсам в формате вебинаров, видео-лекций,
                статей, электронных пособий в электронном формате, а также возможность разместить
                информацию о себе, своих услугах, делиться информацией о своих мероприятиях и событиях.
            </p>
            <p class="mt-6 text-md font-semibold mb-6">Присоединиться к подписке можно по одному из трех тарифов
                ниже:</p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 cursor-pointer">
                <!-- Card 1: Родители или смежники -->
                <a href="#"
                   class="bg-white p-6 border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition duration-300 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Подписка A</h3>
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
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Возможность публиковать объявление
                            </li>
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6 text-green-500 inline-block mr-2 flex-shrink-0" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Участие в онлайн мероприятиях
                            </li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-center mt-4 font-semibold">1900 ₽/год</p>
                        <div class="text-center mt-4">
                            <button class="px-4 py-2 text-white bg-cyan-500 rounded hover:bg-cyan-600">Выбрать</button>
                        </div>
                    </div>
                </a>

                <!-- Card 2: ABA специалисты -->
                <a href="{{ route('join.specialist') }}"
                   class="bg-white p-6 border border-gray-200 rounded-lg shadow-md hover:shadow-xl transition duration-300 cursor-pointer  flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-semibold mb-4">Подписка B</h3>
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
                                Участие в онлайн мероприятиях
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
                    </div>
                    <div>
                        <p class="text-center mt-4 font-semibold">3500 ₽/год</p>
                        <div class="text-center mt-4">
                            <button class="px-4 py-2 text-white bg-cyan-500 rounded hover:bg-cyan-600">Выбрать</button>
                        </div>
                    </div>
                </a>

                <!-- Card 3: ABA центры и руководители центров -->
                <a href="{{ route('centers.index') }}"
                   class="opacity-60 bg-white p-6 border border-gray-200 rounded-lg shadow-md  hover:shadow-xl transition duration-300 cursor-pointer  flex flex-col justify-between">
                    <div>
                    <h3 class="text-xl font-semibold mb-4">Подписка C (скоро появится)</h3>
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
                            Участие в онлайн мероприятиях
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
                            1 групповая супервизия в месяц по определенной теме
                        </li>
                    </ul>
                    </div>
                    <div>
                        <p class="text-center mt-4 font-semibold">4800 ₽/год</p>
                        <div class="text-center mt-4">
                            <button class="px-4 py-2 text-white bg-cyan-500 rounded hover:bg-cyan-600">Выбрать</button>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <div x-data="{ open: false }" class="bg-gray-100 py-12 rounded-lg shadow-md mb-4">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-semibold text-center text-gray-900 mb-8">
                    Часто задаваемые вопросы по подписке ABA Expert</h2>
                <div class="space-y-3 sm:space-y-6">
                    <!-- Question 1 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Для кого предназначена подписка?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="font-semibold mb-4">
                                Подписка подойдет вам, если вы являетесь:
                            </p>
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
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">
                                Как оформить подписку?
                            </h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-md">
                            Чтобы оформить подписку, выберете подходящий тариф.
                            При оплате тарифа А вам сразу откроется доступ к контенту сайта.
                            При оплате тарифа В и С, после завершения оплаты вам понадобится отправить
                            ваши документы об образовании администрации сайта.
                            После проверки документов у вас откроется доступ к контенту
                            сайта и личному кабинету специалиста/центра.
                            </p>
                        </div>
                    </div>


                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">Как получить помощь в случае технических
                                проблем?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-md">
                            В случае возникновения любых вопросов и технических неполадок
                            <a class="text-cyan-600 hover:underline" href="{{ route('contacts') }}">сообщите нам</a>
                            </p>
                        </div>
                    </div>

                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">
                                Как я могу получить возврат средств?</h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-md">
                                В случае, если вы не удовлетворены подпиской, вы можете запросить возврат средств,
                                <a class="text-cyan-600 hover:underline" href="{{ route('contacts') }}">написав нам</a>.
                            </p>
                            <p class="text-md">
                                Подписку можно отменить в любое время.
                                Возврат средств будет произведен за неиспользованные дни подписки.
                                Обратите внимание, что при приобретении годового плана вы оплачиваете
                                1 календарный месяц подписки и получаете 11 месяцев доступа к сайту в подарок,
                                что указано в договоре оферты, размещенном на сайте.
                            </p>
                            <p class="text-md">
                                Если вы не согласны с политикой возврата,
                                <a class="text-cyan-600 hover:underline" href="{{ route('contacts') }}">свяжитесь с нами</a>
                            </p>
                        </div>
                    </div>

                    <div x-data="{ isOpen: false }">
                        <button @click="isOpen = !isOpen"
                                class="w-full text-left bg-white p-4 rounded-lg shadow-md hover:bg-gray-50 focus:outline-none">
                            <h5 class="text-xl font-semibold text-gray-900">
                                Как написать отзыв, задать вопрос или сообщить о предложении по улучшению работы сайта?
                            </h5>
                        </button>
                        <div x-show="isOpen" class="p-4 bg-gray-50 rounded-lg mt-2">
                            <p class="text-md">
                                Мы будем рады услышать ваши отзывы, вопросы и предложения!
                                <a class="text-cyan-600 hover:underline" href="{{ route('contacts') }}">Свяжитесь с нами</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
