@props(['url'])

<video controls {{ $attributes->merge(['class' => 'w-full rounded-lg']) }}>
    <source src="{{ $url }}">
    Ваш браузер не поддерживает тег <code>video</code>.
</video>
