@component('mail::message')
# 🛫Prepare yourself for departure someone is waiting for you! 

Get ready for your upcoming trip {{ findCityName(end(json_decode($booking->routes)->itineraries[$id]->segments)->arrival->iataCode) }}

As-salamu alaykum 🤝

Dear {{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }},

To ensure a smooth travel experience, here are a few things you should keep in mind to be ready to fly: 

Please make sure flight schedule before departure. Visit airline website or contact your travel agent
براہ کرم روانگی سے پہلے ائیر لائن کی ویب سائٹ سے پرواز کا شیڈول یقینی بنائیں۔🕖..

Verify the baggage 🧳allowance for your flight and pack accordingly. Check if you need to carry any essential items in your carry-on luggage and ensure they meet the airline's restrictions. 

Make sure you have all the necessary travel documents, such as your passport, boarding pass, and any required visas. Pack your bags with the items you'll need during your trip, including clothes, toiletries, medications, and any other personal belongings.👍

# 🛃Arrive at the airport early: It's advisable to arrive at the airport at least two hours before domestic flights and three hours before international flights. This will give you enough time to check in

Booking Reference: {{ $booking->pnr }}

@component('mail::button', ['url' => route('flight.ticket.show.passenger', ['id'=>$booking->id,'hash' => md5($booking->uri), 'pnr'=>$booking->pnr])])
View Ticket
@endcomponent

Bon voyage and have a fantastic trip!🥰

For any questions or clarifications,
Please contact us at
Gondal Travel | Pèlerinages Hajj & Omra | Séjours culturels

🇫🇷 0187653786   
🇬🇧 00448007074285
🇺🇸 0018143008040

Best regards,
{{ config('app.name') }}
@endcomponent