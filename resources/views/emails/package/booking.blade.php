@component('mail::message')
# Confirmation flight ticket✈️

As-salamu alaykum

Dear {{ $packageBooking->first_name }} {{ $packageBooking->last_name }},

Thank you for choosing us to reserve package. We are dedicated to providing you with the best travel experience and hope that you have a safe and enjoyable trip. We value your business and look forward to serving you in the future. Thank you once again for choosing us

Here are the details:👇


@component('mail::button', ['url' => route('admin.package.invoice', ['id'=>$packageBooking->package_id, 'packageBooking'=> $packageBooking->id, 'number'=>$packageBooking->invoice_no])])
View
@endcomponent 

# Please double check that the passenger's name, date of travel, and destination are all accurate. This is crucial to ensure a smooth and successful trip for the passenger. Any errors or mistakes in this information Please contact immediately with travel agent


Thanks,
{{ config('app.name') }}
@endcomponent