@component('mail::message')
# Ticket Issuance Reminder - Urgent

Hello Admin,

This is an urgent reminder regarding the issuance of a flight ticket. There are only 3 hours left to complete the booking process. Please take immediate action to issue the ticket for the following Reference Numbers:

@foreach ($pnrs as $pnr)
Booking Reference: {{ $pnr['pnr'] }} | Name: {{ $pnr['name'] }} | {{ $pnr['time'] }} <br>
@endforeach

@component('mail::button', ['url' => route('admin.booking.index')])
Go to Bookings
@endcomponent

Kindly ensure that the ticket is issued within the next 3 hours to avoid any inconvenience for the passenger. Once the ticket is issued, please notify the customer and provide them with the necessary information.

Thank you for your prompt attention to this matter.

Best regards,
{{ config('app.name') }}
@endcomponent