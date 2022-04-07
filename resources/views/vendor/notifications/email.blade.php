
@component('mail::message')
<div class="email-main-content">
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
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
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
<p>{{__('email.copy_and_paste')}}</p> <a class="link-color" href="{{ $actionUrl }}">{{ $actionUrl }}</a> <p class="margin-top">{{__('email.have_any_questions')}}</p>
<p class="margin-top-30">{{__('email.thank_you')}}</p>
<p>{{__('email.choosing_us')}}</p>
@endcomponent
@endisset
</div>
@endcomponent
