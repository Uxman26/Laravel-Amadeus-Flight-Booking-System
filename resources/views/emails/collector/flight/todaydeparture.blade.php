@component('mail::message')
# Departure Alert - Immediate Action Required

Hello Admin,

This email serves as an important alert regarding upcoming flight departures within the next 24 hours. Please review the following flights and take immediate action to contact the passengers, advising them to prepare for their journey:

@foreach ($pnrs as $pnr)
Booking Reference: {{ $pnr['pnr'] }} {{ $pnr['time'] }}
@endforeach

@component('mail::button', ['url' => route('admin.booking.index')])
Go to Bookings
@endcomponent

Please ensure you promptly communicate with the respective passengers, providing them with any important updates, reminders, or instructions related to their upcoming flights. It is crucial to assist them in being well-prepared and ready for departure.

Thank you for your immediate attention and proactive approach to ensuring a smooth travel experience for our valued passengers.

Best regards,
{{ config('app.name') }}
@endcomponent