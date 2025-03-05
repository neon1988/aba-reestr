@props(['url'])

<video
    id="my-player"
    controls
    preload="auto"
    data-setup='{}'
    {{ $attributes->merge(['class' => 'video-js vjs-fluid']) }}>
    <source src="{{ $url }}" type="video/mp4"></source>
    <p class="vjs-no-js"></p>
</video>

@pushOnce('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/8.21.1/video-js.min.css" rel="stylesheet">
@endPushOnce

@pushOnce('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/8.21.1/video.min.js"></script>
@endPushOnce

