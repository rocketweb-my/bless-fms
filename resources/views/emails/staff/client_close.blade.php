@component('mail::message')
Hello

A customer has just closed to a ticket. Ticket details:

Ticket subject: {!! $data['subject']!!}<br>
Tracking ID: {!! $data['trackid'] !!}

You can check the ticket here:

@component('mail::button', ['url' => route('ticket.reply',$data['trackid'])])
    Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
