<table>
    <thead>
        <tr>
            <th>Tracking ID</th>
            <th>Category</th>
            <th>Owner</th>
            <th>Date Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->trackid }}</td>
                <td>{{ $ticket->category?->name ?? '-' }}</td>
                <td>{{ $ticket->owner?->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($ticket->dt)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
