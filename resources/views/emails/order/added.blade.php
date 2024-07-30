@component('mail::message')

# As-salamu alaykum 🤝
Dear {{ $order->firstname }} {{ $order->lastname }},

Your Order Has Been Received. 
Order No is : {{ $order->order_no }}. 
 

Your feedback is instrumental to improving our future service.

We look forward to welcoming you on board again soon.
 
Thank you in advance for your participation.

Best regards,
{{ config('app.name') }}
@endcomponent