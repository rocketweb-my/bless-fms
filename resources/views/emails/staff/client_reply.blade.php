@component('mail::message')
Hello

A customer has just replied to a ticket. Ticket details:

Ticket subject: {!! $data['subject']!!}<br>
Tracking ID: {!! $data['trackid'] !!}<br>
Message: {!! $data['message'] !!}

You can reply this ticket here:

@component('mail::button', ['url' => route('ticket.reply',$data['trackid'])])
    Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
