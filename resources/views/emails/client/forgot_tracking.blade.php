@component('mail::message')
Dear {!! $tickets->first()->name !!},

This email contains a list of support tickets submitted with your email address. Number of support tickets found: {{$tickets->count()}}<br>

@component('mail::table')

@foreach($tickets as $index => $ticket)
{{$ticket->trackid}}<br>
@endforeach
@endcomponent
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
