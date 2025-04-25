@extends('layouts.app')

@section('title', 'Konser')

@section('content')
<div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="col-md-12">
        <!--begin::Tambah Konser Baru-->
        <div class="card card-warning card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Edit Konser</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form action="{{ route('concerts.update', $concert) }}" method="POST">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <div class="mb-2 row align-items-center">
                        <label for="title" class="col-sm-3 col-form-label">Judul:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $concert->title) }}" required>
                        </div>
                    </div>
                    <div class="mb-2 row align-items-center">
                        <label for="artist" class="col-sm-3 col-form-label">Artis:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="artist" name="artist" value="{{ old('artist', $concert->artist) }}" required>
                        </div>
                    </div>
                    <div class="mb-2 row align-items-center">
                        <label for="date" class="col-sm-3 col-form-label">Tanggal dan Waktu:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="date" name="date" value="{{ old('date', $concert->date) }}" required>
                        </div>
                    </div>
                    <div class="mb-2 row align-items-center">
                        <label for="location" class="col-sm-3 col-form-label">Lokasi:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $concert->location) }}" required>
                        </div>
                    </div>
                    <div class="mb-2 row align-items-center">
                        <label for="banner" class="col-sm-3 col-form-label">URL Banner:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="banner" name="banner" value="{{ old('banner', $concert->banner) }}">
                        </div>
                    </div>

                    <!-- Ticket types section -->
                    <div class="mb-2 row">
                        <label class="col-sm-3 col-form-label">Jenis Tiket:</label>
                        <div class="col-sm-9">
                            <div id="ticket-types-container">
                                @foreach(old('tickets', $concert->ticketTypes->toArray()) as $index => $ticket)
                                <div class="ticket-type row mb-2">
                                    <input type="hidden" name="tickets[{{ $index }}][id]" value="{{ $ticket['id'] ?? '' }}">
                                    <div class="col-3">
                                        <input type="text" name="tickets[{{ $index }}][name]" class="form-control" placeholder="Nama" value="{{ $ticket['name'] }}" required>
                                    </div>
                                    <div class="col-2">
                                        <input type="number" name="tickets[{{ $index }}][price]" class="form-control" placeholder="Harga" min="0" step="0.01" value="{{ $ticket['price'] }}" required>
                                    </div>
                                    <div class="col-2">
                                        <input type="number" name="tickets[{{ $index }}][quota]" class="form-control" placeholder="Kuota" min="1" value="{{ $ticket['quota'] }}" required>
                                    </div>
                                    <div class="col-3">
                                        <select name="tickets[{{ $index }}][type]" class="form-control" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="standing" {{ $ticket['type'] == 'standing' ? 'selected' : '' }}>Standing</option>
                                            <option value="seated" {{ $ticket['type'] == 'seated' ? 'selected' : '' }}>Seated</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-danger btn-remove-ticket">Hapus</button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-ticket-type" class="btn btn-primary btn-sm">Tambah Jenis Tiket</button>
                        </div>
                    </div>
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a href="{{ route('concerts.index') }}" class="btn btn-secondary">Batal</a>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Quick Example-->
    </div>


</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('js/flatpickr-init.js') }}"></script>
<script src="{{ asset('js/ticket-types.js') }}"></script>
@endsection
