<table style="width:100% !important; border-collapse:collapse; margin-bottom:20px; font-family:Arial, sans-serif; font-size:12px;">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th style="text-align:left; padding:8px; border:1px solid #ddd; font-weight:bold;">No.</th>
            <th style="text-align:left; padding:8px; border:1px solid #ddd; font-weight:bold;">Tracking ID</th>
            <th style="text-align:left; padding:8px; border:1px solid #ddd; font-weight:bold;">Category</th>
            <th style="text-align:left; padding:8px; border:1px solid #ddd; font-weight:bold;">Owner</th>
            <th style="text-align:left; padding:8px; border:1px solid #ddd; font-weight:bold;">Priority</th>
            <th style="text-align:left; padding:8px; border:1px solid #ddd; font-weight:bold;">Status</th>
            <th style="text-align:left; padding:8px; border:1px solid #ddd; font-weight:bold;">Date Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
            <tr style="background-color:{{ $loop->even ? '#f9f9f9' : 'transparent' }};">
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">{{ $loop->iteration }}</td>
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">{{ $ticket->trackid }}</td>
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">{{ $ticket->category_detail?->name ?? '-' }}</td>
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">{{ $ticket->owner_detail?->name ?? '-' }}</td>
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">{{ $ticket->priority_detail ?? '-' }}</td>
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">{{ $ticket->status_detail ?? '-' }}</td>
                <td style="padding:8px; border:1px solid #ddd; text-align:left;">{{ \Carbon\Carbon::parse($ticket->dt)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
