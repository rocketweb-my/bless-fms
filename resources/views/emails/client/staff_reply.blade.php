@component('mail::message')
Hello

A staff has just replied to your ticket. Ticket details:

Ticket subject: {!! $data['subject']!!}<br>
Tracking ID: {!! $data['trackid'] !!}<br>
Message: {!! $message !!}

You can reply this ticket here:

@component('mail::button', ['url' => route('public.search')])
    Track Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
