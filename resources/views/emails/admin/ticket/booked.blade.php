@component('mail::message')
# Flight Ticket Booking Notification

Hello Admin.

A flight ticket has been booked on your website. Here are the details:

Booking Reference: {{ $booking->pnr }}
Passenger Name: {{ $passenger->firstname }} {{ $passenger->lastname }}

@component('mail::button', ['url' => route('flight.ticket.show.passenger', ['id'=>$booking->id,'hash' => md5($booking->uri), 'pnr'=>$booking->pnr])])
View Ticket
@endcomponent

Please take the necessary actions to ensure a smooth travel experience for the customer.

Best regards,
{{ config('app.name') }}
@endcomponent