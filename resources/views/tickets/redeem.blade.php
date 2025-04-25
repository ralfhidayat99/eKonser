@extends('layouts.app')

@section('title', 'Redeem Ticket')

@section('content')
<div class="container mt-4">
    <div class="card p-4">
    <form id="redeem-ticket-form" method="POST" action="{{ route('tickets.redeem') }}">
        @csrf
        <div class="mb-3">
            <label for="unique_code" class="form-label">Ticket Code</label>
            <input type="text" class="form-control" id="unique_code" name="unique_code" required>
        </div>
        <button type="submit" class="btn btn-primary">Redeem</button>
    </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('redeem-ticket-form');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const url = form.action;
            const token = form.querySelector('input[name="_token"]').value;
            const uniqueCode = form.unique_code.value;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        unique_code: uniqueCode
                    })
                })
                .then(response => response.json().then(data => ({
                    status: response.status,
                    body: data
                })))
                .then(({
                    status,
                    body
                }) => {
                    if (status === 200) {
                        Swal.fire({
                            title: 'Success',
                            text: body.message,
                            icon: 'success'
                        });
                        form.reset();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: body.error || 'An error occurred.',
                            icon: 'error'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while redeeming the ticket.',
                        icon: 'error'
                    });
                });
        });
    });
</script>
@endsection