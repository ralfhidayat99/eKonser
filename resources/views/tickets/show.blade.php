@extends('layouts.app')

@section('title', 'Ticket Details')

@section('content')
    <div class="container mt-4">
        <h1>Ticket Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $ticket->concert->title }}</h5>
                <p class="card-text"><strong>Artist:</strong> {{ $ticket->concert->artist }}</p>
                <p class="card-text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($ticket->concert->date)->format('F d, Y') }}</p>
                <p class="card-text"><strong>Location:</strong> {{ $ticket->concert->location }}</p>
                <p class="card-text"><strong>Ticket Code:</strong> {{ $ticket->unique_code }}</p>
                <p class="card-text"><strong>Status:</strong>
                    @if ($ticket->used)
                        <span class="badge bg-danger">Used</span>
                    @else
                        <span class="badge bg-success">Valid</span>
                    @endif
                </p>
                <a href="{{ route('tickets.my') }}" class="btn btn-secondary">Back to My Tickets</a>
            </div>
        </div>
    </div>
@endsection
