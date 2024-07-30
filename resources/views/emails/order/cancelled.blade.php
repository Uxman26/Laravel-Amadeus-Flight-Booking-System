@component('mail::message')

# As-salamu alaykum 🤝
Dear {{ $DailyReport->firstname }} {{ $DailyReport->lastname }},

Your Order Has Been Cancelled. 
Order No is : {{ $DailyReport->order_no }}. 

Click The Button To Re-Open Order
@component('mail::button', ['url' => route('booking.reopen_request', ['order_no'=>$DailyReport->order_no])])
Re-Open Order
@endcomponent
 

Your feedback is instrumental to improving our future service.

We look forward to welcoming you on board again soon.
 
Thank you in advance for your participation.

Best regards,
{{ config('app.name') }}
@endcomponent