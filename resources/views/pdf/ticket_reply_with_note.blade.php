<html>
<head>
    <title>{{env('APP_NAME')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 20px;
        }

        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .ticket-table th {
            background-color: #f5f5f5;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        .ticket-table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }

        .ticket-header {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .conversation-section {
            margin-top: 30px;
        }

        .message-content {
            padding: 15px;
            border: 1px solid #ddd;
            margin: 10px 0;
            background-color: #fff;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #ddd;
        }

        .end-ticket {
            text-align: center;
            margin: 30px 0;
            color: #666;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Ticket Details Section -->
    <div class="ticket-header">
        <h2 style="margin: 0; color: #333;">Support Ticket #{{$ticket->trackid}}</h2>
    </div>
    <div class="conversation-section">
        <div class="section-title">Customer Details</div>
        <table class="ticket-table">
            <tbody>
                <tr>
                    <th>Contact Info</th>
                    <td>
                        <strong>{{$ticket->name}}</strong><br>
                        {{$ticket->email}}
                    </td>
                </tr>
                @for ($i = 1; $i <= 20; $i++)
                    @if ($ticket->{'custom' . $i})
                    <tr>
                        <th>{{ json_decode(\App\Models\CustomField::find($i)->name)->English }}</th>
                        <td>{{ $ticket->{'custom' . $i} }}</td>
                    </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>
    <div class="conversation-section">
        <div class="section-title">Ticket Details</div>
        <table class="ticket-table">
            <tbody>
                <tr>
                    <th width="20%">Subject</th>
                    <td><strong>{{$ticket->subject}}</strong></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{statusName($ticket->status)}}</td>
                </tr>
                <tr>
                    <th>Created</th>
                    <td>{{\Carbon\Carbon::parse($ticket->dt)->format('d-m-Y H:i:s')}}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{\Carbon\Carbon::parse($ticket->lastchange)->format('d-m-Y H:i:s')}}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{categoryName($ticket->category)->name}}</td>
                </tr>
                <tr>
                    <th>Assigned To</th>
                    <td>@if(findUser($ticket->owner)){{findUser($ticket->owner)->name}}@endif</td>
                </tr>
                <tr>
                    <th>Time Worked</th>
                    <td>{{$ticket->time_worked}}</td>
                </tr>
            </tbody>
        </table>
    </div>


    <!-- Original Message -->
    <div class="section-title">Original Message</div>
    <div class="message-content">
        {!! $ticket->message !!}
    </div>

    <!-- Conversation Section -->
    <div class="conversation-section">
        <div class="section-title">Notes</div>

        @foreach($notes as $note)
        <table class="ticket-table">
            <tbody>
                <tr>
                    <th width="20%">Date</th>
                    <td>{{\Carbon\Carbon::parse($note->dt)->format('d-m-Y g:i A')}}</td>
                </tr>
                <tr>
                    <th>From</th>
                    <td>{{$note->noteby->name}}</td>
                </tr>
            </tbody>
        </table>
        <div class="message-content">
            {!! $note->message !!}
        </div>
        @endforeach
    </div>

    <div class="end-ticket">
        --- End of ticket ---
        <div style="page-break-after: always;"></div>
    </div>
</body>
</html>
