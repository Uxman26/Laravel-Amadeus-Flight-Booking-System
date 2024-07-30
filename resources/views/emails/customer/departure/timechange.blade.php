@component('mail::message')
    # As-salamu alaykum 🤝
    Dear {{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }},

    Please be informed that your flight from
    {{ findCountryName(json_decode($booking->routes)->itineraries[$id]->segments[0]->departure->iataCode) }} to
    {{ findCountryName(end(json_decode($booking->routes)->itineraries[0]->segments)->arrival->iataCode) }}
    time has been changed. Kindly see the following changes on your schedule:

    Your feedback is instrumental to improving our future service.

    We look forward to welcoming you on board again soon.

    Thank you in advance for your participation.

    Best regards,
    {{ config('app.name') }}
@endcomponent
