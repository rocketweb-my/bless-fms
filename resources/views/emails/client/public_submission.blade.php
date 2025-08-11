@component('mail::message')
Dear {!! $data['name'] !!},

Your support ticket {!! $data['subject'] !!} has been submitted.

We reply to all tickets as soon as possible, within 24 to 48 hours. If we expect your ticket will take additional time, we will update you by sending you an email.

Ticket tracking ID: {!! $data['trackid'] !!}

You can view the status of your ticket here:

@component('mail::button', ['url' => route('public.search')])
    Track Ticket
@endcomponent

You will receive an email notification when our staff replies to your ticket.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
