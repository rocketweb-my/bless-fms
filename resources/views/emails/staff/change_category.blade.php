@component('mail::message')
Hello,

A new support ticket has been moved to new category. Ticket details:

Ticket subject: {!! $data['subject']!!}<br>
Tracking ID: {!! $data['trackid'] !!}<br>

You can check the ticket here:

@component('mail::button', ['url' => route('ticket.reply',$data['trackid'])])
    Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
