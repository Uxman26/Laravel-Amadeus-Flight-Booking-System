@component('mail::message')
# Confirmation flight ticket✈️

As-salamu alaykum

Dear {{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }},

Thank you for choosing us to book your flight ticket. We are dedicated to providing you with the best travel experience and hope that you have a safe and enjoyable trip. We value your business and look forward to serving you in the future. Thank you once again for choosing us

Here are the details:👇

Booking Reference: {{ $booking->pnr }}

@component('mail::button', ['url' => route('flight.ticket.show.passenger', ['id'=>$booking->id,'hash' => md5($booking->uri), 'pnr'=>$booking->pnr])])
View Ticket
@endcomponent

# Please double check that the passenger's name, date of travel, and destination are all accurate. This is crucial to ensure a smooth and successful trip for the passenger. Any errors or mistakes in this information Please contact immediately with travel agent


Thanks,
{{ config('app.name') }}
@endcomponent