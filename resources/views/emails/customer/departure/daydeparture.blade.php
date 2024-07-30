@component('mail::message')
  
# 🛫Are you ready for your trip to? {{ findCityName(end(json_decode($booking->routes)->itineraries[$id]->segments)->arrival->iataCode) }}

As-salamu alaykum 🤝

Dear {{ $booking->passengers[0]->firstname }} {{ $booking->passengers[0]->lastname }},

To ensure a smooth travel experience, here are a few things you should keep in mind to be ready to fly:😎

If you wish to change your travel dates🗓️, please get in touch with us🤙📲.

Price difference is determined by the airline's price when changing tickets.

The airline concerned no-shown the passenger if you do not report on time

🙏Please make sure flight schedule before departure. Visit airline website or contact your travel agent 

براہ کرم روانگی سے پہلے ائیر لائن کی ویب سائٹ سے پرواز کا شیڈول یقینی بنائیں 🕖 #۔.



Booking Reference: {{ $booking->pnr }}

@component('mail::button', ['url' => route('flight.ticket.show.passenger', ['id'=>$booking->id,'hash' => md5($booking->uri), 'pnr'=>$booking->pnr])])
View Ticket
@endcomponent

Wishing you a safe and pleasant journey! Bon voyage!🥰


For any questions or clarifications,
Please contact us at
Gondal Travel | Pèlerinages Hajj & Omra | Séjours culturels

🇫🇷 0187653786   
🇬🇧 00448007074285
🇺🇸 0018143008040

Best regards,
{{ config('app.name') }}
@endcomponent