@php use Carbon\Carbon; @endphp
@props(['time', 'format' => 'D MMMM YYYY, HH:mm'])

<span {{ $attributes }}>
    {{ Carbon::parse($time)->locale(config('app.locale'))->isoFormat($format) }}
</span>
