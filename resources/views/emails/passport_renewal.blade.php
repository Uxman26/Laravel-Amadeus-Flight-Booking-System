@component('mail::message')

# As-salamu alaykum 🤝
Dear {{ $firstname }} {{ $lastname }},

It is important that you know that your passport will expire very soon. If you would like to renew your passport before you face any difficulty on your journey, you may do so with us.



Thanks,
{{ config('app.name') }}
@endcomponent