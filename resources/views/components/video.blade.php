@props(['url'])

<video controls {{ $attributes->merge(['class' => 'w-full rounded-lg']) }}>
    <source src="{{ $url }}">
    Ваш браузер не поддерживает тег <code>video</code>.
</video>

<!-- Секция "Видео не воспроизводится?" с Alpine.js -->
<div class="mt-4" x-data="{ open: false }">
    <button
        @click="open = !open"
        class="w-full text-left text-cyan-600 font-semibold hover:text-cyan-800 transition-colors duration-200 focus:outline-none"
    >
        Видео не воспроизводится?
    </button>
    <div x-show="open" class="mt-2 text-gray-700">
        Для корректного просмотра видео рекомендуем использовать современные браузеры: Google Chrome,
        Яндекс.Браузер или Mozilla Firefox.
        Это обеспечит лучшее качество воспроизведения и стабильную работу всех функций сайта.
    </div>
</div>
