@props(['url'])

<video {{ $attributes->merge([
    'class' => 'w-full rounded-lg',
    'controls' => 'controls',
    'controlsList' => 'nodownload',
    'oncontextmenu' => 'return false'
    ]) }}>
    <source src="{{ $url }}">
    Ваш браузер не поддерживает тег <code>video</code>.
</video>

<!-- Секция "Видео не воспроизводится?" с Alpine.js -->
<div class="mt-4" x-data="{ open: false }" x-cloak>
    <button @click="open = !open"
            class="w-full text-left text-cyan-600 font-semibold hover:text-cyan-800 transition-colors duration-200 focus:outline-none">
        Видео не воспроизводится?
    </button>
    <div x-show="open" class="mt-2 text-gray-700 border border-gray-300 rounded-md p-4 bg-gray-50 text-sm">
        <p>
            Для корректного просмотра видео рекомендуем использовать современные браузеры: Google Chrome,
            Яндекс.Браузер или Mozilla Firefox. Это обеспечит лучшее качество воспроизведения и стабильную
            работу всех функций сайта.
        </p>
        <p class="mt-2">
            Обратите внимание, что видео может загружаться с задержкой — пожалуйста, подождите некоторое время.
        </p>
        <p class="mt-2">
            Если после ожидания видео всё равно не загружается, пожалуйста,
            <a href="{{ route('contacts') }}" class="text-cyan-600 hover:text-cyan-800 underline">свяжитесь с нами</a>.
        </p>
    </div>
</div>

