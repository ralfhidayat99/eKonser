@extends('layouts.welcome')

@section('title', 'Concert Details')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 display-4 text-center">{{ $concert->title }}</h1>
    <div class="card mb-4 shadow-sm mx-auto" style="max-width: 900px;">
        <div class="row g-0">
            @if ($concert->banner)
            <div class="col-md-4">
                <img src="{{ $concert->banner }}" alt="Concert Banner" class="img-fluid rounded-start shadow-sm" style="height: 100%; object-fit: cover;">
            </div>
            @else
            <div class="col-md-4">
                <img src="{{ asset('assets/img/default-150x150.png') }}" alt="Default Banner" class="img-fluid rounded-start shadow-sm" style="height: 100%; object-fit: cover;">
            </div>
            @endif
            <div class="col-md-8">
                <div class="card-body d-flex flex-column justify-content-between h-100">
                    <div>
                        <h2 class="card-title fw-bold mb-3">{{ $concert->title }}</h2>
                        <ul class="list-unstyled text-muted mb-4" style="font-size: 1.1rem;">
                            <li><strong>Artist:</strong> {{ $concert->artist }}</li>
                            <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($concert->date)->format('F d, Y') }}</li>
                            <li><strong>Location:</strong> {{ $concert->location }}</li>
                            <li><strong>Quota:</strong> {{ $concert->quota }}</li>
                            <li><strong>Available Tickets:</strong> {{ $concert->available_tickets }}</li>
                            <li><strong>Price:</strong> Rp {{ number_format($concert->price, 0, ',', '.') }}</li>
                        </ul>
                    </div>
                    <div>
                        @auth
                        <div id="booking-message" class="mb-3"></div>
                        <form id="book-ticket-form" method="POST" action="{{ route('tickets.book', ['concert' => $concert->id]) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="ticket_type_id" class="form-label">Select Ticket Type</label>
                                <select class="form-select" id="ticket_type_id" name="ticket_type_id" required>
                                    @foreach ($concert->ticketTypes as $ticketType)
                                        <option value="{{ $ticketType->id }}" {{ $ticketType->available <= 0 ? 'disabled' : '' }}>
                                            {{ $ticketType->name }} - Rp {{ number_format($ticketType->price, 0, ',', '.') }} (Available: {{ $ticketType->available }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100" {{ $concert->ticketTypes->every(fn($t) => $t->available <= 0) ? 'disabled' : '' }}>
                                Book Ticket
                            </button>
                        </form>
                        @else
                        <p class="text-center text-secondary">Please <a href="{{ route('login') }}" class="text-primary">login</a> to book tickets.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ticket list -->
</div>
@endsection

@section('scripts')
@auth
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('book-ticket-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const ticketTypeId = formData.get('ticket_type_id');

        Swal.fire({
            title: 'Confirm Booking',
            text: 'Are you sure you want to book this ticket?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, book it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('tickets.book', ['concert' => $concert->id]) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ticket_type_id: ticketTypeId
                    })
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (status === 201) {
                        Swal.fire('Booked!', body.message, 'success');
                        // Optionally, update available tickets count or disable sold out options
                        const select = document.getElementById('ticket_type_id');
                        const option = select.querySelector(`option[value="${ticketTypeId}"]`);
                        if (option) {
                            let text = option.textContent;
                            const match = text.match(/\(Available: (\d+)\)/);
                            if (match) {
                                let available = parseInt(match[1], 10);
                                available = Math.max(available - 1, 0);
                                option.textContent = text.replace(/\(Available: \d+\)/, `(Available: ${available})`);
                                if (available === 0) {
                                    option.disabled = true;
                                }
                            }
                        }
                    } else {
                        Swal.fire('Error', body.error || 'An error occurred.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'An error occurred while booking the ticket.', 'error');
                });
            }
        });
    });
});
</script>
@endauth
@endsection
