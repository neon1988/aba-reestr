@extends('layouts.app')

@section('main')

    <div
        class="md:h-[28rem] mt-16 h-[42rem] pb-6 md:pb-0 flex items-center justify-center bg-gradient-radial to-[#004f6e] via-[#2e9ca6] from-[#5DABA4] w-full flex-col md:flex-row space-y-8 md:space-y-0 md:space-x-12">
        <!-- Логотип -->
        <div class="w-72 h-72 flex items-center justify-center md:ml-8 mt-8 md:mt-0">
            <x-image :url="Vite::asset('resources/images/logo_1200.png')" :width=300 :height=300 />
        </div>
        <!-- Текст -->
        <div class="text-center">
            <h1 class="text-3xl mx-3 md:text-4xl font-bold leading-tight mb-4 text-white text-center drop-shadow-md">
                СООБЩЕСТВО<br>
                ABA-СПЕЦИАЛИСТОВ<br>
                И РОДИТЕЛЕЙ
            </h1>
            <p class="text-lg md:text-xl mb-6 mx-3 text-white drop-shadow-md">
                Объединяем экспертов. Расширяем практику. Продвигаем науку.
            </p>
            <a href="{{ route('join') }}"
                class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded hover:bg-gray-100 transition drop-shadow-md">
                СТАТЬ ЧАСТЬЮ СООБЩЕСТВА
            </a>
        </div>
    </div>

    <section class="bg-gray-150 text-center my-10 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-start md:space-x-12 mb-4 font-normal text-lg text-gray-800">
            ABA Expert – это проект для поведенческих аналитиков, родителей детей с аутизмом, а также всех
            профессионалов, работающих в сфере аутизма и других нарушений развития.
            Здесь вы можете найти контакты квалифицированных специалистов, работающих в области ABA-терапии, разместить
            объявление, а также получить доступ к полезным видео-лекциям, пособиям для работы.
        </div>
        <div class="mx-auto px-4 lg:px-10 font-bold text-lg">
            Для специалистов и родителей!
        </div>
    </section>

    <div class="flex flex-col space-y-8 md:space-y-14 bg-white py-8 md:py-14">

        <section class="bg-white px-4 md:px-12">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-start md:space-x-12">
                <div class="md:w-1/2 md:mb-0 mb-6">
                    <a href="{{ route('specialists.index') }}">
                        <h2 class="text-2xl md:text-3xl font-bold mb-6">Реестр специалистов ABA</h2>
                    </a>
                    <p class="text-gray-800 mb-4 leading-relaxed">
                        Реестр ABA-специалистов на платформе ABA-EXPERT — это список проверенных специалистов,
                        работающих по
                        принципам прикладного анализа поведения.
                    </p>
                    <p class="text-gray-800 mb-4 leading-relaxed">
                        В него может попасть любой профессионал, вне зависимости от того, где он проходил обучение.
                    </p>
                    <p class="text-gray-800 leading-relaxed">
                        Участие в реестре — это знак качества, профессионального признания и важный шаг к укреплению
                        доверия
                        со стороны родителей, коллег и организаций.
                    </p>
                </div>
                <div class="md:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($specialists->take(2) as $specialist)
                        @include('specialists.card')
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-white px-4 md:px-12">
            <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row md:items-start md:space-x-12">
                <div class="md:w-1/2 flex items-center justify-center p-6">
                        <x-image :url="Vite::asset('resources/images/IBAO_CEU_Provider.png')" :width=300 :height=300 class="max-h-80" />
                </div>
                <div class="md:w-1/2 md:mb-0 mb-4 ">
                    <a href="{{ route('webinars.index') }}">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6">Вебинары</h2>
                    </a>
                    <p class="text-gray-800 mb-4 leading-relaxed">
                        На платформе ABA-EXPERT регулярно проходят вебинары с опытными специалистами и
                        сертифицированными аналитиками, где разбираются актуальные темы практики, методики и кейсы.</p>
                    <p class="text-gray-800 leading-relaxed">
                        За участие в вебинарах вы получаете баллы CEU (Continuing Education Units),
                        которые можно использовать для подтверждения профессионального развития и сертификации.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-white px-4 md:px-12">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-start md:space-x-12">
                <div class="md:w-1/2 md:mb-0 mb-4 ">
                    <a href="{{ route('worksheets.index') }}">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6">Материалы</h2>
                    </a>
                    <p class="text-gray-800 mb-4 leading-relaxed">
                        На ABA-EXPERT вы найдете уникальные материалы, разработанные
                        практикующими специалистами: шаблоны, чек-листы, видеопримеры,
                        инструкции и методические пособия.
                    </p>
                    <p class="text-gray-800 leading-relaxed">
                        Эти ресурсы доступны только участникам платформы и помогают применять ABA на практике эффективно
                        и профессионально.
                    </p>
                </div>
                <div class="md:w-1/2 flex items-center justify-center">
                    <x-image :url="Vite::asset('resources/images/materials.jpg')" :width=600 :height=600
                             class="rounded-lg" />
                </div>
            </div>
        </section>

        <section class="bg-white px-4 md:px-12">
            <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row md:items-start md:space-x-12">
                <div class="md:w-1/2 flex items-center justify-center">
                    <x-image :url="Vite::asset('resources/images/supervisia.jpg')" :width=600 :height=600
                             class="rounded-lg max-h-80"/>
                </div>
                <div class="md:w-1/2 md:mb-0 mb-4 ">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6">Супервизии</h2>
                    <p class="text-gray-800 mb-4 leading-relaxed">
                        На платформе ABA-EXPERT проходят регулярные супервизии с опытными поведенческими аналитиками,
                        где
                        можно разобрать реальные кейсы, задать вопросы и получить профессиональную обратную связь.
                    </p>
                    <p class="text-gray-800 leading-relaxed">
                        Это отличная возможность для практикующих специалистов расти, развивать навыки и получать
                        поддержку
                        в сложных ситуациях.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-white px-4 md:px-12">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-start md:space-x-12">
                <div class="md:w-1/2 md:mb-0 mb-4">
                    <a href="{{ route('conferences.index') }}">
                    <h2 class="text-2xl md:text-3xl font-bold mb-6">Форумы и конференции</h2>
                    </a>
                    <p class="text-gray-800 mb-4 leading-relaxed">
                        ABA-EXPERT организует профессиональные форумы и конференции, где специалисты могут обмениваться
                        опытом, обсуждать новейшие подходы и находить единомышленников.
                    </p>
                    <p class="text-gray-800 leading-relaxed">
                        Это площадки для живого общения, развития сообщества и укрепления профессиональных связей.
                    </p>
                </div>
                <div class="md:w-1/2 flex items-center justify-center">
                    <x-image :url="Vite::asset('resources/images/forums.jpg')" :width=600 :height=600
                             class="rounded-lg max-h-80"/>
                </div>
            </div>
        </section>
    </div>

@endsection
