@extends('layouts.app')

@section('title', 'Ticket List')

@section('content')

<div class="container">
    <form method="GET" action="{{ route('tickets.index') }}">
        <div class="mb-3 d-flex align-items-end gap-2">
            <div class="flex-grow-1">
                <label for="concertDropdown" class="form-label">Select Concert</label>
                <select id="concertDropdown" class="form-select" name="concert_id">
                    <option value="">-- Select a Concert --</option>
                    @foreach ($concerts as $concert)
                    <option value="{{ $concert->id }}" {{ (isset($concertId) && $concertId == $concert->id) ? 'selected' : '' }}>{{ $concert->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary ">Search</button>
            </div>
        </div>
    </form>
    <!--begin::Row-->
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm rounded bg-primary text-white p-3 d-flex align-items-center">
                <span class="info-box-icon me-3 fs-3">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text fw-semibold">Sold Tickets</span>
                    <span class="info-box-number fs-4" id="soldTicketsCount">
                        {{ $soldTicketsCount }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm rounded bg-success text-white p-3 d-flex align-items-center">
                <span class="info-box-icon me-3 fs-3">
                    <i class="bi bi-cart-check-fill"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text fw-semibold">Unused Tickets</span>
                    <span class="info-box-number fs-4" id="unusedTicketsCount">{{ $unusedTicketsCount }}</span>
                </div>
            </div>
        </div>
    </div>
    <!--end::Row-->

    @foreach ($groupedTickets as $ticketTypeName => $tickets)
    <div class="card p-4 mt-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">{{ $ticketTypeName }}</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover ticketsTable" data-ticket-type="{{ $ticketTypeName }}">
                <thead class="table-dark">
                    <tr>
                        <th>User Name</th>
                        <th>Ticket Code</th>
                        <th>Concert Title</th>
                        <th>Used</th>
                        <th>Redeemed At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->user->name ?? 'N/A' }}</td>
                        <td>{{ $ticket->unique_code }}</td>
                        <td>{{ $ticket->concert->title ?? 'N/A' }}</td>
                        <td>
                            @if ($ticket->used)
                            <span class="badge bg-danger d-flex align-items-center">
                                <i class="bi bi-x-circle-fill me-1"></i> Yes
                            </span>
                            @else
                            <span class="badge bg-success d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-1"></i> No
                            </span>
                            @endif
                        </td>
                        <td>
                            @if ($ticket->redeemed_at)
                            {{ $ticket->redeemed_at->format('d-m-Y H:i:s') }}
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center fst-italic">No tickets found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</div>

@endsection
