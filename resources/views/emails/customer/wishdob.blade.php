@component('mail::message')
# Warm Birthday Wishes from {{ config('app.name') }}

Dear {{ $passenger->firstname }} {{ $passenger->lastname }},

Thank you for choosing Gondal Travel, and a very happy birthday to you! We hope your special day is filled with joy, laughter, and unforgettable moments. May this new year of your life bring you exciting adventures, incredible experiences, and wonderful travels. We look forward to assisting you with your future travel plans. Happy birthday and safe travels!



For any questions or clarifications,
Please contact us at
Gondal Travel | Pèlerinages Hajj & Omra | Séjours culturels

🇫🇷 0187653786   
🇬🇧 00448007074285
🇺🇸 0018143008040
Warmest regards,
{{ config('app.name') }}
@endcomponent