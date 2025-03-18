@php use Carbon\Carbon; @endphp
@props(['time'])

<span
    x-data="{ localTime: '' }"
    x-init="
        let utcDate = new Date('{{ Carbon::parse($time)->toISOString() }}');
        localTime = utcDate.toLocaleString('{{ config('app.locale') }}', {
            year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
    "
    x-text="localTime"
    {{ $attributes }}
></span>
