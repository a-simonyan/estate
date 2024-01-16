@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# {{__('email.Hello!')}}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{__('email.'.$line)}}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ __('email.'.$actionText)}}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{__('email.'.$line)}}
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{__('email.'.$salutation)}}
@else
{{__('email.Regards')}}
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@endslot
@endisset
@endcomponent
