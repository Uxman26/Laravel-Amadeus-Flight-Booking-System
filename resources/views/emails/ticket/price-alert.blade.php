@component('mail::message')
# Flight Price Alert

Hello Admin,

The System Found a Flight with Less Price Difference, here is the detail

Ticket PNR: {{ $data['pnr'] }} <br>
Current Flight: {{ $data['currentFlightCode'] }}<br>
New Flight: {{ $data['newFlightCode'] }}<br>
Current Price: {{ $data['currentPrice'] }}<br>
New Price: {{ $data['newPrice'] }}<br>

@component('mail::button', ['url' => route('admin.booking.index')])
Check in Booking Portal
@endcomponent

If you have any questions or need assistance, please don't hesitate to contact with Developer.

Thanks,
{{ config('app.name') }}
@endcomponent