@php use Litlife\Url\Url; @endphp
@props(['url', 'width', 'height', 'quality'])

@php
    $url = is_string($url) ? $url : 'https://fs-thb03.getcourse.ru/fileservice/file/thumbnail/h/13466f741221f7be4c6975413c43c18f.png/s/f1200x/a/755389/sc/5'; // Замените 'default-url' на нужное значение по умолчанию
@endphp

<img
    src="{{ Url::fromString($url)->withQueryParameter('w', $width)->withQueryParameter('h', $height)->withQueryParameter('q', $quality) }}"
    {{ $attributes->merge(['class' => '', 'alt' => '']) }}
    srcset="
         {{ Url::fromString($url)->withQueryParameter('w', $width)->withQueryParameter('h', $height)->withQueryParameter('q', $quality) }} 100w,
         {{ Url::fromString($url)->withQueryParameter('w', $width * 2)->withQueryParameter('h', $height * 2)->withQueryParameter('q', $quality - 15) }} 200w,
         {{ Url::fromString($url)->withQueryParameter('w', $width * 3)->withQueryParameter('h', $height * 3)->withQueryParameter('q', $quality - 30) }} 300w"
    />
