@component('mail::message')
# Email kontaktowy

Wiadomość ze strony "example-app" <br />
{{ $message }}

@component('mail::button', ['url' => config('app.url')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
