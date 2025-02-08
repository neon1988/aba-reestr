@php use Illuminate\Support\Facades\Vite; use Litlife\Url\Url; @endphp
@props(['url', 'width', 'height', 'quality'])

@php
    $url = is_string($url) ? $url : Vite::asset('resources/images/logo_236.png'); // Замените 'default-url' на нужное значение по умолчанию
@endphp

<img
    src="{{ Url::fromString($url)->withQueryParameter('w', $width)->withQueryParameter('h', $height)->withQueryParameter('q', $quality) }}"
    {{ $attributes->merge(['class' => '', 'alt' => '']) }}
    srcset="
         {{ Url::fromString($url)->withQueryParameter('w', $width)->withQueryParameter('h', $height)->withQueryParameter('q', $quality) }} 100w,
         {{ Url::fromString($url)->withQueryParameter('w', $width * 2)->withQueryParameter('h', $height * 2)->withQueryParameter('q', $quality - 15) }} 200w,
         {{ Url::fromString($url)->withQueryParameter('w', $width * 3)->withQueryParameter('h', $height * 3)->withQueryParameter('q', $quality - 30) }} 300w"
/>
