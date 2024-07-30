@component('mail::message')

# As-salamu alaykum 🤝
Dear {{ $DailyReport->firstname }} {{ $DailyReport->lastname }},

Your Order Has Been Completed. 
Order No is : {{ $DailyReport->order_no }}. 
 

Your feedback is instrumental to improving our future service.

We look forward to welcoming you on board again soon.
 
Thank you in advance for your participation.

Best regards,
{{ config('app.name') }}
@endcomponent