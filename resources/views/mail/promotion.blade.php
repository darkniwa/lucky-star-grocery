@component('mail::message')
{!! $message !!}
@component('mail::button', ['url' => 'https://luckystargrocery.com/'])
    Visit Our Website
@endcomponent
@endcomponent