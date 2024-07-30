@component('mail::message')

# As-salamu alaykum 🤝
Dear {{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }},

{!!$content!!}



Thanks,
{{ config('app.name') }}
@endcomponent