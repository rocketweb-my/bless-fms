@component('mail::message')
Hello

A new support ticket has been assigned to you. Ticket details:

Ticket subject: {!! $data['subject']!!}<br>
Tracking ID: {!! $data['trackid'] !!}

You can manage this ticket here:

@component('mail::button', ['url' => route('ticket.reply',$data['trackid'])])
    Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
