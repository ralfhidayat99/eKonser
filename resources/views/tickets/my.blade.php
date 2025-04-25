@extends('layouts.welcome')

@section('title', 'My Booked Tickets')

@section('content')
    <div class="container mt-4">
        <h1>My Booked Tickets</h1>

        @if ($tickets->isEmpty())
            <p>You have not booked any tickets yet.</p>
        @else
            <div class="card p-3">
            <table id="ticketsTable" class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Concert</th>
                        <th>Artist</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Ticket Type</th>
                        <th>Ticket Code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->concert->title }}</td>
                            <td>{{ $ticket->concert->artist }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->concert->date)->format('F d, Y') }}</td>
                            <td>{{ $ticket->concert->location }}</td>
                            <td>{{ $ticket->ticketType ? $ticket->ticketType->name : 'N/A' }}</td>
                            <td>{{ $ticket->unique_code }}</td>
                            <td>
                                @if ($ticket->used)
                                    <span class="badge bg-danger">Used</span>
                                @else
                                    <span class="badge bg-success">Valid</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#ticketsTable').DataTable();
    });
</script>
@endsection
