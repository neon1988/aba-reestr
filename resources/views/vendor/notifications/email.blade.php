@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# {{ __('Hello!') }}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
switch ($level) {
case 'success':
$color = 'green';
break;
case 'error':
$color = 'red';
break;
default:
$color = 'blue';
}
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{!! $line  !!}
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{ __('Sincerely yours') }}, [{{ __(config('app.name')) }}]({{ route('home') }})!
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
{{ __("If you're having trouble clicking the ':actionText' button, copy and paste the URL below into your web browser: :actionUrl", ['actionText' => $actionText, 'actionUrl' => $actionUrl]) }}
@endcomponent
@endisset
@endcomponent
