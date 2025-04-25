@extends('layouts.app')

@section('title', 'Concert Details')

@section('content')
<div class="card shadow-sm " style="max-width: 100%;">
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
            <div class="card-body d-flex flex-column justify-content-start h-100">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="card-title fw-bold">{{ $concert->title }}</h2>
                        <a href="{{ route('concerts.edit', $concert->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <!-- delete concert button -->
                        <form method="POST" id="delete-concert-form" action="{{ route('concerts.destroy', $concert->id) }}" class="position-absolute delete-concert-form" style="bottom: 10px; right: 10px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    <dl class="row text-muted mb-4" style="font-size: 1.1rem;">
                        <dt class="col-sm-4">Artist:</dt>
                        <dd class="col-sm-8">{{ $concert->artist }}</dd>

                        <dt class="col-sm-4">Date:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($concert->date)->format('F d, Y') }}</dd>

                        <dt class="col-sm-4">Location:</dt>
                        <dd class="col-sm-8">{{ $concert->location }}</dd>

                        <dt class="col-sm-4">Kategori:</dt>
                        <dd class="col-sm-8">
                        </dd>
                        <hr>
                        <small class="text-center" style="margin-top: -10px;">Tiket</small>

                        @foreach($concert->ticketTypes as $ticketType)
                        <dt class="col-sm-4">{{ $ticketType->name }} ({{ ucfirst($ticketType->type) }})</dt>
                        <dd class="col-sm-8">
                            Quota: {{ $ticketType->quota }}<br>
                            Sold: {{ $ticketType->sold }}<br>
                            Available: {{ $ticketType->available }}<br>
                            Price: Rp {{ number_format($ticketType->price, 0, ',', '.') }}
                        </dd>
                        @endforeach


                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@auth
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('delete-concert-form');

        // SweetAlert confirmation for delete concert button click
        const deleteForms = document.querySelectorAll('.delete-concert-form');
        if (deleteForms.length > 0) {
            deleteForms.forEach(function(deleteForm) {
                const deleteButton = deleteForm.querySelector('button[type="submit"]');
                if (deleteButton) {
                    // Remove any existing submit event listeners on the form
                    deleteForm.onsubmit = null;
                    deleteButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Confirm Delete',
                            text: 'Are you sure you want to delete this concert?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteForm.submit();
                            }
                        });
                    });
                }
            });
        }
    });
</script>
@endauth
@endsection