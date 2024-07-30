@component('mail::message')

# As-salamu alaykum 🤝
Dear {{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }},

We're committed to providing the best service possible and your feedback is an important part of our continuous improvement.


We'd like to hear more about your experience on your flight from {{ findCountryName(json_decode($booking->routes)->itineraries[$id]->segments[0]->departure->iataCode) }} ({{ findCityName(json_decode($booking->routes)->itineraries[$id]->segments[0]->departure->iataCode) }}) to {{ findCountryName(end(json_decode($booking->routes)->itineraries[0]->segments)->arrival->iataCode) }} ({{ findCityName(json_decode($booking->routes)->itineraries[$id]->segments[0]->arrival->iataCode) }}) on {{getFullDate(json_decode($booking->routes)->itineraries[$id]->segments[0]->departure->at)}}.
 

# Thinking only about this flight, please complete our short survey to share your feedback,Complain or Comments.

https://wa.me/message/P3IXRVOTT6KZO1

We really appreciate your support.  
 


Your feedback is instrumental to improving our future service.

We look forward to welcoming you on board again soon.
 
Thank you in advance for your participation.

Best regards,
{{ config('app.name') }}
@endcomponent